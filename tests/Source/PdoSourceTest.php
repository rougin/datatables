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
    public function test_passed_if_all_columns_non_orderable()
    {
        $request = Params::allNonOrderable();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 8, 'filtered' => 57, 'total' => 57), array(
            array('Airi', 'Satou', 'Accountant', 'Tokyo', '2008-11-28', '162700.0'),
            array('Angelica', 'Ramos', 'Chief Executive Officer (CEO)', 'London', '2009-10-09', '1200000.0'),
            array('Ashton', 'Cox', 'Junior Technical Author', 'San Francisco', '2009-01-12', '86000.0'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000.0'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850.0'),
            array('Brielle', 'Williamson', 'Integration Specialist', 'New York', '2012-12-02', '372000.0'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500.0'),
            array('Caesar', 'Vance', 'Pre-Sales Support', 'New York', '2011-12-12', '106450.0'),
            array('Cara', 'Stevens', 'Sales Assistant', 'New York', '2011-12-06', '145600.0'),
            array('Cedric', 'Kelly', 'Senior Javascript Developer', 'Edinburgh', '2012-03-29', '433060.0'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_all_columns_non_searchable()
    {
        $request = Params::allNonSearchable();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 7, 'filtered' => 57, 'total' => 57), array(
            array('Airi', 'Satou', 'Accountant', 'Tokyo', '2008-11-28', '162700.0'),
            array('Angelica', 'Ramos', 'Chief Executive Officer (CEO)', 'London', '2009-10-09', '1200000.0'),
            array('Ashton', 'Cox', 'Junior Technical Author', 'San Francisco', '2009-01-12', '86000.0'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000.0'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850.0'),
            array('Brielle', 'Williamson', 'Integration Specialist', 'New York', '2012-12-02', '372000.0'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500.0'),
            array('Caesar', 'Vance', 'Pre-Sales Support', 'New York', '2011-12-12', '106450.0'),
            array('Cara', 'Stevens', 'Sales Assistant', 'New York', '2011-12-06', '145600.0'),
            array('Cedric', 'Kelly', 'Senior Javascript Developer', 'Edinburgh', '2012-03-29', '433060.0'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_column_names_from_data_field()
    {
        $expected = '{"draw":3,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Angelica","Ramos","Chief Executive Officer (CEO)","London","2009-10-09","1200000.0"],["Ashton","Cox","Junior Technical Author","San Francisco","2009-01-12","86000.0"],["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Caesar","Vance","Pre-Sales Support","New York","2011-12-12","106450.0"],["Cara","Stevens","Sales Assistant","New York","2011-12-06","145600.0"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh","2012-03-29","433060.0"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::columnNames();

        $table = Table::fromRequest($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_descending_order_is_applied()
    {
        $request = Params::descendingOrder();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 9, 'filtered' => 57, 'total' => 57), array(
            array('Prescott', 'Bartlett', 'Technical Author', 'London', '2011-05-07', '145000'),
            array('Gavin', 'Cortez', 'Team Leader', 'San Francisco', '2008-10-26', '235500'),
            array('Gloria', 'Little', 'Systems Administrator', 'New York', '2009-04-10', '237500'),
            array('Lael', 'Greer', 'Systems Administrator', 'London', '2009-02-27', '103500'),
            array('Tiger', 'Nixon', 'System Architect', 'Edinburgh', '2011-04-25', '320800'),
            array('Quinn', 'Flynn', 'Support Lead', 'Edinburgh', '2013-03-03', '342000'),
            array('Finn', 'Camacho', 'Support Engineer', 'San Francisco', '2009-07-07', '87500'),
            array('Olivia', 'Liang', 'Support Engineer', 'Singapore', '2011-02-03', '234500'),
            array('Sakura', 'Yamamoto', 'Support Engineer', 'Tokyo', '2009-08-19', '139575'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_fewer_columns_than_db_fields()
    {
        $expected = '{"draw":4,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo"],["Angelica","Ramos","Chief Executive Officer (CEO)","London"],["Ashton","Cox","Junior Technical Author","San Francisco"],["Bradley","Greer","Software Engineer","London"],["Brenden","Wagner","Software Engineer","San Francisco"],["Brielle","Williamson","Integration Specialist","New York"],["Bruno","Nash","Software Engineer","London"],["Caesar","Vance","Pre-Sales Support","New York"],["Cara","Stevens","Sales Assistant","New York"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::fewColumns();

        $table = Table::fromRequest($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_global_and_column_search_combined()
    {
        $expected = '{"draw":6,"recordsFiltered":3,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Garrett","Winters","Accountant","Tokyo","2011-07-25","170750.0"],["Jackson","Bradshaw","Director","New York","2008-09-26","645750.0"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::globalAndColumnSearch();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_global_search_matches_like()
    {
        $expected = '{"draw":2,"recordsFiltered":6,"recordsTotal":57,"data":[["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Jackson","Bradshaw","Director","New York","2008-09-26","645750.0"],["Michael","Bruce","Javascript Developer","Singapore","2011-06-27","183000.0"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::globalSearch();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_initial_load_returns_first_page()
    {
        $expected = '{"draw":1,"recordsFiltered":57,"recordsTotal":57,"data":[["Airi","Satou","Accountant","Tokyo","2008-11-28","162700.0"],["Angelica","Ramos","Chief Executive Officer (CEO)","London","2009-10-09","1200000.0"],["Ashton","Cox","Junior Technical Author","San Francisco","2009-01-12","86000.0"],["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"],["Caesar","Vance","Pre-Sales Support","New York","2011-12-12","106450.0"],["Cara","Stevens","Sales Assistant","New York","2011-12-06","145600.0"],["Cedric","Kelly","Senior Javascript Developer","Edinburgh","2012-03-29","433060.0"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::initialData();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_length_minus_one_shows_all()
    {
        $request = Params::lengthMinusOne();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $result = $query->getResult($table);

        $this->assertEquals(57, $result->getTotal());

        $this->assertEquals(57, $result->getFiltered());

        $this->assertEquals(57, count($result->getItems()));
    }

    /**
     * @return void
     */
    public function test_passed_if_multi_column_ordering_applied()
    {
        $request = Params::multiColumnOrder();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 12, 'filtered' => 57, 'total' => 57), array(
            array('Airi', 'Satou', 'Accountant', 'Tokyo', '2008-11-28', '162700.0'),
            array('Angelica', 'Ramos', 'Chief Executive Officer (CEO)', 'London', '2009-10-09', '1200000.0'),
            array('Ashton', 'Cox', 'Junior Technical Author', 'San Francisco', '2009-01-12', '86000.0'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000.0'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850.0'),
            array('Brielle', 'Williamson', 'Integration Specialist', 'New York', '2012-12-02', '372000.0'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500.0'),
            array('Caesar', 'Vance', 'Pre-Sales Support', 'New York', '2011-12-12', '106450.0'),
            array('Cara', 'Stevens', 'Sales Assistant', 'New York', '2011-12-06', '145600.0'),
            array('Cedric', 'Kelly', 'Senior Javascript Developer', 'Edinburgh', '2012-03-29', '433060.0'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_multiple_columns_searched()
    {
        $request = Params::multiColumnSearched();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 11, 'filtered' => 3, 'total' => 57), array(
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_no_search_value_no_where()
    {
        $request = Params::noSearchValue();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 13, 'filtered' => 57, 'total' => 57), array(
            array('Airi', 'Satou', 'Accountant', 'Tokyo', '2008-11-28', '162700.0'),
            array('Angelica', 'Ramos', 'Chief Executive Officer (CEO)', 'London', '2009-10-09', '1200000.0'),
            array('Ashton', 'Cox', 'Junior Technical Author', 'San Francisco', '2009-01-12', '86000.0'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000.0'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850.0'),
            array('Brielle', 'Williamson', 'Integration Specialist', 'New York', '2012-12-02', '372000.0'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500.0'),
            array('Caesar', 'Vance', 'Pre-Sales Support', 'New York', '2011-12-12', '106450.0'),
            array('Cara', 'Stevens', 'Sales Assistant', 'New York', '2011-12-06', '145600.0'),
            array('Cedric', 'Kelly', 'Senior Javascript Developer', 'Edinburgh', '2012-03-29', '433060.0'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_non_zero_start_offsets_results()
    {
        $request = Params::startBeyondTotal();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $result = $query->getResult($table);

        $this->assertEquals(57, $result->getTotal());

        $this->assertEquals(57, $result->getFiltered());

        $this->assertEquals(47, count($result->getItems()));
    }

    /**
     * @return void
     */
    public function test_passed_if_per_column_search_filters()
    {
        $expected = '{"draw":5,"recordsFiltered":4,"recordsTotal":57,"data":[["Bradley","Greer","Software Engineer","London","2012-10-13","132000.0"],["Brenden","Wagner","Software Engineer","San Francisco","2011-06-07","206850.0"],["Brielle","Williamson","Integration Specialist","New York","2012-12-02","372000.0"],["Bruno","Nash","Software Engineer","London","2011-05-03","163500.0"]]}';

        $expected = str_replace('.0"', '"', $expected);

        $request = Params::searchColumn();

        $table = $this->setTable($request, 'users');

        $query = new Query($request, $this->source);

        $actual = $query->getResult($table)->toJson();

        $actual = str_replace('.0"', '"', $actual);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_specific_column_not_orderable()
    {
        $request = Params::specificNotOrderable();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 15, 'filtered' => 57, 'total' => 57), array(
            array('Airi', 'Satou', 'Accountant', 'Tokyo', '2008-11-28', '162700.0'),
            array('Angelica', 'Ramos', 'Chief Executive Officer (CEO)', 'London', '2009-10-09', '1200000.0'),
            array('Ashton', 'Cox', 'Junior Technical Author', 'San Francisco', '2009-01-12', '86000.0'),
            array('Bradley', 'Greer', 'Software Engineer', 'London', '2012-10-13', '132000.0'),
            array('Brenden', 'Wagner', 'Software Engineer', 'San Francisco', '2011-06-07', '206850.0'),
            array('Brielle', 'Williamson', 'Integration Specialist', 'New York', '2012-12-02', '372000.0'),
            array('Bruno', 'Nash', 'Software Engineer', 'London', '2011-05-03', '163500.0'),
            array('Caesar', 'Vance', 'Pre-Sales Support', 'New York', '2011-12-12', '106450.0'),
            array('Cara', 'Stevens', 'Sales Assistant', 'New York', '2011-12-06', '145600.0'),
            array('Cedric', 'Kelly', 'Senior Javascript Developer', 'Edinburgh', '2012-03-29', '433060.0'),
        ));

        $this->assertEquals($expected, $query);
    }

    /**
     * @return void
     */
    public function test_passed_if_specific_column_not_searchable()
    {
        $request = Params::specificNotSearchable();

        $query = $this->getJsonResult($request, 'users');

        $expected = $this->getJsonLines(array('draw' => 14, 'filtered' => 2, 'total' => 57), array(
            array('Jackson', 'Bradshaw', 'Director', 'New York', '2008-09-26', '645750'),
            array('Michael', 'Bruce', 'Javascript Developer', 'Singapore', '2011-06-27', '183000'),
        ));

        $this->assertEquals($expected, $query);
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
     * @param array<string, mixed> $meta
     * @param string[][]           $data
     *
     * @return string
     */
    protected function getJsonLines($meta, $data)
    {
        $draw = $meta['draw'];

        $filtered = $meta['filtered'];

        $total = $meta['total'];

        $items = json_encode($data);

        $items = str_replace('.0"', '"', $items);

        return '{"draw":' . $draw . ',"recordsFiltered":' . $filtered . ',"recordsTotal":' . $total . ',"data":' . $items . '}';
    }

    /**
     * @param \Rougin\Datatables\Request $request
     * @param string|null                $name
     *
     * @return string
     */
    protected function getJsonResult(Request $request, $name = null)
    {
        $table = $this->setTable($request, $name);

        $query = new Query($request, $this->source);

        $json = $query->getResult($table)->toJson();

        return str_replace('.0"', '"', $json);
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
