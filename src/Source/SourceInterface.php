<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Request;
use Rougin\Datatables\Table;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
interface SourceInterface
{
    /**
     * Returns the total items after filter. If no filters
     * are defined, the value should be same with getTotal.
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
     * Sets the payload to be used in the source.
     *
     * @param \Rougin\Datatables\Request $request
     *
     * @return self
     */
    public function setRequest(Request $request);

    /**
     * Sets the table to be used in the source.
     *
     * @param \Rougin\Datatables\Table $table
     *
     * @return self
     */
    public function setTable(Table $table);
}
