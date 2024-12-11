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
        LEFT JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author
        LEFT JOIN 
            book_genre ON table_bocker.id_bok = book_genre.book_id
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre
        LEFT JOIN 
            table_category ON table_bocker.category_fk = table_category.id_category
        LEFT JOIN 
            table_serie ON table_bocker.serie_fk = table_serie.id_serie
        WHERE 
            table_bocker.title LIKE ? OR 
            table_author.author_name LIKE ? OR 
            table_category.category_name LIKE ? OR 
            table_genre.genre_name LIKE ? OR 
            table_serie.serie_name LIKE ?
        GROUP BY 
            table_bocker.id_bok
    ");
    $stmt->execute([$search, $search, $search, $search, $search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
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
        <?php if (isset($results) && $results): ?>
            <?php foreach ($results as $row): ?>
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo 'img/' . htmlspecialchars($row['bok_img']); ?>" 
                             class="card-img-top" 
                             alt="Book Image" 
                             style="height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text">
                                <strong>Author:</strong> 
                                <span class="text-muted"><?php echo htmlspecialchars($row['author']); ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Category:</strong> 
                                <span class="text-muted"><?php echo htmlspecialchars($row['category']); ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Genre:</strong> 
                                <span class="text-muted"><?php echo htmlspecialchars($row['genre']); ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Serie:</strong> 
                                <span class="text-muted"><?php echo htmlspecialchars($row['serie']); ?></span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="single-book.php?BookID=<?php echo $row['id_bok']; ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="editbook.php?BookID=<?php echo $row['id_bok']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="deletebook.php?BookID=<?php echo $row['id_bok']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center" role="alert">
                    No results found.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
