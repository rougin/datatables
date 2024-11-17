<?php

namespace Rougin\Datatables\Legacy\Message;

class Response implements ResponseContract
{
    protected $data = array();

    protected $draw = 0;

    protected $error = '';

    protected $filtered = 0;

    protected $total = 0;

    public function __construct($data, $draw, $total = 0, $filtered = 0, $error = '')
    {
        $this->data = $data;

        $this->draw = $draw;

        $this->error = $error;

        $this->filtered = $filtered;

        $this->total = $total;
    }

    public function data()
    {
        return $this->data;
    }

    public function draw()
    {
        return $this->draw;
    }

    public function error()
    {
        return $this->error;
    }

    public function filtered()
    {
        return $this->filtered;
    }

    public function result()
    {
        $result = array('draw' => $this->draw);

        $result['recordsTotal'] = $this->total;

        $result['recordsFiltered'] = $this->filtered;

        $result['data'] = $this->data;

        $result['error'] = $this->error;

        return (array) $result;
    }

    public function total()
    {
        return $this->total;
    }
}
