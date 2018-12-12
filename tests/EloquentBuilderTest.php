<?php

namespace Rougin\Datatables;

use Illuminate\Database\Capsule\Manager;

/**
 * Eloquent Builder Test
 *
 * @package Datatables
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class EloquentBuilderTest extends AbstractTestCase
{
    /**
     * Sets up the builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $exists = class_exists('Illuminate\Database\Capsule\Manager');

        $message = 'Illuminate Database is not yet installed.';

        $exists === true || $this->markTestSkipped($message);

        list($capsule, $connection) = array(new Manager, array());

        $connection['driver'] = 'sqlite';

        $connection['database'] = __DIR__ . '/Fixture/Database.sqlite';

        $connection['prefix'] = '';

        $capsule->addConnection($connection);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }

    /**
     * Tests BuilderInterface::make.
     *
     * @return void
     */
    public function testMakeMethod()
    {
        $model = 'Rougin\Datatables\Fixture\EloquentModel';

        $data = $this->parameters();

        $builder = new EloquentBuilder($model, $data);

        $response = (array) $builder->make();

        $expected = $this->data();

        $result = $response['data'];

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests BuilderInterface::make with values only.
     *
     * @return void
     */
    public function testMakeMethodWithValuesOnly()
    {
        $model = 'Rougin\Datatables\Fixture\EloquentModel';

        $data = $this->parameters();

        $builder = new EloquentBuilder($model, $data);

        $response = (array) $builder->make(true);

        $expected = $this->values($this->data());

        $result = $response['data'];

        $this->assertEquals($expected, $result);
    }
}
