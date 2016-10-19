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
    protected $getParameters;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

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
        $this->getParameters = $get;
        $this->queryBuilder  = $repository->createQueryBuilder('x');
    }

    /**
     * Generates a JSON response to the DataTable.
     *
     * @param  boolean $withKeys
     * @return array
     */
    public function make($withKeys = false)
    {
        $result = $this->getQueryResult($this->queryBuilder, $this->getParameters);

        return $this->getResponse(
            $this->removeKeys($result, ! $withKeys),
            $this->getTotalRows($this->entityName),
            $this->getParameters
        );
    }

    /**
     * Sets the query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     */
    public function setQueryBulder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    /**
     * Returns the generated query.
     *
     * @param  \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param  array                      $get
     * @return array
     */
    protected function getQueryResult(QueryBuilder $queryBuilder, array $get)
    {
        $classMetadata = $this->entityManager->getClassMetadata($this->entityName);
        $rootAliases   = $queryBuilder->getRootAliases();

        foreach ($classMetadata->getColumnNames() as $index => $column) {
            $method    = ($index == 0) ? 'where' : 'orWhere';
            $parameter = '%' . $get['search']['value'] . '%';
            $statement = $rootAliases[0] . '.' . $column . ' LIKE :' . $column;

            $queryBuilder->$method($statement)->setParameter($column, $parameter);
        }

        $queryBuilder->setMaxResults($get['length']);
        $queryBuilder->setFirstResult($get['start']);

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
