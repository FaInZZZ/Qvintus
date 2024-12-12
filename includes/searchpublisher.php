<?php
// Include the database configuration file for database connection
include_once 'config.php'; 

// Function to search and display publishers based on the search term
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";

    // Prepare an SQL statement to fetch publishers whose names match the search term
    $stmt = $pdo->prepare("SELECT id_pub, id_pub FROM table_publisher WHERE id_pub LIKE :search");
    // Bind the search term to the SQL query securely
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching publishers results as an associative array
    $resultsCate = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results and dynamically generate cards for each publishers
    foreach ($resultsCate as $row) {
        echo '<div class="col-md-4 mb-2">'; // Create a column for each publishers
        echo '<div class="card">'; // Start the card to display publishers information
        echo '<div class="card-body">'; // Card body to contain content
        echo '<h5 class="card-title">' . htmlspecialchars($row['id_pub']) . '</h5>'; // Safely display the publishers name
        echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_pub'] . '" 
                    data-name="' . htmlspecialchars($row['id_pub']) . '">
                    Edit
                  </button>'; // Add an Edit button with publishers details as data attributes
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

