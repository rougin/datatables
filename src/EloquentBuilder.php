<?php

namespace Rougin\Datatables;

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
    protected $data;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Initializes the builder instance.
     *
     * @param \Illuminate\Database\Eloquent\Builder|string $builder
     * @param array                                        $data
     */
    public function __construct($builder, $data)
    {
        $this->data = $data;

        // If a model's name is injected.
        if (is_string($builder) === true) {
            $model = new $builder;

            $builder = $model->query();
        }

        $this->builder = $builder;
    }

    /**
     * Generates a JSON response to the Datatable.
     *
     * @param  boolean $values
     * @return array
     */
    public function make($values = false)
    {
        $result = (array) $this->result($values, $this->data);

        $rows = (integer) $this->builder->count();

        return $this->response($result, $this->data, $rows);
    }

    /**
     * Returns the data from the builder.
     *
     * @param  boolean $values
     * @param  array   $data
     * @return array
     */
    protected function result($values, array $data)
    {
        $connection = $this->builder->getModel()->getConnection();

        $schema = $connection->getSchemaBuilder();

        $table = $this->builder->getModel()->getTable();

        $columns = $schema->getColumnListing($table);

        if( isset( $data['search']['value'] ) ){
            foreach ($columns as $column) {
                $query = '%' . $data['search']['value'] . '%';

                $this->builder->orWhere($column, 'LIKE', $query);
            }
        }

        $this->builder->limit($data['length']);

        $this->builder->offset($data['start']);

        $result = $this->builder->get()->toArray();

        return $values ? $this->values($result) : $result;
    }
}
