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
    public function test_get_name()
    {
        $text = 'draw=1&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&order%5B0%5D%5Bname%5D=custom_name';

        $request = Request::fromString($text);

        $orders = $request->getOrders();

        $expect = 'custom_name';

        $actual = $orders[0]->getName();

        $this->assertEquals($expect, $actual);
    }
}
