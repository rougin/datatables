<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Table;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PdoSource implements SourceInterface
{
    /**
     * @var integer
     */
    protected $filtered = 0;

    /**
     * @var string[][]
     */
    protected $items = array();

    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var \Rougin\Datatables\Table
     */
    protected $table;

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->pdo = $pdo;
    }

    /**
     * Returns the total items that were filtered.
     *
     * @return integer
     */
    public function getFiltered()
    {
        return $this->filtered;
    }

    /**
     * Returns the items from the source.
     *
     * @return string[][]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Returns the total items from the source.
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
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
}
