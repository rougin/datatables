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
class DoctrineBuilder implements BuilderInterface
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
        $this->entityName    = $entityName;
        $this->entityManager = $entityManager;
        $this->get           = $get;
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

        if (! $withKeys) {
            $valuesOnly = function ($item) {
                return array_values($item);
            };

            $data = array_map($valuesOnly, $data);
        }

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
     * @param  \Doctrine\ORM\QueryBuilder|null $queryBuilder
     * @return array
     */
    protected function getQueryResult(QueryBuilder $queryBuilder = null)
    {
        $limit  = $this->get['length'];
        $offset = $this->get['start'];
        $search = $this->get['search']['value'];

        if (is_null($queryBuilder)) {
            $repository   = $this->entityManager->getRepository($this->entityName);
            $queryBuilder = $repository->createQueryBuilder('x');
        }

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
