<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$user->checkLoginStatus();
$user->checkUserRole(5);

if(isset($_POST['submitHistory'])) {
    $History = insertNewHistory($pdo);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Post</title>
</head>
<body class="bg-light">
<form action="" method="post" enctype="multipart/form-data">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 w-100" style="max-width: 600px;">
            <h1 class="text-center mb-4">Create a History Post</h1>
                <div class="mb-3">
                    <label for="history_title" class="form-label">History Title</label>
                    <input type="text" class="form-control" id="history_title" name="history_title" placeholder="Enter title here..." required>
                </div>
                <div class="mb-3">
                    <label for="history_desc" class="form-label">History Description</label>
                    <textarea class="form-control" id="history_desc" name="history_desc" placeholder="Write a description..." rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label for="img">Add image</label>
                    <input type="file" class="form-control" id="book_img" name="book_img" placeholder="Upload Image"></input>
                </div>
                </form>
                <button type="submit" name="submitHistory" class="btn custom-btn w-100">Submit</button>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <?php include_once 'includes/footer.php'; ?>
</body>
</html>