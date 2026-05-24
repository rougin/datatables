<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Request;
use Rougin\Datatables\Table;
use Rougin\Ezekiel\Query;
use Rougin\Ezekiel\Result;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PdoSource implements SourceInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \Rougin\Datatables\Request
     */
    protected $request;

    /**
     * @var \Rougin\Datatables\Table
     */
    protected $table;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $value = \PDO::ERRMODE_EXCEPTION;

        $name = \PDO::ATTR_ERRMODE;

        $pdo->setAttribute($name, $value);

        $this->pdo = $pdo;
    }

    /**
     * Returns the total items after filter. If no filters
     * are defined, the value should be same with getTotal.
     *
     * @return integer
     */
    public function getFiltered()
    {
        return $this->getTotalItems(true);
    }

    /**
     * Returns the items from the source.
     *
     * @return string[][]
     */
    public function getItems()
    {
        $query = new Query;

        $query->select('*')->from($this->table->getName());

        $this->addWhere($query);

        $this->addOrder($query);

        $this->addLimit($query);

        $result = new Result($this->pdo);

        /** @var array<string, mixed>[] */
        $items = $result->items($query);

        $out = array();

        $columns = $this->table->getColumns();

        foreach ($items as $item)
        {
            $row = array();

            foreach ($columns as $column)
            {
                $name = $column->getName();

                if (! $name)
                {
                    continue;
                }

                // PHP 8.0 and above parses numbers as native types ---
                // as opposed to pure strings prior to this version ---
                $value = $item[$name];

                if ($formatter = $column->getFormatter())
                {
                    $data = array($value, $item);

                    /** @var mixed */
                    $value = call_user_func_array($formatter, $data);
                }

                $row[] = is_scalar($value) ? strval($value) : '';
                // ----------------------------------------------------
            }

            $out[] = $row;
        }

        return $out;
    }

    /**
     * Returns the total items from the source.
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->getTotalItems();
    }

    /**
     * Sets the payload to be used in the source.
     *
     * @param \Rougin\Datatables\Request $request
     *
     * @return self
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Sets the table to be used in the source.
     *
     * @param \Rougin\Datatables\Table $table
     *
     * @return self
     */
    public function setTable(Table $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param boolean $filter
     *
     * @return integer
     */
    protected function getTotalItems($filter = false)
    {
        $query = new Query;

        $query->select('COUNT(*) as c')
            ->from($this->table->getName());

        if ($filter)
        {
            $this->addWhere($query);
        }

        $result = new Result($this->pdo);

        /** @var array<string, mixed> */
        $row = $result->first($query);

        $count = $row['c'];

        return is_scalar($count) ? intval($count) : 0;
    }

    /**
     * @param \Rougin\Ezekiel\Query $query
     *
     * @return void
     */
    protected function addLimit(Query $query)
    {
        $length = $this->request->getLength();

        if ($length === -1)
        {
            return;
        }

        $start = $this->request->getStart();

        $query->limit($length, $start);
    }

    /**
     * @param \Rougin\Ezekiel\Query $query
     *
     * @return void
     */
    protected function addOrder(Query $query)
    {
        $columns = $this->table->getColumns();

        $orders = $this->request->getOrders();

        $first = true;

        foreach ($orders as $order)
        {
            $index = $order->getIndex();

            $column = $columns[$index];

            $name = $column->getName();

            if (! $name || ! $column->isOrderable())
            {
                continue;
            }

            if ($first)
            {
                $builder = $query->orderBy($name);

                $first = false;
            }
            else
            {
                $builder = $query->andOrderBy($name);
            }

            if ($order->isAscending())
            {
                $builder->asc();
            }
            else
            {
                $builder->desc();
            }
        }
    }

    /**
     * @param \Rougin\Ezekiel\Query $query
     *
     * @return void
     */
    protected function addWhere(Query $query)
    {
        $columns = $this->table->getColumns();

        $search = $this->request->getSearch();

        $value = $search->getValue();

        // Do a global search for each column --------------
        $global = array();

        foreach ($columns as $item)
        {
            $name = $item->getName();

            if (! $name)
            {
                continue;
            }

            if (! $value || ! $item->isSearchable())
            {
                continue;
            }

            $global[] = $name;
        }

        if (count($global) > 0)
        {
            $fn = function (Query $q) use ($global, $value)
            {
                $first = array_shift($global);

                $q->where($first)->like('%' . $value . '%');

                foreach ($global as $name)
                {
                    $q->orWhere($name)
                        ->like('%' . $value . '%');
                }
            };

            $query->whereGroup($fn);
        }
        // -------------------------------------------------

        // Do a search per specified column ---
        foreach ($columns as $item)
        {
            $name = $item->getName();

            if (! $name)
            {
                continue;
            }

            $colSearch = $item->getSearch();

            $colValue = $colSearch->getValue();

            if (! $colValue)
            {
                continue;
            }

            $query->where($name)
                ->like('%' . $colValue . '%');
        }
        // ------------------------------------
    }

}
