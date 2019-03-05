<?php

namespace Rougin\Datatables\Builder;

use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Datatables\Message\ResponseCreation;
use Rougin\Datatables\Message\RequestContract;

class DoctrineBuilder implements BuilderContract
{
    protected $after;

    protected $before;

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

    public function after($after)
    {
        $this->after = $after;

        return $this;
    }

    public function before($before)
    {
        $this->before = $before;

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

        $query->from($this->table, $this->table[0]);

        $query = $this->where($request, $query);

        if ($this->after)
        {
            $after = $this->after;

            $query = $after($query);
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
            $field = $this->table[0] . '.' . $column->name();

            array_push($fields, (string) $field);
        }

        if ($this->before)
        {
            $before = $this->before;

            $query = $before($this->query, $fields);
        }
        else
        {
            $query = $this->query->select($fields);

            $query->from($this->table, $this->table[0]);
        }

        $query = $this->where($request, $query);

        if ($this->after)
        {
            $after = $this->after;

            $query = $after($query);
        }

        $query = $this->order($request, $query);

        $query->setFirstResult($request->start());

        $query->setMaxResults($request->length());

        // echo $query->getSql();exit;

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

        $query->from($this->table, $this->table[0]);

        if ($this->after)
        {
            $after = $this->after;

            $query = $after($query);
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

            $operations = array('<>', '>=', '<=', '>', '<', '=');

            if ($this->operation($keyword, $operations) !== false)
            {
                $operation = $this->operation($keyword, $operations);

                $keyword = str_replace($operation, '', $keyword);

                $predicate = $this->table[0] . '.' . $column->name() . " $operation '$keyword'";
            }
            else
            {
                $predicate = $this->table[0] . '.' . $column->name() . " LIKE '%$keyword%'";
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

        // echo $query->getSql();exit;

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
