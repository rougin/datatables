<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Table;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface SourceInterface
{
    /**
     * Returns the total items that were filtered.
     *
     * @return integer
     */
    public function getFiltered();

    /**
     * Returns the items from the source.
     *
     * @return string[][]
     */
    public function getItems();

    /**
     * Returns the total items from the source.
     *
     * @return integer
     */
    public function getTotal();

    /**
     * Sets the table to be used in the source.
     *
     * @param \Rougin\Datatables\Table $table
     *
     * @return self
     */
    public function setTable(Table $table);
}
