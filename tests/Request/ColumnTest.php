<?php

namespace Rougin\Datatables\Request;

class ColumnTest extends \PHPUnit_Framework_TestCase
{
    protected $column;

    public function setUp()
    {
        $factory = new ColumnFactory;

        $factory->data('id')->name('id');

        $factory->searchable(true);

        $factory->orderable(true);

        $search = new Search(null, false);

        $factory->search($search);

        $this->column = $factory->make();
    }

    public function testHttpMethod()
    {
        $data = array('data' => 'id', 'name' => 'id');

        $data['searchable'] = 'true';

        $data['orderable'] = 'true';

        $search = array('value' => '', 'regex' => 'false');

        $data['search'] = $search;

        $result = ColumnFactory::http($data);

        $this->assertEquals($this->column, $result);
    }

    public function testDataMethod()
    {
        $result = (string) $this->column->data();

        $expected = 'id';

        $this->assertEquals($expected, $result);
    }

    public function testNameMethod()
    {
        $result = (string) $this->column->name();

        $expected = 'id';

        $this->assertEquals($expected, $result);
    }

    public function testSearchableMethod()
    {
        $result = $this->column->searchable();

        $expected = true;

        $this->assertEquals($expected, $result);
    }

    public function testOrderableMethod()
    {
        $result = $this->column->orderable();

        $expected = true;

        $this->assertEquals($expected, $result);
    }

    public function testSearchMethod()
    {
        $result = $this->column->search();

        $expected = new Search(null, false);

        $this->assertEquals($expected, $result);
    }
}
