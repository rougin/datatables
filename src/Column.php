<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Column
{
    /**
     * NOTE: From payload, it is known as "data".
     *
     * @var integer
     */
    protected $index;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var boolean
     */
    protected $orderable = false;

    /**
     * @var \Rougin\Datatables\Search
     */
    protected $search;

    /**
     * @var boolean
     */
    protected $searchable = false;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Rougin\Datatables\Search
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return boolean
     */
    public function isOrderable()
    {
        return $this->orderable;
    }

    /**
     * @return boolean
     */
    public function isSearchable()
    {
        return $this->searchable;
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
     * @param boolean $orderable
     *
     * @return self
     */
    public function setOrderable($orderable)
    {
        $this->orderable = $orderable;

        return $this;
    }

    /**
     * @param \Rougin\Datatables\Search $search
     *
     * @return self
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * @param boolean $searchable
     *
     * @return self
     */
    public function setSearchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }
}
