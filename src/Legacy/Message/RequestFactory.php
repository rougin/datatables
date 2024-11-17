<?php

namespace Rougin\Datatables\Legacy\Message;

use Rougin\Datatables\Legacy\Request\ColumnFactory;
use Rougin\Datatables\Legacy\Request\ColumnContract;
use Rougin\Datatables\Legacy\Request\Order;
use Rougin\Datatables\Legacy\Request\OrderContract;
use Rougin\Datatables\Legacy\Request\SearchFactory;
use Rougin\Datatables\Legacy\Request\SearchContract;

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

        foreach ($data['columns'] as $item)
        {
            if (! $item['data'])
            {
                continue;
            }

            $column = ColumnFactory::http($item);

            $factory->column($column);
        }

        if (isset($data['order']))
        {
            $factory->orders($data['order']);
        }

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
        $this->columns = $columns;

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
        return new Request($this->columns, $this->search, $this->orders, $this->start, $this->length, $this->draw);
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
