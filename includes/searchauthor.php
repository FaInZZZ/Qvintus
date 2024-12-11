<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    $stmt = $pdo->prepare("SELECT id_author, author_name FROM table_author WHERE author_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultsAuthor) > 0) {
        foreach ($resultsAuthor as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['author_name']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" data-id="' . $row['id_author'] . '" data-name="' . htmlspecialchars($row['author_name']) . '">Edit</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">No Authors found.</p>';
    }
}
?>