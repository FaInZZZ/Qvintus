<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage book</title>
</head>
<body>




<main class="container mt-4">
        <div class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
        <h1>Manage book</h1>
        </div>
            <div class="col-lg-4 col-md-6">
                <a href="createbook.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Create book</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="search-books.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Edit Books</h5>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <?php include_once 'includes/footer.php'; ?>
</body>
</html>