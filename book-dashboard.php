<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();
$user->checkUserRole(5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<main class="container mt-4">
        <div class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
        <h1>Book dashboard</h1>
        </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-category.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Category</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-genre.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Genre</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-serie.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Serie</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-age.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Age recommendation</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-author.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Author</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-designer.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Designer</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="create-history.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">History</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-lan.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Language</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="d-publisher.php   " class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Publisher</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="book-modify.php   " class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Books</h5>
                    </div>
                </a>
            </div>
            
            
          
        </div>
    </main>



    <?php include_once 'includes/footer.php'; ?>

    
</body>
</html>