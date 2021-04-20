<?php
namespace Sga\Stats\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Sga\Stats\Api\Data\StatInterface as ModelInterface;

interface StatRepositoryInterface
{
    public function save(ModelInterface $model);

    public function getById($id);

    public function getList(SearchCriteriaInterface $searchCriteria);

    public function delete(ModelInterface $model);

    public function deleteById($id);
}
