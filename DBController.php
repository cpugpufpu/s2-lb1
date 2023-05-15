<?php

include_once __DIR__ . './PDOConnect.php';

class DBController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = PDOConnector::getInstance()->getConnection();
    }

    public function query(string $sql, ?array $values = []): array
    {
        $statement = $this->db->prepare($sql);

        foreach ($values as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
