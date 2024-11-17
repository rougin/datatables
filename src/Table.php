<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Table
{
    /**
     * @var \Rougin\Datatables\Column[]
     */
    protected $columns = array();

    /**
     * @param \Rougin\Datatables\Config $config
     *
     * @return self
     */
    public static function fromConfig(Config $config)
    {
        $table = new Table;

        $columns = $config->getColumns();

        foreach ($columns as $column)
        {
            $table->addColumn($column);
        }

        return $table;
    }

    /**
     * @param \Rougin\Datatables\Column $column
     *
     * @return self
     */
    public function addColumn(Column $column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * @return \Rougin\Datatables\Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function newColumn($name)
    {
        $column = new Column;

        $column->setName($name);

        return $this->addColumn($column);
    }
}
