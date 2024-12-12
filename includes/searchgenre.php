<?php
// Include the database configuration file
include_once 'config.php';

// Check if the 'search' parameter is set in the URL
if (isset($_GET['search'])) {
    // Sanitize and format the search term for use in the SQL query
    $search = "%" . trim($_GET['search']) . "%"; 

    // Prepare an SQL statement to search for genres by name using a wildcard match
    $stmt = $pdo->prepare("SELECT id_genre, genre_name, p_status_fk FROM table_genre WHERE genre_name LIKE :search");
    // Bind the sanitized search term to the prepared statement
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the SQL query
    $stmt->execute();

    // Fetch all matching records as an associative array
    $resultsGenre = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any results were found
    if (count($resultsGenre) > 0) {
        // Loop through the results and display them as cards
        foreach ($resultsGenre as $row) {
            echo '<div class="col-md-4 mb-2">'; // Start a column for each genre
            echo '<div class="card">'; // Create a card for the genre
            echo '<div class="card-body">'; // Card body for content
            echo '<h5 class="card-title">' . htmlspecialchars($row['genre_name']) . '</h5>'; // Display the genre name, escaping for security
            echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_genre'] . '" 
                    data-name="' . htmlspecialchars($row['genre_name']) . '" 
                    data-status="' . $row['p_status_fk'] . '">
                    Edit
                  </button>'; // Add an Edit button with data attributes for the genre details
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // Display a message if no genres match the search term
        echo '<p class="text-center text-muted">No genres found.</p>';
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
