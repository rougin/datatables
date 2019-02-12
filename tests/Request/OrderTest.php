<?php

namespace Rougin\Datatables\Request;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    protected $column;

    public function setUp()
    {
        $column = new ColumnFactory;

        $column->data('id')->name('id');

        $column->searchable(true);

        $column->orderable(true);

        $search = new Search(null, false);

        $column->search($search);

        $column = $column->make();

        $this->order = new Order($column, 'asc');
    }

    public function testColumnMethod()
    {
        $result = $this->order->column();

        $data = array('data' => 'id', 'name' => 'id');

        $data['searchable'] = 'true';

        $data['orderable'] = 'true';

        $search = array('value' => '', 'regex' => 'false');

        $data['search'] = $search;

        $expected = ColumnFactory::http($data);

        $this->assertEquals($expected, $result);
    }

    public function testAscendingMethod()
    {
        $this->assertTrue($this->order->ascending());
    }

    public function testDescendingMethod()
    {
        $this->assertFalse($this->order->descending());
    }
}
