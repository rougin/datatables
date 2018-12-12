<?php

namespace Rougin\Datatables;

/**
 * Builder Interface
 *
 * @package Datatables
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface BuilderInterface
{
    /**
     * Generates a JSON response to the Datatable.
     *
     * @param  boolean $values
     * @return array
     */
    public function make($values = false);
}
