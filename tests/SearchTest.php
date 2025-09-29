<?php

namespace Rougin\Datatables;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SearchTest extends Testcase
{
    /**
     * @return void
     */
    public function test_is_regex_true()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=true';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertTrue($search->isRegex());
    }

    /**
     * @return void
     */
    public function test_is_regex_false()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=false';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertFalse($search->isRegex());
    }
}
