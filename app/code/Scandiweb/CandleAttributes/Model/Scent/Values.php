<?php

namespace Scandiweb\CandleAttributes\Model\Scent;

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
            ['label' => 'Oreo', 'value' => '1'],
            ['label' => 'Bacon', 'value' => '2'],
            ['label' => 'Vanilla', 'value' => '3'],
            ['label' => 'Coconut', 'value' => '4'],
            ['label' => 'Tea Tree', 'value' => '5'],
            ['label' => 'Allspice', 'value' => '6'],
            ['label' => 'Daffodil', 'value' => '7'],
            ['label' => 'Orange', 'value' => '8'],
            ['label' => 'Citron', 'value' => '9'],
            ['label' => 'Maple', 'value' => '10'],
            ['label' => 'Sassafra', 'value' => '11']
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
