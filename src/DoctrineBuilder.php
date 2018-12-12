<?php

namespace Rougin\Datatables;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Doctrine Builder
 *
 * @package Datatables
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DoctrineBuilder extends AbstractBuilder implements BuilderInterface
{
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * Initializes the builder instance.
     *
     * @param \Doctrine\ORM\EntityManager $manager
     * @param string                      $entity
     * @param array|null                  $data
     */
    public function __construct(EntityManager $manager, $entity, array $data = null)
    {
        $repository = $manager->getRepository($entity);

        $this->builder = $repository->createQueryBuilder('x');

        $this->data = is_null($data) ? array() : $data;

        $this->entity = $entity;

        $this->manager = $manager;
    }

    /**
     * Generates a JSON response to the Datatable.
     *
     * @param  boolean $values
     * @return array
     */
    public function make($values = false)
    {
        $items = $query = $this->query($this->entity);

        $values === true && $items = $this->values($query);

        $rows = (integer) $this->rows($this->entity);

        return $this->response($items, $this->data, $rows);
    }

    /**
     * Returns the generated query.
     *
     * @param  string $entity
     * @return array
     */
    protected function query($entity)
    {
        $metadata = $this->manager->getClassMetadata($entity);

        $aliases = $this->builder->getRootAliases();

        foreach ($metadata->getColumnNames() as $index => $column) {
            $method = $index === 0 ? 'where' : 'orWhere';

            $statement = $aliases[0] . '.' . $column . ' LIKE :' . $column;

            $parameter = '%' . $this->data['search']['value'] . '%';

            $this->builder->$method($statement)->setParameter($column, $parameter);
        }

        $this->builder->setMaxResults($this->data['length']);

        $this->builder->setFirstResult($this->data['start']);

        return $this->builder->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * Returns the total rows of an entity.
     *
     * @param  string $entity
     * @return integer
     */
    protected function rows($entity)
    {
        $builder = $this->manager->createQueryBuilder();

        $builder->select($builder->expr()->count('x.id'));

        $builder->from($entity, 'x');

        return $builder->getQuery()->getSingleScalarResult();
    }
}
