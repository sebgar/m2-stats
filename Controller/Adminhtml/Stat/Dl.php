<?php
namespace Sga\Stats\Controller\Adminhtml\Stat;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Sga\Stats\Controller\Adminhtml\Stat as ParentClass;

class Dl extends ParentClass
{
    public function execute()
    {
        $str = $this->_dataHelper->generateReports();

        return $this->_fileFactory->create(
            'stats.csv',
            ['type' => 'string', 'value' => $str, 'rm' => true],
            DirectoryList::VAR_DIR,
            'text/csv');
    }
}
