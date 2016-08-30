<?php

namespace Rougin\Datatables;

use Illuminate\Database\Eloquent\Builder;

/**
 * Eloquent Builder
 *
 * @package Datatables
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class EloquentBuilder implements BuilderInterface
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @param mixed  $model
     * @param string $get
     */
    public function __construct($model, $get)
    {
        $this->get   = $get;
        $this->model = $model;
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

        if (is_string($this->model)) {
            $model   = new $this->model;
            $builder = $model->query();
        }

        $count = $builder->count();
        $data  = $this->getQueryResult($builder);

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
     * Returns the data from the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @return array
     */
    protected function getQueryResult(Builder $builder)
    {
        $limit  = $this->get['length'];
        $offset = $this->get['start'];
        $search = $this->get['search']['value'];

        $schema  = $builder->getModel()->getConnection()->getSchemaBuilder();
        $table   = $builder->getModel()->getTable();
        $columns = $schema->getColumnListing($table);

        foreach ($columns as $index => $column) {
            $builder->orWhere($column, 'LIKE', '%' . $search . '%');
        }

        $builder->limit($limit);
        $builder->offset($offset);

        return $builder->get()->toArray();
    }
}
