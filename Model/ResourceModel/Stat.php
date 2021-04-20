<?php
namespace Sga\Stats\Model\ResourceModel;

use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;
use Sga\Stats\Api\Data\StatInterface as ModelInterface;

class Stat extends AbstractDb
{
    protected $_storeManager;
    protected $_entityManager;
    protected $_metadataPool;

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null
    ) {
        $this->_storeManager = $storeManager;
        $this->_entityManager = $entityManager;
        $this->_metadataPool = $metadataPool;

        parent::__construct($context, $connectionName);
    }

    protected function _construct()
    {
        $this->_init('sga_stats_stat','stat_id');
    }

    public function load(AbstractModel $object, $value, $field = null)
    {
        $this->_entityManager->load($object, (int)$value);
        $this->unpackData($object);
        return $this;
    }

    public function unpackData(AbstractModel $object)
    {
        /*if (is_string($object->getCategoryIds())) {
            $object->setCategoryIds(explode(',', $object->getCategoryIds()));
        }*/
    }

    public function save(AbstractModel $object)
    {
        $this->packData($object);
        $this->_entityManager->save($object);
        return $this;
    }

    public function packData(AbstractModel $object)
    {
        /*if (is_array($object->getCategoryIds())) {
            $object->setCategoryIds(implode(',', $object->getCategoryIds()));
        }*/
    }

    public function delete(AbstractModel $object)
    {
        $this->_entityManager->delete($object);
        return $this;
    }
    
}
