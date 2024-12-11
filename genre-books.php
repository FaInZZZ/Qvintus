<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$genreID = isset($_GET['genreID']) ? (int)$_GET['genreID'] : 0;

if ($genreID === 0) {
    echo "<p>Invalid genre ID.</p>";
    exit;
}

$books = getBooksByGenre($pdo, $genreID);

if (empty($books)) {
    echo "<p>No books found for this genre.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by Genre</title>
</head>
<body>
<div class="container mt-5">
    <h1>Books in Genre</h1>
    <div class="row">
        <?php foreach ($books as $book): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($book['titel']); ?></h5>
                        <p class="card-text"><strong>Description:</strong> 
                            <?php 
                                echo htmlspecialchars(
                                    mb_strlen($book['desc']) > 150 
                                        ? mb_substr($book['desc'], 0, 150) . '...' 
                                        : $book['desc']
                                ); 
                            ?>
                        </p>

                        <p class="card-text"><strong>Authors:</strong> <?php echo htmlspecialchars($book['authors']); ?></p>
                        <p class="card-text"><strong>Genres:</strong> <?php echo htmlspecialchars($book['genres']); ?></p>
                        <p class="card-text"><strong>Price:</strong> <?php echo htmlspecialchars($book['price']); ?>€</p>
                        <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="btn btn-primary btn-sm">View Book</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
