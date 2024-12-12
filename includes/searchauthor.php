<?php
// Include the database configuration file for database connection
include_once 'config.php';

// Function to search for authors and display matching results
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . trim($_GET['search']) . "%"; 

    // Prepare the SQL query to fetch authors whose names match the search term
    $stmt = $pdo->prepare("SELECT id_author, author_name FROM table_author WHERE author_name LIKE :search");
    // Bind the search parameter to the prepared statement
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching results as an associative array
    $resultsAuthor = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any authors match the search term
    if (count($resultsAuthor) > 0) {
        // Generate HTML for each matching author
        foreach ($resultsAuthor as $row) {
            echo '<div class="col-md-4 mb-2">'; // Column for each author
            echo '<div class="card">'; // Card for author information
            echo '<div class="card-body">'; // Card body containing content
            echo '<h5 class="card-title">' . htmlspecialchars($row['author_name']) . '</h5>'; // Display the author name safely
            echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_author'] . '" 
                    data-name="' . htmlspecialchars($row['author_name']) . '">
                    Edit
                  </button>'; // Add an Edit button with author details
            echo '</div>'; // End card body
            echo '</div>'; // End card
            echo '</div>'; // End column
        }
    } else {
        // Display a message if no authors match the search term
        echo '<p class="text-center text-muted">No Authors found.</p>';
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
