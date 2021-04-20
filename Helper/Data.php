<?php
namespace Sga\Stats\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Sga\Stats\Model\ResourceModel\Stat\CollectionFactory as StatCollectionFactory;
use Sga\Stats\Helper\Config as ConfigHelper;

class Data extends AbstractHelper
{
    const UTMS = ['utm_source', 'utm_campaign', 'utm_angle', 'utm_target', 'utm_medium', 'utm_content'];

    protected $_statCollectionFactory;
    protected $_configHelper;

    public function __construct(
        Context $context,
        StatCollectionFactory $statCollectionFactory,
        ConfigHelper $configHelper
    ) {
        $this->_statCollectionFactory = $statCollectionFactory;
        $this->_configHelper = $configHelper;

        parent::__construct($context);
    }

    public function generateReports()
    {
        $stats = $this->_statCollectionFactory->create();

        $headers = $this->_getHeaders();

        $lines = [];
        foreach ($stats as $stat) {
            if (!isset($lines[$stat->getSessionId()])) {
                $lines[$stat->getSessionId()] = $headers;
            }

            // set code / counter
            $lines[$stat->getSessionId()][$stat->getCode()] = $stat->getCounter();

            // add utms
            $utms = json_decode($stat->getUtms());
            if (is_array($utms)) {
                foreach ($utms as $k => $v) {
                    $lines[$stat->getSessionId()][$k] = $v;
                }
            }
        }

        // convert as csv
        foreach ($lines as $sessionId => $data) {
            // escape enclosure
            $data = array_map(
                function ($v) {
                    return str_replace('"', '""', $v);
                },
                array_values($data)
            );

            $lines[$sessionId] = '"'.implode('","', $data).'"';
        }

        // add headers
        array_unshift($lines, '"'.implode('","', array_keys($headers)).'"');

        return implode("\n", $lines);
    }

    protected function _getHeaders()
    {
        $headers = [];

        // add utm
        foreach (self::UTMS as $utm) {
            $headers[$utm] = '';
        }

        // add all code
        $mappingUrls = $this->_configHelper->getMappingUrls();
        if (is_array($mappingUrls)) {
            foreach ($mappingUrls as $mappingUrl) {
                $headers[$mappingUrl['code']] = '';
            }
        }

        return $headers;
    }
}
