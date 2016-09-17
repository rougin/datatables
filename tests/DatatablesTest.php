<?php

namespace Rougin\Datatables;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Illuminate\Database\Capsule\Manager;

use Rougin\Datatables\DoctrineBuilder;
use Rougin\Datatables\EloquentBuilder;

use PHPUnit_Framework_TestCase;

use Rougin\Datatables\Test\User\DoctrineModel;
use Rougin\Datatables\Test\User\EloquentModel;

/**
 * Datatables Test
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DatatablesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $get = [
        'draw'    => 1,
        'columns' => [
            [
                'data'       => 0,
                'name'       => '',
                'searchable' => true,
                'orderable'  => true,
                'search'     => [
                    'value' => '',
                    'regex' => false
                ]
            ],
            [
                'data'       => 1,
                'name'       => '',
                'searchable' => true,
                'orderable'  => true,
                'search'     => [
                    'value' => '',
                    'regex' => false
                ]
            ],
            [
                'data'       => 2,
                'name'       => '',
                'searchable' => true,
                'orderable'  => true,
                'search'     => [
                    'value' => '',
                    'regex' => false
                ]
            ],
            [
                'data'       => 3,
                'name'       => '',
                'searchable' => true,
                'orderable'  => true,
                'search'     => [
                    'value' => '',
                    'regex' => false
                ]
            ]
        ],
        'order' => [
            [
                'column' => 0,
                'dir'    => 'asc',
            ]
        ],
        'start'  => 0,
        'length' => 10,
        'search' => [
            'value' => '',
            'regex' => false
        ]
    ];

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * Sets up Doctrine's database configuration.
     *
     * @return void
     */
    protected function setUpDoctrine()
    {
        if (! class_exists('Doctrine\ORM\Tools\Setup')) {
            $this->markTestSkipped('Doctrine ORM is not installed');
        }

        // Create a simple "default" Doctrine ORM configuration for Annotations
        $config = Setup::createAnnotationMetadataConfiguration([ __DIR__ ], true);

        $connection = [
            'driver'  => 'pdo_sqlite',
            'path'    => __DIR__ . '/Databases/test.sqlite',
            'charset' => 'utf8',
        ];

        $this->entityManager = EntityManager::create($connection, $config);
    }

    /**
     * Sets up Eloquent's database configuration.
     *
     * @return void
     */
    protected function setUpEloquent()
    {
        if (! class_exists('Illuminate\Database\Capsule\Manager')) {
            $this->markTestSkipped('Illuminate\Database is not installed');
        }

        $capsule = new Manager;

        $capsule->addConnection([
            'driver'    => 'sqlite',
            'database'  => __DIR__ . '/Databases/test.sqlite',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Tests DoctrineBuilder with model name as parameter.
     *
     * @return void
     */
    public function testDoctrineBuilderWithModelName()
    {
        $this->setUpDoctrine();

        $entity   = DoctrineModel::class;
        $builder  = new DoctrineBuilder($entity, $this->entityManager, $this->get);
        $response = $builder->make();

        $this->assertEquals(5, $response['recordsTotal']);
    }

    /**
     * Tests EloquentBuilder with model name as parameter.
     *
     * @return void
     */
    public function testEloquentBuilderWithModelName()
    {
        $this->setUpEloquent();

        $model    = EloquentModel::class;
        $builder  = new EloquentBuilder($model, $this->get);
        $response = $builder->make();

        $this->assertEquals(5, $response['recordsTotal']);
    }

    /**
     * Tests DoctrineBuilder with query builder as parameter.
     *
     * @return void
     */
    public function testDoctrineBuilderWithQueryBuilder()
    {
        $this->setUpDoctrine();

        $entity  = DoctrineModel::class;
        $builder = new DoctrineBuilder($entity, $this->entityManager, $this->get);

        $repository   = $this->entityManager->getRepository($entity);
        $queryBuilder = $repository->createQueryBuilder('u');

        $builder->setQueryBulder($queryBuilder);

        $response = $builder->make();

        $this->assertCount(5, $response['data']);
    }

    /**
     * Tests EloquentBuilder with query builder as parameter.
     *
     * @return void
     */
    public function testEloquentBuilderWithQueryBuilder()
    {
        $this->setUpEloquent();

        $builder  = new EloquentBuilder(EloquentModel::query(), $this->get);
        $response = $builder->make();

        $this->assertCount(5, $response['data']);
    }
}
