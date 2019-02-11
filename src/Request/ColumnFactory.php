<?php

namespace Rougin\Datatables\Request;

class ColumnFactory implements ColumnCreation
{
    protected $data;

    protected $name = '';

    protected $orderable = false;

    protected $search;

    protected $searchable = false;

    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    public function make()
    {
        return new Column($this->name, $this->data, $this->search, $this->orderable, $this->searchable);
    }

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function orderable($orderable)
    {
        $this->orderable = $orderable;

        return $this;
    }

    public function search($search)
    {
        $this->search = $search;

        return $this;
    }

    public function searchable($searchable)
    {
        $this->searchable = $searchable;

        return $this;
    }

    public static function http(array $data)
    {
        $self = new ColumnFactory;

        $self->orderable($data['orderable'] === 'true');

        $self->data($data['data'])->name($data['name']);

        $self->searchable($data['searchable'] === 'true');

        $search = SearchFactory::http($data['search']);

        return $self->search($search)->make();
    }
}
