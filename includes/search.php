<?php
// Include the database configuration file to connect to the database
include_once 'config.php';

// Function to handle search queries and fetch book-related data
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for SQL LIKE query
    $search = "%" . $_GET['search'] . "%";  

    // Prepare an SQL statement to fetch book details and related information
    $stmt = $pdo->prepare("
        SELECT 
            table_books.id_bok,
            table_books.title,
            table_books.bok_img,
            GROUP_CONCAT(DISTINCT table_author.author_name SEPARATOR ', ') AS author, -- Combine multiple authors into a single string
            GROUP_CONCAT(DISTINCT table_genre.genre_name SEPARATOR ', ') AS genre,   -- Combine multiple genres into a single string
            table_category.category_name AS category,                                -- Fetch book category
            table_serie.serie_name AS serie                                          -- Fetch book series
        FROM 
            table_books
        LEFT JOIN 
            book_author ON table_books.id_bok = book_author.id_book                -- Link books to their authors
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author          -- Fetch author names
        LEFT JOIN 
            book_genre ON table_books.id_bok = book_genre.book_id                  -- Link books to their genres
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre               -- Fetch genre names
        LEFT JOIN 
            table_category ON table_books.category_fk = table_category.id_category -- Fetch book categories
        LEFT JOIN 
            table_serie ON table_books.serie_fk = table_serie.id_serie             -- Fetch series names
        WHERE 
            table_books.title LIKE ? OR 
            table_author.author_name LIKE ? OR 
            table_category.category_name LIKE ? OR 
            table_genre.genre_name LIKE ? OR 
            table_serie.serie_name LIKE ?                                           -- Filter based on title, author, category, genre, or series
        GROUP BY 
            table_books.id_bok                                                     -- Group results by book ID
    ");
    // Execute the query with the search term applied to all filter conditions
    $stmt->execute([$search, $search, $search, $search, $search]);
    // Fetch all matching results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- External CSS for custom styling -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap for responsive design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Set character encoding -->
    <meta charset="UTF-8">
    <!-- Ensure mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
<div class="container mt-5">
    <div class="text-center">
        <h2>Search Results</h2>
    </div>
    <div class="container mt-5">
        <div class="row">
            <!-- Check if results exist -->
            <?php if (isset($results) && $results): ?>
                <!-- Loop through results and generate cards for each book -->
                <?php foreach ($results as $row): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <img src="<?php echo 'img/' . htmlspecialchars($row['bok_img']); ?>" 
                                 class="card-img-top" 
                                 alt="Book Image" 
                                 style="height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-truncate"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><strong>Author:</strong> <span class="text-muted"><?php echo htmlspecialchars($row['author']); ?></span></p>
                                <p class="card-text"><strong>Category:</strong> <span class="text-muted"><?php echo htmlspecialchars($row['category']); ?></span></p>
                                <p class="card-text"><strong>Genre:</strong> <span class="text-muted"><?php echo htmlspecialchars($row['genre']); ?></span></p>
                                <p class="card-text"><strong>Serie:</strong> <span class="text-muted"><?php echo htmlspecialchars($row['serie']); ?></span></p>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="single-book.php?BookID=<?php echo $row['id_bok']; ?>" class="btn custom-btn btn-lg mb-1">View</a>
                                <a href="editbook.php?BookID=<?php echo $row['id_bok']; ?>" class="btn btn-warning btn-lg mb-1">Edit</a>
                                <a href="deletebook.php?BookID=<?php echo $row['id_bok']; ?>" class="btn btn-danger btn-lg mb-1">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Message if no results are found -->
                <div class="col-12">
                    <div class="alert alert-warning text-center" role="alert">
                        No results found.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>

