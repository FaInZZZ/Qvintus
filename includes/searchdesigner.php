<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    $stmt = $pdo->prepare("SELECT id_designer, designer_name FROM table_designer WHERE designer_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsDesigner = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultsDesigner) > 0) {
        foreach ($resultsDesigner as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['designer_name']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_designer'] . '" data-name="' . htmlspecialchars($row['designer_name']) . '">Edit</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">No Designers found found.</p>';
    }
}
?>
