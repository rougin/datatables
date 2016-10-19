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
    protected $get;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param mixed  $model
     * @param array  $get
     */
    public function __construct($model, $get)
    {
        $this->get   = $get;
        $this->model = $model;

        if (is_string($this->model)) {
            $model = new $this->model;

            $this->model = $model->query();
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
        $builder = $this->model;
        $draw    = $this->get['draw'];
        $search  = $this->get['search']['value'];

        $count = $builder->count();
        $data  = $this->getQueryResult($builder, $this->get);
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
