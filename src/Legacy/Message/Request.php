<?php

namespace Rougin\Datatables\Legacy\Message;

class Request implements RequestContract
{
    protected $columns = array();

    protected $draw = 0;

    protected $length = 0;

    protected $orders = array();

    protected $search;

    protected $start = 0;

    public function __construct($columns, $search = null, $orders = null, $start = 0, $length = 10, $draw = 1)
    {
        $this->columns = $columns;

        $this->draw = $draw;

        $this->length = $length;

        $this->orders = $orders;

        $this->search = $search;

        $this->start = $start;
    }

    public function columns()
    {
        return $this->columns;
    }

    public function draw()
    {
        return $this->draw;
    }

    public function length()
    {
        return $this->length;
    }

    public function orders()
    {
        return $this->orders;
    }

    public function search()
    {
        return $this->search;
    }

    public function start()
    {
        return $this->start;
    }
}
