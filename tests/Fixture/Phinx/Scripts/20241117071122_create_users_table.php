<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $settings = array('id' => false, 'primary_key' => array('id'));

        $table = $this->table('users', $settings);

        $table
            ->addColumn('id', 'integer', array('limit' => 10, 'identity' => true))
            ->addColumn('forename', 'string', array('limit' => 100))
            ->addColumn('surname', 'string', array('limit' => 100))
            ->addColumn('position', 'string', array('limit' => 100))
            ->addColumn('office', 'string', array('limit' => 100))
            ->addColumn('date_start', 'date')
            ->addColumn('salary', 'float', array('limit' => 10))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
