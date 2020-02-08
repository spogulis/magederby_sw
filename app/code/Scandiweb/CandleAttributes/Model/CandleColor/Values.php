<?php

namespace Scandiweb\CandleAttributes\Model\CandleColor;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\DB\Ddl\Table;


class Values extends AbstractSource
{

    protected $optionFactory;

    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

    public function getAllOptions()
    {

        $this->_options = [
            ['label' => 'Pear', 'value' => '1'],
            ['label' => 'Orchid', 'value' => '2'],
            ['label' => 'Red', 'value' => '3'],
            ['label' => 'White', 'value' => '4'],
            ['label' => 'Orange', 'value' => '5'],
            ['label' => 'Viridian', 'value' => '6'],
            ['label' => 'Amaranth', 'value' => '7'],
            ['label' => 'Desert Sand', 'value' => '8'],
            ['label' => 'Salmon', 'value' => '9'],
            ['label' => 'Baby Blue', 'value' => '10']
        ];
        return $this->_options;
    }

    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        return [
            $attributeCode => [
                'unsigned' => false,
                'default' => null,
                'extra' => null,
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Custom Attribute Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}
