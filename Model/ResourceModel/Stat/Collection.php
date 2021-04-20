<?php
namespace Sga\Stats\Model\ResourceModel\Stat;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Sga\Stats\Model\Stat as Model;
use Sga\Stats\Model\ResourceModel\Stat as ResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'stat_id';

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);

    }

}