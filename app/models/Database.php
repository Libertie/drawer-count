<?php

namespace App\Models;

class Database
{
    protected $pdo;

    public function __construct($config)
    {
        try {
            $this->pdo = new \PDO('sqlite:app/resources/database.sqlite');
        } catch (\PDOException $e) {
            die('Error: ' . $e->getMessage());
        }

        $this->createTables();
    }

    protected function createTables()
    {
        $this->pdo->exec('CREATE TABLE IF NOT EXISTS drawers (
            id INTEGER PRIMARY KEY,
            total DECIMAL NOT NULL,
            expected DECIMAL DEFAULT NULL,
            discrepancy DECIMAL DEFAULT NULL,
            details TEXT NOT NULL,
            note TEXT DEFAULT NULL,
            created TEXT NOT NULL
        )');
    }

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

    public function getDrawers()
    {
        $query = $this->pdo->query('SELECT id, total, expected, discrepancy, details, note, created
            FROM drawers
            ORDER BY created DESC
            LIMIT 50');
        $drawers = [];
        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $drawers[] = $row;
        }

        return $drawers;
    }
}
