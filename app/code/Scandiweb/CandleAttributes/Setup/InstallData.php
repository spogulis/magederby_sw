<?php
namespace Scandiweb\CandleAttributes\Setup;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CategoryFactory
     */
    private $categoryFactory;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * InstallData constructor.
     * @param CollectionFactory $collectionFactory
     * @param CategoryFactory $categoryFactory
     * @param CategoryRepositoryInterface $categoryRepository
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CategoryFactory $categoryFactory,
        CategoryRepositoryInterface $categoryRepository,
        EavSetupFactory $eavSetupFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->categoryFactory = $categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->removeAttribute(Product::ENTITY, 'angle');

        $eavSetup->addAttribute(
            Product::ENTITY, 'angle', [
                'type' => 'int',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'label' => 'Angle',
                'input' => 'select',
                'class' => 'angle',
                'source' => 'Scandiweb\CandleAttributes\Model\Angle\Values',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => '0',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => true
            ]
        );

        $eavSetup->removeAttribute(Product::ENTITY, 'first_candle_color');

        $eavSetup->addAttribute(
            Product::ENTITY, 'first_candle_color', [
                'type' => 'int',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'label' => 'First Candle Color',
                'input' => 'select',
                'class' => 'first_candle_color',
                'source' => 'Scandiweb\CandleAttributes\Model\CandleColor\Values',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => '1',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => true
            ]
        );

        $eavSetup->removeAttribute(Product::ENTITY, 'second_candle_color');

        $eavSetup->addAttribute(
            Product::ENTITY, 'second_candle_color', [
                'type' => 'int',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'label' => 'Second Candle Color',
                'input' => 'select',
                'class' => 'second_candle_color',
                'source' => 'Scandiweb\CandleAttributes\Model\CandleColor\Values',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => '1',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => true
            ]
        );

        $eavSetup->removeAttribute(Product::ENTITY, 'size');

        $eavSetup->addAttribute(
            Product::ENTITY, 'size', [
                'type' => 'int',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'label' => 'Size',
                'input' => 'select',
                'class' => 'size',
                'source' => 'Scandiweb\CandleAttributes\Model\Size\Values',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => '1',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => true
            ]
        );

        $eavSetup->removeAttribute(Product::ENTITY, 'scent');

        $eavSetup->addAttribute(
            Product::ENTITY, 'scent', [
                'type' => 'int',
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'label' => 'Scent',
                'input' => 'select',
                'class' => 'scent',
                'source' => 'Scandiweb\CandleAttributes\Model\Scent\Values',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'default' => '1',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'unique' => true
            ]
        );

        $setup->endSetup();
    }
}
