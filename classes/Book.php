<?php

class Book
{
    private PDO $connection;
    public const TABLE = 'books';

    public int $id;
    public string $name;
    public int $author_id;

    public function __construct(Database $db)
    {
        $this->connection = $db->getConnection();
    }

    public function create(): bool
    {
        $query = "INSERT INTO " . self::TABLE . "(name, author_id) VALUES (?, ?)";
        $stmnt = $this->connection->prepare($query);
        $res = $stmnt->execute([$this->name, $this->author_id]);

        $this->id = $this->connection->lastInsertId();

        return $res;
    }

    public function update(): bool
    {
        $query = "UPDATE " . self::TABLE .
            " SET name=?, author_id=? WHERE id=?";
        $stmnt = $this->connection->prepare($query);

        return $stmnt->execute([$this->name, $this->author_id, $this->id]);
    }
}
