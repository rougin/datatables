<?php

namespace Rougin\Datatables\Message;

use Rougin\Datatables\Request\ColumnContract;
use Rougin\Datatables\Request\OrderContract;
use Rougin\Datatables\Request\SearchContract;

interface RequestCreation
{
    public function column(ColumnContract $column);

    public function columns(array $columns);

    public function draw($draw);

    public function length($length);

    public function make();

    public function order(OrderContract $order);

    public function orders(array $orders);

    public function search(SearchContract $search);

    public function start($start);
}
