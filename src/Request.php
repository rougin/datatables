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
     * @var array<string, mixed>
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

        /** @var array<string, mixed> $data */
        return new Request($data);
    }

    /**
     * @param array<string, mixed> $data
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
            $row = $name ? $row->setName($name) : $row;

            /** @var string */
            $data = $item['data'];
            $row->setData($data);

            // It may be a column name ---
            if (! is_numeric($data))
            {
                $row->setName($data);
            }
            // ---------------------------

            $searchable = $item['searchable'] === 'true';
            $row->setSearchable($searchable);

            $orderable = $item['orderable'] === 'true';
            $row->setOrderable($orderable);

            // Specify the search parameters --------
            /** @var array<string, mixed> */
            $data = $item['search'];

            $row->setSearch($this->setSearch($data));
            // --------------------------------------

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

            /** @var integer */
            $index = $item['column'];
            $new->setIndex($index);

            // Specify if direction is ascending or descending ---------
            /** @var string */
            $dir = $item['dir'];

            $sort = $dir === 'asc' ? Order::SORT_ASC : Order::SORT_DESC;

            $new->setSort($sort);
            // ---------------------------------------------------------

            /** @var string|null */
            $name = $item['name'];
            $new = $name ? $new->setName($name) : $new;

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

        /** @var string|null */
        $value = $data['value'];

        if ($value)
        {
            $search->setValue($value);
        }

        $regex = $data['regex'] === 'true';
        $search->setRegex($regex);

        return $search;
    }
}
