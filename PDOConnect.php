<?php

class PDOConnector
{
    private static ?PDOConnector $instance = null;

    private ?PDO $db = null;

    private array $connectOptions = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    ];

    private function __construct()
    {
        try {
            $this->db = new PDO(
                "mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DATABASE']}",
                $_ENV["MYSQL_USER"],
                $_ENV["MYSQL_PASSWORD"],
                $this->connectOptions,
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public static function getInstance(): PDOConnector
    {
        return null === self::$instance 
            ? self::$instance = new static()
            : self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->db;
    }

    private function __clone(): void {}
}
