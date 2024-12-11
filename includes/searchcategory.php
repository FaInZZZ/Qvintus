<?php
include_once 'config.php'; 

if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";

    $stmt = $pdo->prepare("SELECT id_category, category_name FROM table_category WHERE category_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsCate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultsCate as $row) {
        echo '<div class="col-md-4 mb-2">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row['category_name']) . '</h5>';
        echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_category'] . '" data-name="' . htmlspecialchars($row['category_name']) . '">Edit</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>