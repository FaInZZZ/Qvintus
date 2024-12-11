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
    foreach ($getRareBooks as $book) {
        echo '<div class="card mb-5 mx-auto" style="max-width: 900px;">'; 
        echo '    <div class="row g-0">';
        echo '        <div class="col-md-5">'; 
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['title']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['title']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['authors']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['date']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['description']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} elseif (isset($getpopularbooks)) { 
    echo "<h2 class='my-4 text-center'>Popular Books</h2>"; 
    foreach ($getpopularbooks as $book) {
        echo '<div class="card mb-5 mx-auto" style="max-width: 900px;">'; 
        echo '    <div class="row g-0">';
        echo '        <div class="col-md-5">'; 
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['title']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['title']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['authors']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['date']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['description']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} elseif (isset($getallbooks)) { 
    echo "<h2 class='my-4 text-center'>Popular Books</h2>"; 
    foreach ($getallbooks as $book) {
        echo '<div class="card mb-5 mx-auto" style="max-width: 900px;">'; 
        echo '    <div class="row g-0">';
        echo '        <div class="col-md-5">'; 
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['title']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['title']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['authors']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['date']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['description']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} else {
    echo"No books found";
}



?>


</body>
</html>
