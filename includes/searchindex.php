<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Link to external CSS for styling -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Set character encoding -->
    <meta charset="UTF-8">
    <!-- Enable mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set the page title -->
    <title>Document</title>
</head>
<body>
<?php
// Include the database configuration file to establish a connection
include_once 'config.php';

// Function to search for books and related information based on a search term
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";  

    // Prepare an SQL query to fetch books and their related details
    $stmt = $pdo->prepare("
        SELECT 
            table_bocker.id_bok,                                  -- Book ID
            table_bocker.title,                                   -- Book Title
            table_bocker.bok_img,                                 -- Book Image
            GROUP_CONCAT(DISTINCT table_author.author_name SEPARATOR ', ') AS author, -- Concatenate multiple authors
            GROUP_CONCAT(DISTINCT table_genre.genre_name SEPARATOR ', ') AS genre,   -- Concatenate multiple genres
            table_category.category_name AS category,             -- Book Category
            table_serie.serie_name AS serie                       -- Book Series
        FROM 
            table_bocker
        INNER JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book -- Link books to authors
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author -- Fetch author names
        INNER JOIN 
            book_genre ON table_bocker.id_bok = book_genre.book_id  -- Link books to genres
        INNER JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre -- Fetch genre names
        INNER JOIN 
            table_category ON table_bocker.category_fk = table_category.id_category -- Fetch category names
        INNER JOIN 
            table_serie ON table_bocker.serie_fk = table_serie.id_serie -- Fetch series names
        WHERE 
            table_bocker.title LIKE ? OR                          -- Filter by title
            table_author.author_name LIKE ? OR                   -- Filter by author
            table_category.category_name LIKE ? OR               -- Filter by category
            table_genre.genre_name LIKE ? OR                     -- Filter by genre
            table_serie.serie_name LIKE ?                        -- Filter by series
        GROUP BY 
            table_bocker.id_bok                                   -- Group results by book ID
        LIMIT 10;                                                -- Limit results to 10
    ");

    // Execute the query with the search term applied to all filter conditions
    $stmt->execute([$search, $search, $search, $search, $search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through each result and dynamically generate an HTML block for display
    foreach ($results as $row) {
        echo "
            <div class='list-group-item'>
                <h5 class='mb-1'>" . htmlspecialchars($row['title']) . "</h5>"; // Display the book title securely
        
        echo "<img src='img/" . htmlspecialchars($row['bok_img']) . "' alt='" . htmlspecialchars($row['title']) . "' class='img-thumbnail mb-2' style='max-width: 150px;'></br>"; // Display the book image

        echo "
                <small><strong>Author(s):</strong> " . htmlspecialchars($row['author']) . "</small><br>
                <small><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</small><br>
                <small><strong>Genre(s):</strong> " . htmlspecialchars($row['genre']) . "</small><br>
                <small><strong>Series:</strong> " . htmlspecialchars($row['serie']) . "</small>
                <a href='single-book.php?BookID=" . urlencode($row['id_bok']) . "' class='btn custom-btn btn-sm mt-2'>View</a>
            </div>
        ";
    }

    // Display a fallback message if no results are found
    if (!$results) {
        echo "<div class='list-group-item text-warning'>No results found.</div>";
    }
}
?>
</body>
</html>
