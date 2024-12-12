<?php
// Include the database configuration file for database connection
include_once 'config.php'; 

// Function to search and display series based on the search term
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";

    // Prepare an SQL statement to fetch series whose names match the search term
    $stmt = $pdo->prepare("SELECT pub_id, pub_name FROM table_serie WHERE pub_name LIKE :search");
    // Bind the search term to the SQL query securely
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching series results as an associative array
    $resultsCate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results and dynamically generate cards for each series
    foreach ($resultsCate as $row) {
        echo '<div class="col-md-4 mb-2">'; // Create a column for each series
        echo '<div class="card">'; // Start the card to display series information
        echo '<div class="card-body">'; // Card body to contain content
        echo '<h5 class="card-title">' . htmlspecialchars($row['pub_name']) . '</h5>'; // Safely display the series name
        echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_pub'] . '" 
                    data-name="' . htmlspecialchars($row['pub_name']) . '">
                    Edit
                  </button>'; // Add an Edit button with series details as data attributes
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

