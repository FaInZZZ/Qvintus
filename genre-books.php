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
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by Genre</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Books in Genre</h1>
    <?php foreach (array_chunk($books, 5) as $bookRow): ?>
        <div class="row justify-content-center mb-4">
            <?php foreach ($bookRow as $book): ?>
                <div class="col-6 col-md-4 col-lg-2 text-center">
                    <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" style="text-decoration: none; color: inherit;">
                        <div class="card h-100">
                            <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top img-fluid" alt="Book Image" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <h6 class="card-title text-truncate" style="font-size: 0.9rem;"><?php echo htmlspecialchars($book['title']); ?></h6>
                                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;"><strong>Description:</strong>
                                    <?php echo htmlspecialchars(
                                        mb_strlen($book['description']) > 150 
                                            ? mb_substr($book['description'], 0, 150) . '...' 
                                            : $book['description']
                                    ); ?>
                                </p>
                                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;"><strong>Authors:</strong> <?php echo htmlspecialchars($book['authors']); ?></p>
                                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;"><strong>Genres:</strong> <?php echo htmlspecialchars($book['genres']); ?></p>
                                <p class="card-text text-muted" style="font-size: 0.8rem;"><strong>Price:</strong> <?php echo htmlspecialchars($book['price']); ?>€</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
