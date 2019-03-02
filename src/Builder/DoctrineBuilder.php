<?php

namespace Rougin\Datatables\Builder;

use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Datatables\Message\ResponseCreation;
use Rougin\Datatables\Message\RequestContract;

class DoctrineBuilder implements BuilderContract
{
    protected $callback;

    protected $factory;

    protected $query;

    protected $table;

    public function __construct(QueryBuilder $query)
    {
        $this->query = $query;
    }

    public function build(RequestContract $request)
    {
        $filtered = $this->filtered($request);

        $factory = $this->factory;

        $total = $this->total($this->query);

        $factory->total((integer) $total);

        $factory->filtered($filtered);

        $factory->draw($request->draw());

        $query = $this->items($request);

        $items = $query->execute()->fetchAll();

        return $factory->data($items)->make();
    }

    public function factory(ResponseCreation $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    public function query($callback)
    {
        $this->callback = $callback;

        return $this;
    }

    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    protected function filtered(RequestContract $request)
    {
        $query = $this->query->select('COUNT(*)');

        $query->from($this->table);

        $query = $this->where($request, $query);

        if ($this->callback)
        {
            $callback = $this->callback;

            $query = $callback($query);
        }

        $result = $query->execute()->fetch();

        $this->query->resetQueryParts();

        $result = array_values($result);

        return (integer) $result[0];
    }

    protected function items(RequestContract $request)
    {
        $fields = array();

        foreach ($request->columns() as $column)
        {
            array_push($fields, $column->name());
        }

        $query = $this->query->select($fields);

        $query->from($this->table);

        $query = $this->where($request, $query);

        if ($this->callback)
        {
            $callback = $this->callback;

            $query = $callback($query);
        }

        $query = $this->order($request, $query);

        $query->setFirstResult($request->start());

        $query->setMaxResults($request->length());

        return $query;
    }

    protected function order(RequestContract $request, QueryBuilder $query)
    {
        foreach ($request->orders() as $index => $order)
        {
            if (! $order->column()->orderable())
            {
                continue;
            }

            $name = $order->column()->name();

            $type = $order->ascending() ? 'ASC' : 'DESC';

            $query = $query->orderBy($name, $type);
        }

        return $query;
    }

    protected function total(QueryBuilder $query)
    {
        $query->select('COUNT(*)');

        $query->from($this->table);

        if ($this->callback)
        {
            $callback = $this->callback;

            $query = $callback($query);
        }

        $result = $query->execute()->fetch();

        $result = array_values($result);

        return (integer) $result[0];
    }

    protected function where(RequestContract $request, QueryBuilder $query)
    {
        $value = $request->search()->value();

        foreach ($request->columns() as $index => $column)
        {
            $keyword = $column->search()->value();

            $keyword = $keyword ? $keyword : $value;

            if (! $column->searchable() || ! $keyword)
            {
                continue;
            }

            $operations = array('>', '>=', '<', '<=', '=');

            if ($this->operation($keyword, $operations) !== false)
            {
                $operation = $this->operation($keyword, $operations);

                $keyword = str_replace($operation, '', $keyword);

                $predicate = $column->name() . " $operation '$keyword'";
            }
            else
            {
                $predicate = $column->name() . " LIKE '%$keyword%'";
            }

            if ($index === 0)
            {
                $query = $query->where($predicate);

                continue;
            }

            if ($value)
            {
                $query = $query->orWhere($predicate);

                continue;
            }

            $query = $query->andWhere($predicate);
        }

        return $query;
    }

    protected function operation($value, $array)
    {
        foreach ($array as $item)
        {
            if (strpos($value, $item) !== false)
            {
                return $item;
            }
        }

        return false;
    }
}
