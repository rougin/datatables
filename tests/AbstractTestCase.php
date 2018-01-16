<?php

namespace Rougin\Datatables;

/**
 * Abstract Test Case
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Sets up the builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $message = 'Builder not defined.';

        $this->markTestSkipped($message);
    }

    /**
     * Returns the sample data from the SQLite database.
     *
     * @return array
     */
    protected function data()
    {
        $row = array('id' => 0, 'name' => '', 'age' => 0, 'gender' => '');

        $rougin = $angel = $royce = $roilo = $rouine = $row;

        $rougin['id'] = 1;
        $rougin['name'] = 'rougin';
        $rougin['age'] = 18;
        $rougin['gender'] = 'male';

        $angel['id'] = 2;
        $angel['name'] = 'angel';
        $angel['age'] = 19;
        $angel['gender'] = 'female';

        $royce['id'] = 3;
        $royce['name'] = 'royce';
        $royce['age'] = 15;
        $royce['gender'] = 'male';

        $roilo['id'] = 4;
        $roilo['name'] = 'roilo';
        $roilo['age'] = 17;
        $roilo['gender'] = 'male';

        $rouine['id'] = 5;
        $rouine['name'] = 'rouine';
        $rouine['age'] = 12;
        $rouine['gender'] = 'male';

        return array($rougin, $angel, $royce, $roilo, $rouine);
    }

    /**
     * Returns a sample request from Datatables.
     *
     * @return array
     */
    protected function parameters()
    {
        $column = array('data' => 0, 'name' => '', 'searchable' => true);

        $column['orderable'] = true;

        $column['search'] = array('value' => '', 'regex' => false);

        $data = array('draw' => 1, 'columns' => array());

        $data['order'] = array('column' => 0, 'dir' => 'asc');

        $data['start'] = 0;

        $data['length'] = 10;

        $data['search'] = $column['search'];

        $first = $second = $third = $column;

        $first['data'] = 1;

        $second['data'] = 2;

        $third['data'] = 3;

        $data['columns'] = array($column, $first, $second, $third);

        return $data;
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
