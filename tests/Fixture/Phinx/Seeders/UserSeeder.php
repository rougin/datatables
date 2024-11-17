<?php

use Phinx\Seed\AbstractSeed;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $table = $this->table('users');

        $table->insert($this->getData());

        $table->saveData();
    }

    /**
     * @return array<string, mixed>[]
     */
    protected function getData()
    {
        $result = array();

        $items = require __DIR__ . '/../Sample.php';

        foreach ($items as $item)
        {
            $row = array();

            $row['forename'] = $item['forename'];
            $row['surname'] = $item['surname'];
            $row['position'] = $item['position'];
            $row['office'] = $item['office'];

            /** @var string */
            $dateStart = $item['date_start'];
            $time = strtotime($dateStart);
            $dateStart = date('Y-m-d', $time);
            $row['date_start'] = $dateStart;

            /** @var string */
            $salary = $item['salary'];
            $salary = str_replace('$', '', $salary);
            $salary = str_replace(',', '', $salary);
            $salary = floatval($salary);
            $row['salary'] = $salary;

            $row['created_at'] = date('Y-m-d H:i:s');

            $result[] = $row;
        }

        return $result;
    }
}
