<?php

namespace App\Models;

/*
|--------------------------------------------------------------------------
|   DATABASE OBJECT
|--------------------------------------------------------------------------
|
|   This object provides SQLite database access.
|
*/

class Database
{
    protected $pdo;

    /**
     *  Constructor
     *
     *  @param string $db_file The location of the sqlite database
     */
    public function __construct(string $db_file)
    {
        // If a database file does not exist, create it
        if (!is_file($db_file)) {
            // Add tables to the new database
            if (touch($db_file)) {
                $db_file_is_new = true;
            } else {
                die('Error: Database file "' . $db_file . '" could not be created. Please check folder permissions.');
            }
        }

        // Attempt to use the file as a data source
        try {
            $this->pdo = new \PDO('sqlite:' . $db_file);
        } catch (\PDOException $e) {
            die('Error: ' . $e->getMessage());
        }

        // If a new database file was created but tables cannot be added, die
        if (isset($db_file_is_new) && $this->createTables() === false) {
            unlink($db_file);
            die('Error: Database setup failed.');
        }
    }

    /**
     *  Create a drawers table in the database
     *
     *  @return int|false
     */
    protected function createTables()
    {
        return $this->pdo->exec('CREATE TABLE IF NOT EXISTS drawers (
            id INTEGER PRIMARY KEY,
            total INTEGER NOT NULL,
            expected INTEGER DEFAULT NULL,
            discrepancy INTEGER DEFAULT NULL,
            details TEXT NOT NULL,
            note TEXT DEFAULT NULL,
            created TEXT NOT NULL
        )');
    }

    /**
     *  Insert a drawer into the database
     *
     *  @param array $data A list of drawer attributes
     *  @return int The id of the successfully inserted drawer
     */
    public function insertDrawer($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO drawers(
                total, expected, discrepancy, details, created
            ) VALUES (
                :total, :expected, :discrepancy, :details, datetime(\'now\', \'localtime\')
            )');
        $stmt->execute([
            ':total' => $data['total'],
            ':expected' => $data['expected'],
            ':discrepancy' => $data['discrepancy'],
            ':details' => $data['details']
        ]);

        return $this->pdo->lastInsertId();
    }

    /**
     *  Retrieve previously inserted drawers, starting with the most recent
     *
     *  @param int $limit The number of records to retrieve
     *  @return array A list of records retrieved
     */
    public function getDrawers($limit = 50)
    {
        $query = $this->pdo->query('SELECT id, total, expected, discrepancy, details, note, created
            FROM drawers
            ORDER BY created DESC
            LIMIT '.$limit);

        // Loop through the query and populate an array to return
        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $drawers[] = $row;
        }

        return $drawers ?? [];
    }
}
