<?php

require_once './classes/Database.php';
require_once './classes/Book.php';
require_once './classes/Author.php';

$xml = new SimpleXMLElement('./xml/test.xml', 0, true);

$db = new Database();

foreach ($xml as $data)
{
    $author = new Author($db);
    $book = new Book($db);
    $result = $author->findByNameWithBook($data->author, $data->name);
    if (!$result)
    {
        $author->name = $data->author;
        $author->create();

        $book->name = $data->name;
        $book->author_id = $author->id;
        $book->create();
    } else
    {
        $author->id = $result['author_id'];
        $author->name = $result['author_name'];
        $author->update();

        $book->id = $result['book_id'];
        $book->name = $result['book_name'];
        $book->author_id = $result['author_id'];
        $book->update();
    }
}
