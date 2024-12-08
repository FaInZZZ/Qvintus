<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    $stmt = $pdo->prepare("SELECT id_sprak, sprak_namn FROM table_spark WHERE sprak_namn LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultssprak = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultssprak) > 0) {
        foreach ($resultssprak as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['sprak_namn']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_sprak'] . '" data-name="' . htmlspecialchars($row['sprak_namn']) . '">Edit</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">NoLanguages found.</p>';
    }
}
?>
