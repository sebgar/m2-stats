<?php
namespace Sga\Stats\Controller\Adminhtml\Stat;

use Sga\Stats\Controller\Adminhtml\Stat as ParentClass;

class Index extends ParentClass
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $this->initPage($resultPage);

        return $resultPage;
    }
}
