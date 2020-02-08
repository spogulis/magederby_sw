<?php

namespace Scandiweb\RestrictCheckout\Observer;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Exception\PaymentException;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class BeforeCheckoutCustomerValidate implements ObserverInterface
{
    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /** @var LoggerInterface  */
    protected $logger;

    /** @var ManagerInterface  */
    protected $messageManager;

    /** @var CollectionFactory  */
    protected $orderCollectionFactory;

    /** @var Session  */
    protected $checkoutSession;

    /**
     * Add constructor.
     * @param CustomerSession $customerSession
     * @param LoggerInterface $logger
     * @param ManagerInterface $messageManager
     * @param CollectionFactory $orderCollectionFactory
     * @param Session $checkoutSession
     */
    public function __construct(
        CustomerSession $customerSession,
        LoggerInterface $logger,
        ManagerInterface $messageManager,
        CollectionFactory $orderCollectionFactory,
        Session $checkoutSession)
    {
        $this->customerSession = $customerSession;
        $this->logger = $logger;
        $this->messageManager = $messageManager;
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Prevents order from going through if customers has ordered 5 items in the last year or current card item quantity
     * amount combined with past amount equals 6
     */
    public function execute(Observer $observer) {
        $customer = $this->customerSession->getCustomer();
        $isCustomerVip = $customer->getData('is_approved');
        if (!$isCustomerVip) {
            throw new PaymentException(__('Dear customer, in order to buy the products in your cart, you need to be an approved VIP customer'));
        }

        // Get orders for the last year
        $time = strtotime("-1 year", time());
        $date = date("Y-m-d", $time);
        $orders = $this->getOrderCollectionByDate($customer->getId(), $date);

        // Get bought item count from all orders in the last year
        $totalItemsBoughtForCurrentYear = 0;
        foreach ($orders->getItems() as $order) {
            foreach($order->getItems() as $item) {
                $totalItemsBoughtForCurrentYear += 1;
            }
        }
        $firstCustomerOrderForCurrentYear = $orders->getFirstItem()->getData();
        $dateOfFirstOrderForCurrentYear = count($firstCustomerOrderForCurrentYear) !== 0 ? $firstCustomerOrderForCurrentYear['created_at'] : false;
        $errorMessage = 'Dear customer, our luxury candles are available in limited quantity (5 per year per customer).';
        if (!is_bool($dateOfFirstOrderForCurrentYear)) {
            $errorMessage .= 'You can order your next item after'. $dateOfFirstOrderForCurrentYear;
        }

        $cartItems = $this->checkoutSession->getQuote()->getItems();
        if ($totalItemsBoughtForCurrentYear === 5 || $totalItemsBoughtForCurrentYear + count($cartItems) > 5) {
            throw new PaymentException(__($errorMessage));
        }
    }

    /**
     * Returns customer order collection for the last year
     */
    private function getOrderCollectionByDate($customerId, $from)
    {
        $collection = $this->orderCollectionFactory->create($customerId)
            ->addFieldToSelect('*')
            ->addAttributeToFilter('created_at', array('from' => $from))
            ->setOrder(
                'created_at',
                'desc'
            );

        return $collection;
    }
}
