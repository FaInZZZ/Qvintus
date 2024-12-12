<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . trim($_GET['search']) . "%"; 

    // Fetch genres with their status
    $stmt = $pdo->prepare("SELECT id_genre, genre_name, p_status_fk FROM table_genre WHERE genre_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsGenre = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultsGenre) > 0) {
        foreach ($resultsGenre as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['genre_name']) . '</h5>';
            echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_genre'] . '" 
                    data-name="' . htmlspecialchars($row['genre_name']) . '" 
                    data-status="' . $row['p_status_fk'] . '">
                    Edit
                  </button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-muted">No genres found.</p>';
    }
}
?>
