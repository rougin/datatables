<?php

namespace Rougin\Datatables\Request;

class SearchTest extends \PHPUnit_Framework_TestCase
{
    protected $search;

    public function setUp()
    {
        $factory = new SearchFactory;

        $factory->regex(true)->value('');

        $this->search = $factory->make();
    }

    public function testHttpMethod()
    {
        $data = array('value' => '', 'regex' => 'true');

        $result = SearchFactory::http($data);

        $this->assertEquals($this->search, $result);
    }

    public function testRegexMethod()
    {
        $result = (bool) $this->search->regex();

        $expected = true;

        $this->assertEquals($expected, $result);
    }

    public function testValueMethod()
    {
        $result = (string) $this->search->value();

        $expected = null;

        $this->assertEquals($expected, $result);
    }
}
