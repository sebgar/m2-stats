<?php
namespace Sga\Stats\Controller\Adminhtml;

use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Ui\Component\MassAction\Filter as MassActionFilter;
use Sga\Stats\Model\StatFactory as ModelFactory;
use Sga\Stats\Model\ResourceModel\Stat\CollectionFactory;
use Sga\Stats\Api\StatRepositoryInterface as ModelRepository;
use Sga\Stats\Helper\Data as DataHelper;

abstract class Stat extends Action
{
    const ADMIN_RESOURCE = 'Sga_Stats::stats_stat';

    protected $_resultPageFactory;
    protected $_resultForwardFactory;
    protected $_jsonFactory;
    protected $_modelFactory;
    protected $_modelRepository;
    protected $_collectionFactory;
    protected $_massActionFilter;
    protected $_dataPersistor;
    protected $_dataHelper;
    protected $_fileFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ForwardFactory $resultForwardFactory,
        JsonFactory $jsonFactory,
        ModelFactory $modelFactory,
        ModelRepository $modelRepository,
        CollectionFactory $collectionFactory,
        MassActionFilter $massActionFilter,
        DataPersistorInterface $dataPersistor,
        DataHelper $dataHelper,
        FileFactory $fileFactory
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_jsonFactory = $jsonFactory;
        $this->_modelFactory = $modelFactory;
        $this->_modelRepository = $modelRepository;
        $this->_collectionFactory = $collectionFactory;
        $this->_massActionFilter = $massActionFilter;
        $this->_dataPersistor = $dataPersistor;
        $this->_dataHelper = $dataHelper;
        $this->_fileFactory = $fileFactory;

        parent::__construct($context);
    }

    protected function initPage(Page $resultPage)
    {
        $resultPage->setActiveMenu('Sga_Stats::stats_stat')
            ->addBreadcrumb(__('Stats'), __('Stats'));

        $resultPage->getConfig()->getTitle()->prepend(__('Stats'));

        return $resultPage;
    }
}
