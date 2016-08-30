<?php

namespace Rougin\Datatables;

/**
 * Builder Interface
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface BuilderInterface
{
    /**
     * Generates a JSON response to the DataTable.
     *
     * @param  boolean $withKeys
     * @return array
     */
    public function make($withKeys = false);
}
