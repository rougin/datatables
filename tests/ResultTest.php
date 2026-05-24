<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_draw_is_integer_in_to_array()
    {
        $result = new Result;

        $result->setDraw(5);

        $data = $result->toArray();

        $this->assertEquals(5, $data['draw']);
    }

    /**
     * @return void
     */
    public function test_passed_if_empty_items_return_empty_data()
    {
        $result = new Result;

        $result->setItems(array());

        $data = $result->toArray();

        $this->assertEquals(array(), $data['data']);
    }

    /**
     * @return void
     */
    public function test_passed_if_filtered_equals_records_filtered()
    {
        $result = new Result;

        $result->setFiltered(42);

        $data = $result->toArray();

        $this->assertEquals(42, $data['recordsFiltered']);
    }

    /**
     * @return void
     */
    public function test_passed_if_items_match_set_items()
    {
        $result = new Result;

        $items = array(array('Airi', 'Satou'));

        $result->setItems($items);

        $this->assertEquals($items, $result->getItems());
    }

    /**
     * @return void
     */
    public function test_passed_if_to_array_returns_correct_keys()
    {
        $result = new Result;

        $data = $result->toArray();

        $expected = array('draw', 'recordsFiltered', 'recordsTotal', 'data');

        $this->assertEquals($expected, array_keys($data));
    }

    /**
     * @return void
     */
    public function test_passed_if_to_json_encodes_correctly()
    {
        $result = new Result;

        $result->setDraw(1);

        $result->setTotal(10);

        $result->setFiltered(10);

        $result->setItems(array(array('Airi', 'Satou')));

        $expected = '{"draw":1,"recordsFiltered":10,"recordsTotal":10,"data":[["Airi","Satou"]]}';

        $this->assertEquals($expected, $result->toJson());
    }

    /**
     * @return void
     */
    public function test_passed_if_total_equals_records_total()
    {
        $result = new Result;

        $result->setTotal(100);

        $data = $result->toArray();

        $this->assertEquals(100, $data['recordsTotal']);
    }
}
