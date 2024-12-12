<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    $stmt = $pdo->prepare("SELECT id_lan, lan_name FROM table_language WHERE lan_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultssprak = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultssprak) > 0) {
        foreach ($resultssprak as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['lan_name']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_lan'] . '" data-name="' . htmlspecialchars($row['lan_name']) . '">Edit</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">NoLanguages found.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Link to external CSS for styling -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Set character encoding -->
    <meta charset="UTF-8">
    <!-- Enable mobile responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set the page title -->
    <title>Document</title>
</head>
<body>
</body>
</html>
