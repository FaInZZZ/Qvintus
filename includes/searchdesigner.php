<?php
// Include the database configuration file
include_once 'config.php';

// Check if the 'search' parameter is present in the URL
if (isset($_GET['search'])) {
    // Sanitize and format the search term for a SQL LIKE query
    $search = "%" . trim($_GET['search']) . "%"; 

    // Prepare an SQL statement to search for designers by name using a wildcard
    $stmt = $pdo->prepare("SELECT id_designer, designer_name FROM table_designer WHERE designer_name LIKE :search");
    // Bind the sanitized search term to the prepared statement
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching results as an associative array
    $resultsDesigner = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any designers match the search term
    if (count($resultsDesigner) > 0) {
        // Loop through the results and generate cards for each designer
        foreach ($resultsDesigner as $row) {
            echo '<div class="col-md-4 mb-2">'; // Create a column for each designer
            echo '<div class="card">'; // Begin a card for designer information
            echo '<div class="card-body">'; // Card body for content
            echo '<h5 class="card-title">' . htmlspecialchars($row['designer_name']) . '</h5>'; // Display the designer name safely
            echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_designer'] . '" 
                    data-name="' . htmlspecialchars($row['designer_name']) . '">
                    Edit
                  </button>'; // Include an Edit button with data attributes for designer details
            echo '</div>'; // End card body
            echo '</div>'; // End card
            echo '</div>'; // End column
        }
    } else {
        // Display a message if no designers match the search term
        echo '<p class="text-center text-muted">No Designers found.</p>';
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
