<?php

namespace Rougin\Datatables;

use Illuminate\Database\Eloquent\Builder;

/**
 * Eloquent Builder
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EloquentBuilder extends AbstractBuilder implements BuilderInterface
{
    /**
     * @var array
     */
    protected $getParameters;

    /**
     * @var mixed
     */
    protected $queryBuilder;

    /**
     * @param mixed  $builder
     * @param array  $get
     */
    public function __construct($builder, $get)
    {
        $this->getParameters = $get;
        $this->queryBuilder  = $builder;

        // If a model's name is injected.
        if (is_string($builder)) {
            $model = new $builder;

            $this->queryBuilder = $model->query();
        }
    }

    /**
     * Generates a JSON response to the DataTable.
     *
     * @param  boolean $withKeys
     * @return array
     */
    public function make($withKeys = false)
    {
        $count = $this->queryBuilder->count();
        $data  = $this->getQueryResult($this->queryBuilder, $this->getParameters);
        $data  = $this->removeKeys($data, ! $withKeys);

        return $this->getResponse($data, $count, $this->getParameters);
    }

    /**
     * Returns the data from the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  array                                 $get
     * @return array
     */
    protected function getQueryResult(Builder $builder, array $get)
    {
        $schema  = $builder->getModel()->getConnection()->getSchemaBuilder();
        $table   = $builder->getModel()->getTable();
        $columns = $schema->getColumnListing($table);

        foreach ($columns as $index => $column) {
            $builder->orWhere($column, 'LIKE', '%' . $get['search']['value'] . '%');
        }

        $builder->limit($get['length']);
        $builder->offset($get['start']);

        return $builder->get()->toArray();
    }
}
