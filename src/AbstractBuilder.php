<?php

namespace Rougin\Datatables;

/**
 * Abstract Builder
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractBuilder
{
    /**
     * Removes the keys in the array.
     *
     * @param  array   $data
     * @param  boolean $remove
     * @return array
     */
    protected function removeKeys(array $data, $remove = true)
    {
        $result = $data;

        if ($remove) {
            $valuesOnly = function ($item) {
                return array_values($item);
            };

            $result = array_map($valuesOnly, $data);
        }

        return $result;
    }
}
