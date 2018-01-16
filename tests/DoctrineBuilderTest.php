<?php

namespace Rougin\Datatables;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine Builder Test
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DoctrineBuilderTest extends AbstractTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Sets up the builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $exists = class_exists('Doctrine\ORM\Tools\Setup');

        $message = 'Doctrine ORM is not yet installed.';

        $exists === true || $this->markTestSkipped($message);

        list($connection, $paths) = array(array(), array(__DIR__));

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $connection['driver'] = 'pdo_sqlite';

        $connection['path'] = __DIR__ . '/Fixture/Database.sqlite';

        $connection['charset'] = 'utf8';

        $this->manager = EntityManager::create($connection, $config);
    }

    /**
     * Tests BuilderInterface::make.
     *
     * @return void
     */
    public function testMakeMethod()
    {
        $entity = 'Rougin\Datatables\Fixture\DoctrineModel';

        $data = $this->parameters();

        $builder = new DoctrineBuilder($this->manager, $entity, $data);

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
        $entity = 'Rougin\Datatables\Fixture\DoctrineModel';

        $data = $this->parameters();

        $builder = new DoctrineBuilder($this->manager, $entity, $data);

        $response = (array) $builder->make(true);

        $expected = $this->values($this->data());

        $result = $response['data'];

        $this->assertEquals($expected, $result);
    }
}
