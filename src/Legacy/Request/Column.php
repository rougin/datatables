<?php

namespace Rougin\Datatables\Legacy\Request;

class Column implements ColumnContract
{
    protected $data;

    protected $name = '';

    protected $orderable = false;

    protected $search;

    protected $searchable = false;

    public function __construct($name, $data, $search, $orderable = false, $searchable = false)
    {
        $this->data = $data;

        $this->name = $name;

        $this->orderable = $orderable;

        $this->search = $search;

        $this->searchable = $searchable;
    }

    public function data()
    {
        return $this->data;
    }

    public function name()
    {
        return $this->name;
    }

    public function orderable()
    {
        return $this->orderable;
    }

    public function search()
    {
        return $this->search;
    }

    public function searchable()
    {
        return $this->searchable;
    }
}
