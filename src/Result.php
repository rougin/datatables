<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Result
{
    /**
     * @var integer
     */
    protected $draw;

    /**
     * NOTE: To response, it is known as "data".
     *
     * @var string[][]
     */
    protected $items = array();

    /**
     * NOTE: To response, it is known as "recordsFiltered".
     *
     * @var integer
     */
    protected $filtered = 0;

    /**
     * NOTE: To response, it is known as "recordsTotal".
     *
     * @var integer
     */
    protected $total = 0;

    /**
     * @return integer
     */
    public function getDraw()
    {
        return $this->draw;
    }

    /**
     * @return integer
     */
    public function getFiltered()
    {
        return $this->filtered;
    }

    /**
     * @return string[][]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param integer $draw
     *
     * @return self
     */
    public function setDraw($draw)
    {
        $this->draw = $draw;

        return $this;
    }

    /**
     * @param integer $filtered
     *
     * @return self
     */
    public function setFiltered($filtered)
    {
        $this->filtered = $filtered;

        return $this;
    }

    /**
     * @param string[][] $items
     *
     * @return self
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @param integer $total
     *
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $draw = $this->getDraw();

        $item = array('draw' => $draw);

        $filter = $this->getFiltered();

        $item['recordsFiltered'] = $filter;

        $total = $this->getTotal();

        $item['recordsTotal'] = $total;

        $items = $this->getItems();

        $item['data'] = $items;

        return $item;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $json = json_encode($this->toArray());

        return is_string($json) ? $json : '{}';
    }
}
