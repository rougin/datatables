<?php

namespace Rougin\Datatables\Message;

class ResponseFactory implements ResponseCreation
{
    protected $data = array();

    protected $draw = 0;

    protected $error = '';

    protected $filtered = 0;

    protected $total = 0;

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function draw($draw)
    {
        $this->draw = $draw;

        return $this;
    }

    public function error($error)
    {
        $this->error = $error;

        return $this;
    }

    public function filtered($filtered)
    {
        $this->filtered = $filtered;

        return $this;
    }

    public function make()
    {
        return new Response($this->data, $this->draw, $this->total, $this->filtered, $this->error);
    }

    public function total($total)
    {
        $this->total = $total;

        return $this;
    }
}
