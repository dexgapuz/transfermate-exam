<?php

class Database
{
    private const HOST = "localhost";
    private const DATABASE = "transfermate_db";
    private const USER = "postgres";
    private const PASSWORD = "root";

    private ?PDO $connection;

    public function getConnection(): PDO
    {
        $this->connection = null;
        $dsn = "pgsql:host=" . self::HOST . ";port=5432;dbname=" . self::DATABASE . ";";

        try {
            $this->connection = new PDO(
                $dsn,
                self::USER,
                self::PASSWORD,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }

        return $this->connection;
    }
}
