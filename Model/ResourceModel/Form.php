<?php

namespace Syncitgroup\Sgform\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;

/**
 * Form model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Form extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sgform', 'id');
    }
}
