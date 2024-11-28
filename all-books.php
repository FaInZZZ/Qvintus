<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$bookid = isset($_GET['statusid']) ? $_GET['statusid'] : 0;



if ($bookid == 1) {
    $getRareBooks = getRareBook($pdo);
} elseif ($bookid == 2) {
    $getPopularBooks = getPopularBook($pdo);
} elseif ($bookid == 3) {
    $getPopularRNBooks = getPopularRNBook($pdo);
} else {
    echo "Invalid status";

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
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['titel']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['titel']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['forfattare_namn']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['utgiven']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['beskrivning']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} elseif ($bookid == 2 && isset($getPopularBooks)) {
    echo "<h2 class='my-4 text-center'>Popular Books</h2>";
    foreach ($getPopularBooks as $book) {
        echo '<div class="card mb-5 mx-auto" style="max-width: 900px;">'; 
        echo '    <div class="row g-0">';
        echo '        <div class="col-md-5">'; 
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['titel']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['titel']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['forfattare_namn']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['utgiven']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['beskrivning']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
} elseif ($bookid == 3 && isset($getPopularRNBooks)) {
    echo "<h2 class='my-4 text-center'>Popular RN Books</h2>";
    foreach ($getPopularRNBooks as $book) {
        echo '<div class="card mb-5 mx-auto" style="max-width: 900px;">'; 
        echo '    <div class="row g-0">';
        echo '        <div class="col-md-5">'; 
        echo '            <img src="img/' . htmlspecialchars($book['bok_img']) . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($book['titel']) . '">';
        echo '        </div>';
        echo '        <div class="col-md-7 d-flex flex-column">';  
        echo '            <div class="card-body">';
        echo '                <h3 class="card-title">' . htmlspecialchars($book['titel']) . '</h3>'; 
        echo '                <p class="card-text fs-5">By ' . htmlspecialchars($book['forfattare_namn']) . '</p>'; 
        echo '                <p class="card-text fs-6"><small class="text-muted">Published: ' . htmlspecialchars($book['utgiven']) . '</small></p>';
        echo '                <p class="card-text">' . htmlspecialchars($book['beskrivning']) . '</p>'; 
        echo '            </div>';
        echo '            <a href="single-book.php?BookID=' . htmlspecialchars($book['id_bok']) . '" class="btn custom-btn" style="width: 100px;">View</a>';  
        echo '        </div>';
        echo '    </div>';
        echo '</div>';
    }
}
?>


</body>
</html>
