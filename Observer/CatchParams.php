<?php
namespace Sga\Stats\Observer;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\SessionFactory as CustomerSessionFactory;
use Sga\Stats\Helper\Config as ConfigHelper;
use Sga\Stats\Model\StatFactory;
use Sga\Stats\Model\ResourceModel\Stat\CollectionFactory as StatCollectionFactory;

class CatchParams implements ObserverInterface
{
    protected $_logger;
    protected $_request;
    protected $_configHelper;
    protected $_statFactory;
    protected $_statCollectionFactory;

    protected $_customerSession;

    public function __construct(
        LoggerInterface $logger,
        RequestInterface $request,
        ConfigHelper $configHelper,
        StatFactory $statFactory,
        StatCollectionFactory $statCollectionFactory,
        CustomerSessionFactory $customerSessionFactory
    ) {
        $this->_logger = $logger;
        $this->_request = $request;
        $this->_configHelper = $configHelper;
        $this->_statFactory = $statFactory;
        $this->_statCollectionFactory = $statCollectionFactory;

        $this->_customerSession = $customerSessionFactory->create();
    }

    public function execute(Observer $observer)
    {
        if (!$this->_configHelper->isEnabled()) {
            return;
        }

        // keep current session_id in case customer logged in
        if ((string)$this->_customerSession->getData('current_id') === '') {
            $this->_customerSession->setData('current_id', $this->_customerSession->getSessionId());
        }

        if ($this->_catchUtms() !== null) {
            $this->_parseUrls();
        }
    }

    protected function _catchUtms()
    {
        $list = $this->_configHelper->getParams();

        // has params in request
        $params = [];
        foreach ($list as $utmCode) {
            $v = $this->_request->getParam($utmCode);
            if ($v) {
                $params[$utmCode] = $v;
            }
        }

        // if no params already in session save it
        $paramsSession = $this->_customerSession->getData('params');
        if (count($params) > 0 && $paramsSession === null) {
            $this->_customerSession->setData('params', $params);
        }

        return $this->_customerSession->getData('params');
    }

    protected function _parseUrls()
    {
        try {
            $requestUri = $this->_request->getRequestUri();
            $pathInfo = $this->_request->getPathInfo();
            $mappingUrls = $this->_configHelper->getMappingUrls();
            if (is_array($mappingUrls)) {
                foreach ($mappingUrls as $mappingUrl) {
                    if (($requestUri !== '' && preg_match('#^'.str_replace('*', '.*', $mappingUrl['url']).'$#', $requestUri))
                        || ($pathInfo !== '' && preg_match('#^'.str_replace('*', '.*', $mappingUrl['url']).'$#', $pathInfo))
                    ) {
                        $stat = $this->_statCollectionFactory->create()
                            ->addFieldToFilter('session_id', $this->_customerSession->getData('current_id'))
                            ->addFieldToFilter('code', $mappingUrl['code'])
                            ->getFirstItem();

                        if ($stat && (int)$stat->getId() > 0) {
                            $stat->setCounter((int)$stat->getCounter() + 1);
                        } else {
                            $stat = $this->_statFactory->create()
                                ->setSessionId($this->_customerSession->getData('current_id'))
                                ->setCode($mappingUrl['code'])
                                ->setCounter(1)
                                ->setParams(json_encode($this->_customerSession->getData('params')));
                        }

                        $stat->save();
                    }
                }
            }
        } catch (\Exception $e) {
            $this->_logger->error($e->getMessage());
        }
    }
}
