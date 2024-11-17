<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Request;
use Rougin\Datatables\Table;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PdoSource implements SourceInterface
{
    /**
     * @var string[][]
     */
    protected $items = array();

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
     * @var mixed[]
     */
    protected $values = array();

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    /**
     * TODO: If no filters, the value should be same with getTotal.
     *
     * Returns the total items after filter.
     *
     * @return integer
     */
    public function getFiltered()
    {
        // Reset values prior creating query ---
        $this->values = array();
        // -------------------------------------

        $table = $this->table->getName() . ' ';

        $query = 'SELECT COUNT(*) FROM ' . $table;

        $query .= $this->setWhereQuery() . ' ';

        /** @var \PDOStatement */
        $stmt = $this->pdo->prepare($query);

        $stmt->execute($this->values);

        /** @var integer */
        $total = $stmt->fetch(\PDO::FETCH_COLUMN);

        return (int) $total;
    }

    /**
     * Returns the items from the source.
     *
     * @return string[][]
     */
    public function getItems()
    {
        // Reset values prior creating query ---
        $this->values = array();
        // -------------------------------------

        $table = $this->table->getName() . ' ';

        $query = 'SELECT * FROM ' . $table;

        $query .= $this->setWhereQuery() . ' ';
        $query .= $this->setOrderQuery() . ' ';
        $query .= $this->setLimitQuery() . ' ';

        /** @var \PDOStatement */
        $stmt = $this->pdo->prepare($query);

        $stmt->execute($this->values);

        /** @var array<string, string>[] */
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $result = array();

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

                // TODO: Allow to convert columns with a data type ----
                // ----------------------------------------------------

                // PHP 8.0 and above parses numbers as native types ---
                // as opposed to pure strings prior to this version ---
                $row[] = (string) $item[$name];
                // ----------------------------------------------------
            }

            $result[] = $row;
        }

        return $result;
    }

    /**
     * TODO: Merge logic with getFiltered.
     *
     * Returns the total items from the source.
     *
     * @return integer
     */
    public function getTotal()
    {
        $table = $this->table->getName();

        $query = 'SELECT COUNT(*) FROM ' . $table;

        /** @var \PDOStatement */
        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        /** @var integer */
        $total = $stmt->fetch(\PDO::FETCH_COLUMN);

        return (int) $total;
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
     * @return string
     */
    protected function setLimitQuery()
    {
        $limit = 'LIMIT ' . $this->request->getLength();

        $start = $this->request->getStart();

        return $start ? $limit . ', ' . $start : $limit;
    }

    /**
     * @return string
     */
    protected function setOrderQuery()
    {
        $query = '';

        $columns = $this->table->getColumns();

        $orders = $this->request->getOrders();

        $items = array();

        foreach ($orders as $order)
        {
            $column = $columns[$order->getIndex()];

            $name = $column->getName();

            if ($column->isOrderable())
            {
                $sort = $order->isAscending() ? 'ASC' : '';

                $sort = $order->isDescending() ? 'DESC' : $sort;

                $items[] = '`' . $name . '` ' . $sort;
            }
        }

        if (count($items) > 0)
        {
            $query = 'ORDER BY ' . implode(', ', $items);
        }

        return $query;
    }

    /**
     * @return string
     */
    protected function setWhereQuery()
    {
        $columns = $this->table->getColumns();

        $search = $this->request->getSearch();

        // Do a global search for each column -------
        $global = array();

        $value = $search->getValue();

        foreach ($columns as $item)
        {
            $name = $item->getName();

            if (! $name)
            {
                continue;
            }

            if ($item->isSearchable())
            {
                $this->values[] = '%' . $value . '%';

                $global[] = '`' . $name . '` LIKE ?';
            }
        }
        // ------------------------------------------

        // TODO: Do a search per specified column ---
        $items = array();

        foreach ($columns as $item)
        {
            $name = $item->getName();

            $search = $item->getSearch();

            if ($value = $search->getValue())
            {
                $this->values[] = '%' . $value . '%';

                $items[] = '`' . $name . '` LIKE ?';
            }
        }
        // ------------------------------------------

        $query = '';

        if (count($global) > 0)
        {
            $query = '(' . implode(' OR ', $global) . ')';
        }

        if (count($items) > 0)
        {
            if ($query === '')
            {
                $query .= ' AND ';
            }

            $query .= implode(' AND ', $items);
        }

        if ($query !== '')
        {
            $query = 'WHERE ' . $query;
        }

        return $query;
    }
}
