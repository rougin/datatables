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
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $table;

    /**
     * @param \Rougin\Datatables\Request $request
     * @param string|null                $name
     *
     * @return self
     */
    public static function fromRequest(Request $request, $name = null)
    {
        $table = new Table;

        $columns = $request->getColumns();

        foreach ($columns as $column)
        {
            $table->addColumn($column);
        }

        if ($name)
        {
            $table->setName($name);
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param integer $index
     * @param string  $name
     *
     * @return self
     */
    public function mapColumn($index, $name)
    {
        $column = $this->columns[$index];

        $this->columns[$index] = $column->setName($name);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
