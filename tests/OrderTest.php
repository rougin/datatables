<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderTest extends Testcase
{
    /**
     * @return void
     */
    public function test_passed_if_asc_sort_is_ascending()
    {
        $order = new Order;

        $order->setSort(Order::SORT_ASC);

        $this->assertTrue($order->isAscending());
    }

    /**
     * @return void
     */
    public function test_passed_if_default_sort_is_descending()
    {
        $order = new Order;

        $this->assertTrue($order->isDescending());

        $this->assertFalse($order->isAscending());
    }

    /**
     * @return void
     */
    public function test_passed_if_desc_sort_is_descending()
    {
        $order = new Order;

        $order->setSort(Order::SORT_DESC);

        $this->assertTrue($order->isDescending());
    }

    /**
     * @return void
     */
    public function test_passed_if_get_name_returns_set_value()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=custom_name';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $this->assertEquals('custom_name', $orders[0]->getName());
    }

    /**
     * @return void
     */
    public function test_passed_if_set_index_sets_correct_index()
    {
        $order = new Order;

        $order->setIndex(3);

        $this->assertEquals(3, $order->getIndex());
    }
}
