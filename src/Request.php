<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Request
{
    /**
     * @var array<integer|string, mixed>
     */
    protected $data = array();

    /**
     * @param string $string
     *
     * @return self
     */
    public static function fromString($string)
    {
        parse_str($string, $data);

        return new Request($data);
    }

    /**
     * @param array<integer|string, mixed> $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @return \Rougin\Datatables\Column[]
     */
    public function getColumns()
    {
        /** @var array<string, mixed>[] */
        $items = $this->data['columns'];

        $result = array();

        foreach ($items as $item)
        {
            $row = new Column;

            /** @var string|null */
            $name = $item['name'];

            if ($name)
            {
                $row->setName($name);
            }

            // It may be a column name ---
            /** @var string */
            $data = $item['data'];

            $row->setData($data);

            if (! is_numeric($data))
            {
                $row->setName($data);
            }
            // ---------------------------

            // Set if column is searchable ---------
            $value = $item['searchable'] === 'true';

            $row->setSearchable($value);
            // -------------------------------------

            // Set if column is orderable ---------
            $value = $item['orderable'] === 'true';

            $row->setOrderable($value);
            // ------------------------------------

            // Specify the search parameters ---
            $data = array();

            if (isset($item['search']))
            {
                /** @var array<string, mixed> */
                $data = $item['search'];
            }

            $search = $this->setSearch($data);

            $row->setSearch($search);
            // ---------------------------------

            $result[] = $row;
        }

        return $result;
    }

    /**
     * @return integer
     */
    public function getDraw()
    {
        /** @var integer */
        $value = $this->data['draw'];

        return intval($value);
    }

    /**
     * @return integer
     */
    public function getLength()
    {
        /** @var integer */
        $value = $this->data['length'];

        return intval($value);
    }

    /**
     * @return \Rougin\Datatables\Order[]
     */
    public function getOrders()
    {
        /** @var array<string, mixed>[] */
        $items = $this->data['order'];

        $result = array();

        foreach ($items as $item)
        {
            $new = new Order;

            // Set column name to order with ----------
            /** @var string|null */
            $name = $item['name'];

            $new = $name ? $new->setName($name) : $new;
            // ----------------------------------------

            // Set order index ------
            /** @var integer */
            $index = $item['column'];

            $new->setIndex($index);
            // ----------------------

            // Specify if direction of the order ----
            $isAsc = $item['dir'] === 'asc';

            $sort = Order::SORT_DESC;

            $sort = $isAsc ? Order::SORT_ASC : $sort;

            $new->setSort($sort);
            // --------------------------------------

            $result[] = $new;
        }

        return $result;
    }

    /**
     * @return \Rougin\Datatables\Search
     */
    public function getSearch()
    {
        /** @var array<string, mixed> */
        $data = $this->data['search'];

        return $this->setSearch($data);
    }

    /**
     * @return integer
     */
    public function getStart()
    {
        /** @var integer */
        $value = $this->data['start'];

        return intval($value);
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Datatables\Search
     */
    protected function setSearch($data)
    {
        $search = new Search;

        if (isset($data['regex']))
        {
            $regex = $data['regex'] === 'true';

            $search->setRegex($regex);
        }

        if (isset($data['value']))
        {
            /** @var string */
            $value = $data['value'];

            $search->setValue($value);
        }

        return $search;
    }
}
