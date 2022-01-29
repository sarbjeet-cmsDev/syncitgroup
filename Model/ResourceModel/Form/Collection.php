<?php

namespace Syncitgroup\Sgform\Model\ResourceModel\Form;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Form Collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'sgform_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'sgform_collection';


    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Syncitgroup\Sgform\Model\Form::class, \Syncitgroup\Sgform\Model\ResourceModel\Form::class);
    }

    /**
     * Add fulltext filter
     *
     * @param string $value
     * @return $this
     */
    public function addFullTextFilter(string $value)
    {
        $fields = ['name', 'email', 'phone'];
        $whereCondition = '';
        foreach ($fields as $key => $field) {
            $field = 'main_table.' . $field;
            $condition = $this->_getConditionSql(
                $this->getConnection()->quoteIdentifier($field),
                ['like' => "%$value%"]
            );
            $whereCondition .= ($key === 0 ? '' : ' OR ') . $condition;
        }
        if ($whereCondition) {
            $this->getSelect()->where($whereCondition);
        }

        return $this;
    }
}
