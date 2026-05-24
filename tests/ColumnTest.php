<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ColumnTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_default_name_is_null()
    {
        $column = new Column;

        $this->assertNull($column->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_default_orderable_is_false()
    {
        $column = new Column;

        $this->assertFalse($column->isOrderable());
    }

    /**
     * @return void
     */
    public function test_passed_if_default_searchable_is_false()
    {
        $column = new Column;

        $this->assertFalse($column->isSearchable());
    }

    /**
     * @return void
     */
    public function test_passed_if_name_can_be_set_and_got()
    {
        $column = new Column;

        $column->setName('forename');

        $this->assertEquals('forename', $column->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_orderable_can_be_set_and_got()
    {
        $column = new Column;

        $column->setOrderable(true);

        $this->assertTrue($column->isOrderable());
    }

    /**
     * @return void
     */
    public function test_passed_if_search_can_be_set_and_got()
    {
        $column = new Column;

        $search = new Search;

        $search->setValue('test');

        $column->setSearch($search);

        $this->assertEquals('test', $column->getSearch()->getValue());
    }

    /**
     * @return void
     */
    public function test_passed_if_searchable_can_be_set_and_got()
    {
        $column = new Column;

        $column->setSearchable(true);

        $this->assertTrue($column->isSearchable());
    }
}
