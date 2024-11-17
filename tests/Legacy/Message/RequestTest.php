<?php

namespace Rougin\Datatables\Legacy\Message;

use Rougin\Datatables\Legacy\Request\ColumnFactory;
use Rougin\Datatables\Legacy\Request\Order;
use Rougin\Datatables\Legacy\Request\Search;
use Rougin\Datatables\Testcase;

class RequestTest extends Testcase
{
    protected $request;

    public function doSetUp()
    {
        $factory = new RequestFactory;

        $factory->draw(1);

        $columns = array($this->column());

        $order = new Order($columns[0], 'asc');

        $factory->order($order);

        $factory->start(0)->length(10);

        $factory->columns($columns);

        $factory->search(new Search(null, false));

        $this->request = $factory->make();
    }

    public function testHttpMethod()
    {
        $data = array('draw' => '1');

        $column = array('data' => 'id');
        $column['name'] = 'id';
        $column['searchable'] = 'true';
        $column['orderable'] = 'true';
        $column['search'] = array('value' => '', 'regex' => 'false');

        $data['length'] = 10;
        $data['start'] = 0;
        $data['columns'] = array($column);
        $data['order'] = array(array('column' => 0, 'dir' => 'asc'));
        $data['search'] = array('value' => '', 'regex' => 'false');

        $result = RequestFactory::http($data);

        $this->assertEquals($this->request, $result);
    }

    public function testColumnsMethod()
    {
        $result = $this->request->columns();

        $expected = array($this->column());

        $this->assertEquals($expected, $result);
    }

    public function testDrawMethod()
    {
        $result = $this->request->draw();

        $expected = 1;

        $this->assertEquals($expected, $result);
    }

    public function testLengthMethod()
    {
        $result = $this->request->length();

        $expected = 10;

        $this->assertEquals($expected, $result);
    }

    public function testOrdersMethod()
    {
        $result = $this->request->orders();

        $expected = array(new Order($this->column(), 'asc'));

        $this->assertEquals($expected, $result);
    }

    public function testSearchMethod()
    {
        $result = $this->request->search();

        $expected = new Search(null, false);

        $this->assertEquals($expected, $result);
    }

    public function testStartMethod()
    {
        $result = $this->request->start();

        $expected = 0;

        $this->assertEquals($expected, $result);
    }

    protected function column()
    {
        $factory = new ColumnFactory;

        $factory->data('id')->name((string) 'id');

        $factory->searchable(true)->orderable(true);

        $factory->search(new Search(null, false));

        return $factory->make();
    }
}
