<?php

namespace Rougin\Datatables\Builder;

use Doctrine\DBAL\DriverManager;
use Rougin\Datatables\Message\RequestFactory;
use Rougin\Datatables\Message\ResponseFactory;

class DoctrineBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $builder;

    public function setUp()
    {
        $path = __DIR__ . '/../Fixture/Database.sqlite';

        $database = array('charset' => 'utf8');
        $database['driver'] = 'pdo_sqlite';
        $database['path'] = (string) $path;
        $connection = DriverManager::getConnection($database);
        $query = $connection->createQueryBuilder();

        $this->builder = new DoctrineBuilder($query);
    }

    public function testBuildMethod()
    {
        $expected = array('draw' => 1);

        $expected['recordsTotal'] = 5;

        $expected['recordsFiltered'] = 5;

        $expected['error'] = '';

        $expected['data'] = array();

        $user = array('id' => 1);
        $user['name'] = 'rougin';
        array_push($expected['data'], $user);

        $user = array('id' => 2);
        $user['name'] = 'datatables';
        array_push($expected['data'], $user);

        $user = array('id' => 3);
        $user['name'] = 'royce';
        array_push($expected['data'], $user);

        $user = array('id' => 4);
        $user['name'] = 'johndoe';
        array_push($expected['data'], $user);

        $user = array('id' => 5);
        $user['name'] = 'markdow';
        array_push($expected['data'], $user);

        $this->builder->table('users');

        $this->builder->factory(new ResponseFactory);

        $request = $this->simpleRequest();

        $response = $this->builder->build($request);

        $result = (array) $response->result();

        $this->assertEquals($expected, $result);
    }

    protected function requestWithSearch()
    {
        $data = array('draw' => '1');
        $data['columns'] = array();

        $column = array('data' => 'id');
        $column['name'] = 'id';
        $column['searchable'] = 'true';
        $column['orderable'] = 'true';
        $column['search'] = array('value' => '', 'regex' => 'false');
        array_push($data['columns'], $column);

        $column = array('data' => 'name');
        $column['name'] = 'name';
        $column['searchable'] = 'true';
        $column['orderable'] = 'true';
        $column['search'] = array('value' => '', 'regex' => 'false');
        array_push($data['columns'], $column);

        $data['length'] = 10;
        $data['start'] = 0;
        $data['order'] = array(array('column' => 0, 'dir' => 'asc'));
        $data['search'] = array('value' => '', 'regex' => 'false');

        return RequestFactory::http($data);
    }

    protected function simpleRequest()
    {
        $data = array('draw' => '1');
        $data['columns'] = array();

        $column = array('data' => 'id');
        $column['name'] = 'id';
        $column['searchable'] = 'true';
        $column['orderable'] = 'true';
        $column['search'] = array('value' => '', 'regex' => 'false');
        array_push($data['columns'], $column);

        $column = array('data' => 'name');
        $column['name'] = 'name';
        $column['searchable'] = 'true';
        $column['orderable'] = 'true';
        $column['search'] = array('value' => '', 'regex' => 'false');
        array_push($data['columns'], $column);

        $data['length'] = 10;
        $data['start'] = 0;
        $data['order'] = array(array('column' => 0, 'dir' => 'asc'));
        $data['search'] = array('value' => '', 'regex' => 'false');

        return RequestFactory::http($data);
    }
}
