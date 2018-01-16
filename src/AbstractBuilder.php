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
     * Returns the data in Datatables' response format.
     *
     * @param  array   $data
     * @param  array   $parameters
     * @param  integer $rows
     * @return array
     */
    protected function response(array $data, array $parameters, $rows)
    {
        $search = $parameters['search']['value'];

        $filtered = $search === null ? $rows : count($data);

        $response = array('draw' => $parameters['draw']);

        $response['recordsFiltered'] = $filtered;

        $response['recordsTotal'] = $rows;

        $response['data'] = $data;

        return $response;
    }

    /**
     * Converts the array items as values only.
     *
     * @param  array $data
     * @return array
     */
    protected function values(array $data)
    {
        $values = $data;

        foreach ($data as $key => $item) {
            $value = array_values($item);

            $values[$key] = (array) $value;
        }

        return $values;
    }
}
