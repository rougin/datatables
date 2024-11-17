<?php

namespace Rougin\Datatables\Legacy\Request;

class Order implements OrderContract
{
    protected $ascending = false;

    protected $column;

    public function __construct(ColumnContract $column, $dir)
    {
        $this->ascending = $dir === 'asc';

        $this->column = $column;
    }

    public function ascending()
    {
        return $this->ascending;
    }

    public function column()
    {
        return $this->column;
    }

    public function descending()
    {
        return ! $this->ascending;
    }
}
