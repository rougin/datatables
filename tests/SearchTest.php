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
    public function test_passed_if_default_regex_is_false()
    {
        $search = new Search;

        $this->assertFalse($search->isRegex());
    }

    /**
     * @return void
     */
    public function test_passed_if_default_value_is_null()
    {
        $search = new Search;

        $this->assertNull($search->getValue());
    }

    /**
     * @return void
     */
    public function test_passed_if_regex_false_when_parsed_false()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=false';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertFalse($search->isRegex());
    }

    /**
     * @return void
     */
    public function test_passed_if_regex_true_when_parsed_true()
    {
        $text = 'draw=1&search%5Bvalue%5D=test&search%5Bregex%5D=true';

        $request = Request::fromString($text);

        $search = $request->getSearch();

        $this->assertTrue($search->isRegex());
    }

    /**
     * @return void
     */
    public function test_passed_if_set_value_returns_value()
    {
        $search = new Search;

        $search->setValue('hello');

        $this->assertEquals('hello', $search->getValue());
    }
}
