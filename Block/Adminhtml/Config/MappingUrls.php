<?php
namespace Sga\Stats\Block\Adminhtml\Config;

use Magento\Framework\DataObject;

class MappingUrls extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    public function _prepareToRender()
    {
        $this->addColumn(
            'code',
            [
                'label' => __('Code'),
                'style' => 'width:150px',
            ]
        );
        $this->addColumn(
            'url',
            [
                'label' => __('Url'),
                'style' => 'width:300px',
            ]
        );
    }

    public function getArrayRows()
    {
        $this->_fixMissingColumn();
        return parent::getArrayRows();
    }

    protected function _fixMissingColumn()
    {
        $element = $this->getElement();
        $values = $element->getValue();
        if ($values && is_array($values)) {
            foreach ($values as $rowId => $row) {
                foreach ($this->getColumns() as $key => $column) {
                    if (!isset($row[$key])) {
                        $values[$rowId][$key] = '';
                    }
                }
            }
            $element->setValue($values);
        }
    }
}
