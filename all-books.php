<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$bookid = isset($_GET['statusid']) ? $_GET['statusid'] : 0;



if ($bookid == 1) {
    $getRareBooks = getRareBook($pdo);
} elseif ($bookid == 3) {
    $getpopularbooks = getPopularBook($pdo);
    }   else {
        $getallbooks = getBook($pdo);;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php

if ($bookid == 1 && isset($getRareBooks)) {
    echo "<h2 class='my-4 text-center'>Rare Books</h2>";
    echo '<div class="container">';
    foreach (array_chunk($getRareBooks, 5) as $bookRow) {
        echo '<div class="row justify-content-center mb-4">';
        foreach ($bookRow as $book) {
            echo '<div class="col-6 col-md-4 col-lg-2 text-center">';
            echo '    <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="text-decoration-none text-dark">';
            echo '        <div class="card h-100">';
            echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($book['title']) . '" style="height: 200px; object-fit: cover;">';
            echo '            <div class="card-body p-2">';
            echo '                <h6 class="card-title text-truncate" style="font-size: 0.9rem;">' . htmlspecialchars($book['title']) . '</h6>';
            echo '                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;">By ' . htmlspecialchars($book['authors']) . '</p>';
            echo '                <p class="card-text text-muted" style="font-size: 0.7rem;">Published: ' . htmlspecialchars($book['date']) . '</p>';
            echo '                <p class="card-text">' . htmlspecialchars($book['description']) . '</p>';
            echo '            </div>';
            echo '        </div>';
            echo '    </a>';
            echo '</div>';
        }
        echo '</div>';
    }
    echo '</div>';


} elseif (isset($getpopularbooks)) { 
    echo "<h2 class='my-4 text-center'>Popular Books</h2>";
    echo '<div class="container">';
    foreach (array_chunk($getpopularbooks, 5) as $bookRow) { 
        echo '<div class="row justify-content-center mb-4">'; 
        foreach ($bookRow as $book) {
            echo '<div class="col-6 col-md-4 col-lg-2 text-center">'; 
            echo '    <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="text-decoration-none text-dark">'; 
            echo '        <div class="card h-100">'; 
            echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($book['title']) . '" style="height: 200px; object-fit: cover;">'; // Adjust image size
            echo '            <div class="card-body p-2">'; 
            echo '                <h6 class="card-title text-truncate" style="font-size: 0.9rem;">' . htmlspecialchars($book['title']) . '</h6>'; 
            echo '                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;">By ' . htmlspecialchars($book['authors']) . '</p>'; 
            echo '                <p class="card-text text-muted" style="font-size: 0.7rem;">Published: ' . htmlspecialchars($book['date']) . '</p>';
            echo '                <p class="card-text">' . htmlspecialchars($book['description']) . '</p>'; 
            echo '            </div>';
            echo '        </div>';
            echo '    </a>';
            echo '</div>';
        }
        echo '</div>'; 
    }
    echo '</div>'; 


} elseif (isset($getallbooks)) { 
    echo "<h2 class='my-4 text-center'>All books</h2>";
    echo '<div class="container">'; 
    foreach (array_chunk($getallbooks, 5) as $bookRow) { 
        echo '<div class="row justify-content-center mb-4">'; 
        foreach ($bookRow as $book) {
            echo '<div class="col-6 col-md-4 col-lg-2 text-center">'; 
            echo '    <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="text-decoration-none text-dark">';
            echo '        <div class="card h-100">'; 
            echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="card-img-top img-fluid" alt="' . htmlspecialchars($book['title']) . '" style="height: 200px; object-fit: cover;">'; // Adjust image size
            echo '            <div class="card-body p-2">'; 
            echo '                <h6 class="card-title text-truncate" style="font-size: 0.9rem;">' . htmlspecialchars($book['title']) . '</h6>'; 
            echo '                <p class="card-text text-muted mb-0" style="font-size: 0.8rem;">' . htmlspecialchars($book['authors']) . '</p>'; 
            echo '                <p class="card-text text-muted" style="font-size: 0.7rem;">' . htmlspecialchars($book['date']) . '</p>';
            echo '                <p class="card-text text-muted" style="font-size: 0.9rem;">' . htmlspecialchars($book['price']) . ' €</p>';
            echo '            </div>';
            echo '        </div>';
            echo '    </a>';
            echo '</div>';
        }
        echo '</div>'; 
    }
    echo '</div>'; 
} else {
    echo "<p class='text-center'>No books found</p>";
}







?>

<?php 
include_once 'includes/footer.php';
?>

</body>
</html>
