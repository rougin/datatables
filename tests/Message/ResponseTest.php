<?php

namespace Rougin\Datatables\Message;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    protected $response;

    public function setUp()
    {
        $factory = new ResponseFactory;

        $data = array();

        $item = array('id' => 1);
        $item['name'] = 'Rougin';
        array_push($data, $item);

        $item = array('id' => 1);
        $item['name'] = 'Gutib';
        array_push($data, $item);

        $factory->data($data);

        $factory->total(100);

        $factory->filtered(100);

        $factory->draw(1000);

        $factory->error('');

        $this->response = $factory->make();
    }

    public function testDataMethod()
    {
        $result = $this->response->data();

        $expected = array();

        $item = array('id' => 1);
        $item['name'] = 'Rougin';
        array_push($expected, $item);

        $item = array('id' => 1);
        $item['name'] = 'Gutib';
        array_push($expected, $item);

        $this->assertEquals($expected, $result);
    }

    public function testDrawMethod()
    {
        $result = $this->response->draw();

        $expected = 1000;

        $this->assertEquals($expected, $result);
    }

    public function testErrorMethod()
    {
        $result = $this->response->error();

        $expected = '';

        $this->assertEquals($expected, $result);
    }

    public function testFilteredMethod()
    {
        $result = $this->response->filtered();

        $expected = 100;

        $this->assertEquals($expected, $result);
    }

    public function testResultMethod()
    {
        $result = $this->response->result();

        $expected = array('data' => array());

        $item = array('id' => 1);
        $item['name'] = 'Rougin';
        array_push($expected['data'], $item);

        $item = array('id' => 1);
        $item['name'] = 'Gutib';
        array_push($expected['data'], $item);

        $expected['recordsTotal'] = 100;

        $expected['recordsFiltered'] = 100;

        $expected['draw'] = 1000;

        $expected['error'] = '';

        $this->assertEquals($expected, $result);
    }

    public function testTotalMethod()
    {
        $result = $this->response->total();

        $expected = 100;

        $this->assertEquals($expected, $result);
    }
}
