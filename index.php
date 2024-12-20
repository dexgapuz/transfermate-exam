<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfermate Exam</title>
    <style>
        .table-component {
            overflow: auto;
            width: 100%;
        }

        .table-component table {
            border: 1px solid #dededf;
            height: 100%;
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            border-spacing: 1px;
            text-align: left;
        }

        .table-component caption {
            caption-side: top;
            text-align: left;
        }

        .table-component th {
            border: 1px solid #dededf;
            background-color: #eceff1;
            color: #000000;
            padding: 5px;
        }

        .table-component td {
            border: 1px solid #dededf;
            background-color: #ffffff;
            color: #000000;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="search-form">
        <form action="index.php" method="get">
            <input type="text" name="search" placeholder="search">
            <input type="submit">
        </form>
    </div>
    <br />
    <div class="table-component">
        <table>
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Book</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require './classes/Database.php';
                require './classes/Author.php';

                $db = new Database();
                $author = new Author($db);
                $tableData = isset($_GET['search'])
                    ? $author->searchByNameWithBooks($_GET['search'])
                    : $author->getAllWithBooks();
            ?>
            <?php foreach($tableData as $data): ?>
                <tr>
                    <td><?= $data['author_name'] ?></td>
                    <td><?= $data['book_name'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
