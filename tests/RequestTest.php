<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class RequestTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_columns_parse_explicit_name()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=forename&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $this->assertEquals('forename', $columns[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_columns_parse_numeric_data()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $this->assertCount(2, $columns);

        $this->assertNull($columns[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_columns_parse_orderable_flag()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=false&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $this->assertTrue($columns[0]->isOrderable());

        $this->assertFalse($columns[1]->isOrderable());
    }

    /**
     * @return void
     */
    public function test_passed_if_columns_parse_per_search_value()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=test&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $search = $columns[0]->getSearch();

        $this->assertEquals('test', $search->getValue());
    }

    /**
     * @return void
     */
    public function test_passed_if_columns_parse_searchable_flag()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=0&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=1&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=false&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $this->assertTrue($columns[0]->isSearchable());

        $this->assertFalse($columns[1]->isSearchable());
    }

    /**
     * @return void
     */
    public function test_passed_if_columns_parse_string_data()
    {
        $text = 'draw=1&columns%5B0%5D%5Bdata%5D=forename&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false';

        $request = Request::fromString($text);

        $columns = $request->getColumns();

        $this->assertEquals('forename', $columns[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_draw_is_casted_to_int()
    {
        $text = 'draw=5';

        $request = Request::fromString($text);

        $this->assertEquals(5, $request->getDraw());
    }

    /**
     * @return void
     */
    public function test_passed_if_length_is_casted_to_int()
    {
        $text = 'draw=1&length=25';

        $request = Request::fromString($text);

        $this->assertEquals(25, $request->getLength());
    }

    /**
     * @return void
     */
    public function test_passed_if_orders_parse_asc_direction()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertTrue($orders[0]->isAscending());

        $this->assertFalse($orders[0]->isDescending());
    }

    /**
     * @return void
     */
    public function test_passed_if_orders_parse_desc_direction()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=desc&order%5B0%5D%5Bname%5D=';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertTrue($orders[0]->isDescending());

        $this->assertFalse($orders[0]->isAscending());
    }

    /**
     * @return void
     */
    public function test_passed_if_orders_parse_multi_columns()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=&order%5B1%5D%5Bcolumn%5D=3&order%5B1%5D%5Bdir%5D=desc&order%5B1%5D%5Bname%5D=';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertCount(2, $orders);

        $this->assertEquals(0, $orders[0]->getIndex());

        $this->assertEquals(3, $orders[1]->getIndex());
    }

    /**
     * @return void
     */
    public function test_passed_if_orders_parse_name_field()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=custom_name';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertEquals('custom_name', $orders[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_orders_parse_single_column()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=2&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertCount(1, $orders);

        $this->assertEquals(2, $orders[0]->getIndex());
    }

    /**
     * @return void
     */
    public function test_passed_if_search_parses_global_value()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=false';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertEquals('test', $search->getValue());
    }

    /**
     * @return void
     */
    public function test_passed_if_search_parses_regex_flag()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=true';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertTrue($search->isRegex());
    }

    /**
     * @return void
     */
    public function test_passed_if_start_is_casted_to_int()
    {
        $text = 'draw=1&start=50';

        $request = Request::fromString($text);

        $this->assertEquals(50, $request->getStart());
    }
}
