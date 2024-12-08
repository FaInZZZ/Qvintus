<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    $stmt = $pdo->prepare("SELECT id_forfattare, forfattare_namn FROM table_forfattare WHERE forfattare_namn LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultsAuthor) > 0) {
        foreach ($resultsAuthor as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['forfattare_namn']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_forfattare'] . '" data-name="' . htmlspecialchars($row['forfattare_namn']) . '">Edit</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">No Authors found.</p>';
    }
}
?>