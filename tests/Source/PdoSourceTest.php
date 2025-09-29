<?php

namespace Rougin\Datatables\Source;

use Rougin\Datatables\Fixture\Params;
use Rougin\Datatables\Fixture\UserLoader;
use Rougin\Datatables\Query;
use Rougin\Datatables\Request;
use Rougin\Datatables\Table;
use Rougin\Datatables\Testcase;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PdoSourceTest extends Testcase
{
    /**
     * @var \Rougin\Datatables\Source\SourceInterface
     */
    protected $source;

    /**
     * @return void
     */
    public function test_column_names()
    {
        $expected = '{"draw":3,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Angelica","Ramos","Chief Executive Officer (CEO)","London","2009-10-09","1200000.0"],["Ashton","Cox","Junior Technical Author","San Francisco","2009-01-12","86000.0"],["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Caesar","Vance","Pre-Sales Support","New York","2011-12-12","106450.0"],["Cara","Stevens","Sales Assistant","New York","2011-12-06","145600.0"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh","2012-03-29","433060.0"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::columnNames();

        $table = Table::fromRequest($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_few_columns()
    {
        $expected = '{"draw":4,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo"],["Angelica","Ramos","Chief Executive Officer (CEO)","London"],["Ashton","Cox","Junior Technical Author","San Francisco"],["Bradley","Greer","Software Engineer","London"],["Brenden","Wagner","Software Engineer","San Francisco"],["Brielle","Williamson","Integration Specialist","New York"],["Bruno","Nash","Software Engineer","London"],["Caesar","Vance","Pre-Sales Support","New York"],["Cara","Stevens","Sales Assistant","New York"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::fewColumns();

        $table = Table::fromRequest($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_global_and_column_search()
    {
        $expected = '{"draw":6,"recordsFiltered":3,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Garrett","Winters","Accountant","Tokyo","2011-07-25","170750.0"],["Jackson","Bradshaw","Director","New York","2008-09-26","645750.0"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::globalAndColumnSearch();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_global_search()
    {
        $expected = '{"draw":2,"recordsFiltered":6,"recordsTotal":57,"data":[["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Jackson","Bradshaw","Director","New York","2008-09-26","645750.0"],["Michael","Bruce","Javascript Developer","Singapore","2011-06-27","183000.0"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::globalSearch();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_initial_load()
    {
        $expected = '{"draw":1,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Angelica","Ramos","Chief Executive Officer (CEO)","London","2009-10-09","1200000.0"],["Ashton","Cox","Junior Technical Author","San Francisco","2009-01-12","86000.0"],["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Caesar","Vance","Pre-Sales Support","New York","2011-12-12","106450.0"],["Cara","Stevens","Sales Assistant","New York","2011-12-06","145600.0"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh","2012-03-29","433060.0"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::initialData();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_search_column()
    {
        $expected = '{"draw":5,"recordsFiltered":4,"recordsTotal":57,"data":[["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"]]}';

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $expected = str_replace('.0"', '"', $expected);
        // --------------------------------------------

        $request = Params::searchColumn();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        // Temporary fix for floating numbers as ------
        // results are different in PHP 8.1 onwards ---
        $actual = str_replace('.0"', '"', $actual);
        // --------------------------------------------

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $user = new UserLoader;

        $pdo = $user->getPdo();

        $this->source = new PdoSource($pdo);
    }

    /**
     * @param \Rougin\Datatables\Request $request
     * @param string|null                $name
     *
     * @return \Rougin\Datatables\Table
     */
    protected function setTable(Request $request, $name = null)
    {
        $table = Table::fromRequest($request, $name);

        $table->mapColumn(0, 'forename');
        $table->mapColumn(1, 'surname');
        $table->mapColumn(2, 'position');
        $table->mapColumn(3, 'office');
        $table->mapColumn(4, 'date_start');
        $table->mapColumn(5, 'salary');

        return $table;
    }
}
