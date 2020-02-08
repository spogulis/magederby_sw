<?php

namespace Scandiweb\CandleAttributes\Model\Size;

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
            ['label' => 'Small', 'value' => '1'],
            ['label' => 'Medium', 'value' => '2'],
            ['label' => 'Large', 'value' => '3']
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
