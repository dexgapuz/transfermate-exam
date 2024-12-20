<?php

// require_once './Book.php';

class Author
{
    public const TABLE = 'authors';

    private PDO $connection;

    public int $id;
    public string $name;

    public function __construct(Database $db)
    {
        $this->connection = $db->getConnection();
    }

    public function create(): bool
    {
        $query = "INSERT INTO " . self::TABLE . " (name) VALUES (?)";
        $stmnt = $this->connection->prepare($query);
        $res = $stmnt->execute([$this->name]);

        $this->id = $this->connection->lastInsertId();

        return $res;
    }

    public function findByNameWithBook(string $authorName, string $bookName): array|bool
    {
        $query = "SELECT
                authorS.id AS author_id, authors.name AS author_name, books.id AS book_id, books.name AS book_name
            FROM authors
            INNER JOIN books ON authors.id=books.author_id
            WHERE authors.name=? AND books.name=?
            LIMIT 1";

        $stmnt = $this->connection->prepare($query);
        $stmnt->execute([$authorName, $bookName]);

        return $stmnt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(): bool
    {
        $query = "UPDATE " . self::TABLE .
            " SET name=? WHERE id=?";
        $stmnt = $this->connection->prepare($query);

        return $stmnt->execute([$this->name, $this->id]);
    }

    public function getAllWithBooks(): array
    {
        $query = "SELECT
                authors.id AS author_id, authors.name AS author_name, books.id AS book_id, books.name AS book_name
            FROM authors
            LEFT JOIN books ON authors.id=books.author_id";

        $stmnt = $this->connection->prepare($query);
        $stmnt->execute();

        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByNameWithBooks(string $search): array
    {
        $query = "SELECT
                authors.id AS author_id, authors.name AS author_name, books.id AS book_id, books.name AS book_name
            FROM authors
            LEFT JOIN books ON authors.id=books.author_id
            WHERE LOWER(authors.name) LIKE LOWER('{$search}%')";

        $stmnt = $this->connection->prepare($query);
        $stmnt->execute();

        return $stmnt->fetchAll(PDO::FETCH_ASSOC);
    }
}
