<?php

namespace Rougin\Datatables\Message;

use Rougin\Datatables\Request\ColumnFactory;
use Rougin\Datatables\Request\ColumnContract;
use Rougin\Datatables\Request\Order;
use Rougin\Datatables\Request\OrderContract;
use Rougin\Datatables\Request\SearchFactory;
use Rougin\Datatables\Request\SearchContract;

class RequestFactory implements RequestCreation
{
    protected $columns = array();

    protected $draw = 0;

    protected $length = 0;

    protected $orders = array();

    protected $search;

    protected $start = 0;

    public static function http(array $data)
    {
        $factory = new RequestFactory;

        $factory->draw($data['draw']);

        $factory->columns($data['columns']);

        $factory->orders($data['order']);

        $factory->start($data['start']);

        $search = SearchFactory::http($data['search']);

        $factory->search($search);

        $factory->length($data['length']);

        return $factory->make();
    }

    public function column(ColumnContract $column)
    {
        $this->columns[] = $column;

        return $this;
    }

    public function columns(array $columns)
    {
        foreach ($columns as $item)
        {
            $column = ColumnFactory::http($item);

            $this->column($column);
        }

        return $this;
    }

    public function draw($draw)
    {
        $this->draw = (integer) $draw;

        return $this;
    }

    public function length($length)
    {
        $this->length = (integer) $length;

        return $this;
    }

    public function make()
    {
        return new Request($this->columns, $this->orders, $this->start, $this->length, $this->draw, $this->search);
    }

    public function order(OrderContract $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    public function orders(array $orders)
    {
        foreach ($orders as $item)
        {
            $index = (integer) $item['column'];

            $column = $this->columns[$index];

            $dir = $item['dir'];

            $order = new Order($column, $dir);

            $this->order($order);
        }

        return $this;
    }

    public function search(SearchContract $search)
    {
        $this->search = $search;

        return $this;
    }

    public function start($start)
    {
        $this->start = (integer) $start;

        return $this;
    }
}
