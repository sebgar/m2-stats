<?php
namespace Sga\Stats\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    protected $_scopeConfig;

    const XML_PATH_ENABLED = 'sga_stats/general/enabled';
    const XML_PATH_PARAMS = 'sga_stats/general/params';
    const XML_PATH_MAPPING_URLS = 'sga_stats/general/mapping_urls';

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Context $context
    ){
        $this->_scopeConfig = $scopeConfig;

        parent::__construct($context);
    }

    public function isEnabled($store = null)
    {
        return $this->_scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    public function getParams($store = null)
    {
        $str = $this->scopeConfig->getValue(
            self::XML_PATH_PARAMS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
        return explode(',', $str);
    }

    public function getMappingUrls($store = null)
    {
        $str = $this->scopeConfig->getValue(
            self::XML_PATH_MAPPING_URLS,
            ScopeInterface::SCOPE_STORE,
            $store
        );
        return json_decode($str, true);
    }
}
