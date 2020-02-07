<?php


namespace Scandiweb\RestrictCheckout\Setup;


use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $eavConfig;
    /**
     * @inheritDoc
     */

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'is_approved',
            [
                'type'         => 'int',
                'label'        => 'IS APPROVED',
                'input'        => 'boolean',
                'default'      => false,
                'required'     => false,
                'visible'      => true,
                'user_defined' => true,
                'position'     => 999,
                'system'       => 0,
            ]
        );

        $eavSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            'is_approved');

        $isApprovedAttribute = $this->eavConfig->getAttribute(Customer::ENTITY, 'is_approved');
        $isApprovedAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer']

        );
        $isApprovedAttribute->save();
    }
}
