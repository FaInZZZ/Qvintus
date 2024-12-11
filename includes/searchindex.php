<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";  

    $stmt = $pdo->prepare("
        SELECT 
            table_bocker.id_bok,
            table_bocker.title,
            table_bocker.bok_img,
            GROUP_CONCAT(DISTINCT table_author.author_name SEPARATOR ', ') AS author,
            GROUP_CONCAT(DISTINCT table_genre.genre_name SEPARATOR ', ') AS genre,
            table_category.category_name AS category,
            table_serie.serie_name AS serie
        FROM 
            table_bocker
        INNER JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author
        INNER JOIN 
            book_genre ON table_bocker.id_bok = book_genre.book_id
        INNER JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre
        INNER JOIN 
            table_category ON table_bocker.category_fk = table_category.id_category
        INNER JOIN 
            table_serie ON table_bocker.serie_fk = table_serie.id_serie
        WHERE 
            table_bocker.title LIKE ? OR 
            table_author.author_name LIKE ? OR 
            table_category.category_name LIKE ? OR 
            table_genre.genre_name LIKE ? OR 
            table_serie.serie_name LIKE ?
        GROUP BY 
            table_bocker.id_bok
        LIMIT 10;
    ");

    $stmt->execute([$search, $search, $search, $search, $search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        echo "
            <div class='list-group-item'>
                <h5 class='mb-1'>" . htmlspecialchars($row['title']) . "</h5>";
        
               
                echo "<img src='img/" . htmlspecialchars($row['bok_img']) . "' alt='" . htmlspecialchars($row['title']) . "' class='img-thumbnail mb-2' style='max-width: 150px;'></br>";


                
                

        echo "
                <small><strong>Author(s):</strong> " . htmlspecialchars($row['author']) . "</small><br>
                <small><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</small><br>
                <small><strong>Genre(s):</strong> " . htmlspecialchars($row['genre']) . "</small><br>
                <small><strong>Series:</strong> " . htmlspecialchars($row['serie']) . "</small>
                <a href='single-book.php?BookID=" . urlencode($row['id_bok']) . "' class='btn custom-btn btn-sm mt-2'>View</a>
            </div>
        ";
    }

    if (!$results) {
        echo "<div class='list-group-item text-warning'>No results found.</div>";
    }
}

    ?>
</body>
</html>