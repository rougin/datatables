<?php

namespace Rougin\Datatables;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine Builder
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class DoctrineBuilder extends AbstractBuilder implements BuilderInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var array
     */
    protected $get;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;

    /**
     * @param string                      $entityName
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param array                       $get
     */
    public function __construct($entityName, EntityManager $entityManager, array $get)
    {
        $repository = $entityManager->getRepository($entityName);

        $this->entityManager = $entityManager;
        $this->entityName    = $entityName;
        $this->get           = $get;
        $this->query         = $repository->createQueryBuilder('x');
    }

    /**
     * Generates a JSON response to the DataTable.
     *
     * @param  boolean $withKeys
     * @return array
     */
    public function make($withKeys = false)
    {
        $draw   = $this->get['draw'];
        $search = $this->get['search']['value'];

        $count = $this->getTotalRows($this->entityName);
        $data  = $this->getQueryResult($this->query);
        $data  = $this->removeKeys($data, ! $withKeys);

        $response = [
            'draw'            => $draw,
            'recordsFiltered' => (empty($search)) ? $count : count($data),
            'recordsTotal'    => $count,
            'data'            => $data,
        ];

        return $response;
    }

    /**
     * Sets the query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     */
    public function setQueryBulder(QueryBuilder $queryBuilder)
    {
        $this->query = $queryBuilder;

        return $this;
    }

    /**
     * Returns the generated query.
     *
     * @param  \Doctrine\ORM\QueryBuilder $queryBuilder
     * @return array
     */
    protected function getQueryResult(QueryBuilder $queryBuilder)
    {
        $limit  = $this->get['length'];
        $offset = $this->get['start'];
        $search = $this->get['search']['value'];

        $aliases = $queryBuilder->getRootAliases();
        $columns = $this->entityManager->getClassMetadata($this->entityName);

        foreach ($columns->getColumnNames() as $index => $column) {
            $method    = ($index == 0) ? 'where' : 'orWhere';
            $parameter = '%' . $search . '%';
            $statement = $aliases[0] . '.' . $column . ' LIKE :' . $column;

            $queryBuilder->$method($statement)->setParameter($column, $parameter);
        }

        $queryBuilder->setMaxResults($limit);
        $queryBuilder->setFirstResult($offset);

        return $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * Returns the total rows of an entity.
     *
     * @param  string $entityName
     * @return integer
     */
    protected function getTotalRows($entityName)
    {
        $query = $this->entityManager->createQueryBuilder();

        $query->select($query->expr()->count('x.id'));
        $query->from($entityName, 'x');

        return $query->getQuery()->getSingleScalarResult();
    }
}
