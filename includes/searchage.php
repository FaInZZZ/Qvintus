<?php
// Include the database configuration file for establishing a connection to the database
include_once 'config.php'; 

// Function to search and display age categories based on user input
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";

    // Prepare an SQL statement to fetch age categories matching the search term
    $stmt = $pdo->prepare("SELECT id_age, age_name FROM table_age WHERE age_name LIKE :search");
    // Bind the search term to the SQL query securely to prevent SQL injection
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching results as an associative array
    $resultsAge = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Loop through the results and generate HTML to display each age category
    foreach ($resultsAge as $row) {
        echo '<div class="col-md-4 mb-2">'; // Create a column for each age category
        echo '<div class="card">'; // Start a card to display the age category information
        echo '<div class="card-body">'; // Card body to contain the content
        echo '<h5 class="card-title">' . htmlspecialchars($row['age_name']) . '</h5>'; // Display the age category name securely
        echo '<button class="btn custom-btn edit-btn" 
                    data-id="' . $row['id_age'] . '" 
                    data-name="' . htmlspecialchars($row['age_name']) . '">
                    Edit
                  </button>'; // Add an Edit button with data attributes for age category details
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
