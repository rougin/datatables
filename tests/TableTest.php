<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class TableTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_add_column_adds_to_list()
    {
        $table = new Table;

        $column = new Column;

        $column->setName('forename');

        $table->addColumn($column);

        $columns = $table->getColumns();

        $this->assertCount(1, $columns);

        $this->assertEquals('forename', $columns[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_from_request_creates_columns()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $table = Table::fromRequest($request);

        $this->assertCount(2, $table->getColumns());
    }

    /**
     * @return void
     */
    public function test_passed_if_from_request_sets_table_name()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $table = Table::fromRequest($request, 'users');

        $this->assertEquals('users', $table->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_get_name_returns_set_value()
    {
        $table = new Table;

        $table->setName('users');

        $this->assertEquals('users', $table->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_map_column_preserves_index()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $table = Table::fromRequest($request);

        $table->mapColumn(0, 'forename');

        $columns = $table->getColumns();

        $this->assertEquals('forename', $columns[0]->getName());

        $this->assertNull($columns[1]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_map_column_sets_column_name()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $table = Table::fromRequest($request);

        $table->mapColumn(0, 'forename');

        $columns = $table->getColumns();

        $this->assertEquals('forename', $columns[0]->getName());
    }
}
