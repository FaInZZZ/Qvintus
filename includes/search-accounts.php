<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";

    $stmt = $pdo->prepare("SELECT u_id, u_name FROM table_users WHERE u_name LIKE :search");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();

    $resultsUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($resultsUsers)) {
        foreach ($resultsUsers as $row) {
            echo '<div class="col-md-4 mb-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['u_name']) . '</h5>';
            echo '<a href="editusers.php?id=' . $row['u_id'] . '" class="btn custom-btn">View User</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-12"><p>No users found.</p></div>';
    }
} else {
    echo '<div class="col-12"><p>Invalid request.</p></div>';
}
?>
