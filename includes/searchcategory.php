<?php
// Include the database configuration file for database connection
include_once 'config.php'; 

// Check if the 'search' parameter exists in the URL
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";

    // Prepare an SQL statement to search for categories by name
    $stmt = $pdo->prepare("SELECT id_category, category_name FROM table_category WHERE category_name LIKE :search");
    // Bind the search term to the prepared statement securely
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching results as an associative array
    $resultsCate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results and dynamically generate HTML to display the categories
    foreach ($resultsCate as $row) {
        echo '<div class="col-md-4 mb-2">'; // Column for each category
        echo '<div class="card">'; // Start a card for category information
        echo '<div class="card-body">'; // Card body to contain content
        echo '<h5 class="card-title">' . htmlspecialchars($row['category_name']) . '</h5>'; // Display the category name safely
        echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_category'] . '" 
                    data-name="' . htmlspecialchars($row['category_name']) . '">
                    Edit
                  </button>'; // Add an Edit button with data attributes for category details
        echo '</div>'; // End card body
        echo '</div>'; // End card
        echo '</div>'; // End column
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
