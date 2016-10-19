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
     * Returns the data in DataTables' response format.
     *
     * @param  array   $data
     * @param  integer $count
     * @param  array   $get
     * @return array
     */
    protected function getResponse(array $data, $count, array $get)
    {
        $search = $get['search']['value'];

        $response = [];

        $response['draw']            = $get['draw'];
        $response['recordsFiltered'] = (empty($search)) ? $count : count($data);
        $response['recordsTotal']    = $count;
        $response['data']            = $data;

        return $response;
    }

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
