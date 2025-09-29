<?php

namespace Rougin\Datatables\Fixture;

/**
 * @package Datatables
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserLoader
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @return \PDO
     */
    public function getPdo()
    {
        $pdo = new \PDO('sqlite::memory:');

        // Set error mode for better debugging ---
        $attr = \PDO::ATTR_ERRMODE;

        $item = \PDO::ERRMODE_EXCEPTION;

        $pdo->setAttribute($attr, $item);
        // ---------------------------------------

        $this->pdo = $pdo;

        $this->import();

        return $this->pdo;
    }

    /**
     * @return void
     */
    protected function import()
    {
        // Create the "users" table -------------------
        $sql = 'CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            forename TEXT, surname TEXT, position TEXT,
            office TEXT, date_start TEXT, salary REAL,
            created_by TEXT, updated_by TEXT,
            created_at TEXT, updated_at TEXT
        )';

        $this->pdo->exec($sql);
        // --------------------------------------------

        // Populate the data from "UserSeeder" ------
        $this->pdo->beginTransaction();

        $sql = 'INSERT INTO users (forename, surname,
            position, office, date_start, salary,
            created_by, updated_by, created_at,
            updated_at) VALUES (:forename, :surname,
            :position, :office, :date_start, :salary,
            :created_by, :updated_by, :created_at,
            :updated_at)';

        $stmt = $this->pdo->prepare($sql);

        $items = require __DIR__ . '/UserSeeder.php';

        foreach ($items as $item)
        {
            $stmt->execute($item);
        }

        $this->pdo->commit();
        // ------------------------------------------
    }
}
