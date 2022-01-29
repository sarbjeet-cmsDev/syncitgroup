<?php

namespace Syncitgroup\Sgform\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Form extends AbstractModel implements IdentityInterface
{
    /**
     * Sgform cache tag
     */
    const CACHE_TAG = 'Syncitgroup_Sgform';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'Syncitgroup_Sgform';

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Syncitgroup\Sgform\Model\ResourceModel\Form::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }
}
