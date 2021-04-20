<?php
namespace Sga\Stats\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Sga\Stats\Api\Data\StatInterface as ModelInterface;
use Sga\Stats\Model\ResourceModel\Stat as ResourceModel;

class Stat extends AbstractModel implements IdentityInterface, ModelInterface
{
    const CACHE_TAG = 'stats_stat';

    protected $_eventPrefix = 'stats_stat';

    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getStatId()
    {
        return $this->getData(self::STAT_ID);
    }

    public function setStatId($id)
    {
        return $this->setData(self::STAT_ID, $id);
    }

    public function getSessionId()
    {
        return $this->getData(self::SESSION_ID);
    }

    public function setSessionId($value)
    {
        return $this->setData(self::SESSION_ID, $value);
    }

    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    public function setCode($value)
    {
        return $this->setData(self::CODE, $value);
    }

    public function getParams()
    {
        return $this->getData(self::PARAMS);
    }

    public function setParams(array $value)
    {
        return $this->setData(self::PARAMS, $value);
    }

    public function getCounter()
    {
        return $this->getData(self::COUNTER);
    }

    public function setCounter($value)
    {
        return $this->setData(self::COUNTER, $value);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($value)
    {
        return $this->setData(self::CREATED_AT, $value);
    }


}
