<?php
namespace Sga\Stats\Model;

use Sga\Stats\Api\StatRepositoryInterface;
use Sga\Stats\Api\Data\StatInterface as ModelInterface;
use Sga\Stats\Api\Data\StatInterfaceFactory as ModelInterfaceFactory;
use Sga\Stats\Model\StatFactory as ModelFactory;
use Sga\Stats\Model\ResourceModel\Stat as ResourceModel;
use Sga\Stats\Model\ResourceModel\Stat\CollectionFactory as ModelCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface as SearchResultsInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class StatRepository implements StatRepositoryInterface
{
    protected $resource;
    protected $modelFactory;
    protected $modelCollectionFactory;
    protected $searchResultsFactory;
    protected $dataObjectHelper;
    protected $dataObjectProcessor;
    protected $dataFactory;
    private $storeManager;
    private $collectionProcessor;

    public function __construct(
        ResourceModel $resource,
        ModelFactory $modelFactory,
        ModelInterfaceFactory $dataFactory,
        ModelCollectionFactory $modelCollectionFactory,
        SearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->modelFactory = $modelFactory;
        $this->dataFactory = $dataFactory;
        $this->modelCollectionFactory = $modelCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save(ModelInterface $model)
    {

        try {
            $this->resource->save($model);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $model;
    }

    public function getById($id)
    {
        $model = $this->modelFactory->create();
        $this->resource->load($model, $id);
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('The "%1" ID doesn\'t exist.', $id));
        }
        return $model;
    }

    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->modelCollectionFactory->create();
        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(ModelInterface $model)
    {
        try {
            $this->resource->delete($model);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
