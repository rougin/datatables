<?php

namespace Rougin\Datatables\Legacy\Message;

use Rougin\Datatables\Legacy\Request\ColumnContract;
use Rougin\Datatables\Legacy\Request\OrderContract;
use Rougin\Datatables\Legacy\Request\SearchContract;

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
