<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Order
{
    const SORT_ASC = 0;

    const SORT_DESC = 1;

    /**
     * NOTE: From payload, it is known as "order[].column".
     *
     * @var integer
     */
    protected $index;

    /**
     * @var string
     */
    protected $name;

    /**
     * NOTE: From payload, it is known as "order[].dir".
     *
     * @var integer
     */
    protected $sort = self::SORT_DESC;

    /**
     * @return integer
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * TODO: Add unit test for using name of order.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return boolean
     */
    public function isAscending()
    {
        return $this->getSort() === self::SORT_ASC;
    }

    /**
     * @return boolean
     */
    public function isDescending()
    {
        return $this->getSort() === self::SORT_DESC;
    }

    /**
     * @param integer $index
     *
     * @return self
     */
    public function setIndex($index)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param integer $sort
     *
     * @return self
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }
}
