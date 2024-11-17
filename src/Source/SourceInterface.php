<?php

namespace Rougin\Datatables\Source;

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
}
