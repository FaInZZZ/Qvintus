<?php
// Include the database configuration file to connect to the database
include_once 'config.php';

// Function to search and display users based on the search term
if (isset($_GET['search'])) {
    // Format the search term with wildcard characters for a SQL LIKE query
    $search = "%" . $_GET['search'] . "%";

    // Prepare an SQL statement to fetch users whose names match the search term
    $stmt = $pdo->prepare("SELECT u_id, u_name FROM table_users WHERE u_name LIKE :search");
    // Bind the search term to the query securely to prevent SQL injection
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    // Execute the query
    $stmt->execute();

    // Fetch all matching user results as an associative array
    $resultsUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any matching users
    if (!empty($resultsUsers)) {
        // Loop through the results and dynamically generate user cards
        foreach ($resultsUsers as $row) {
            echo '<div class="col-md-4 mb-2">'; // Column for each user
            echo '<div class="card">'; // Card to display user information
            echo '<div class="card-body">'; // Card body to contain content
            echo '<h5 class="card-title">' . htmlspecialchars($row['u_name']) . '</h5>'; // Display the user name securely
            echo '<a href="editusers.php?id=' . $row['u_id'] . '" class="btn custom-btn">View User</a>'; // Add a link to edit or view the user details
            echo '</div>'; // End card body
            echo '</div>'; // End card
            echo '</div>'; // End column
        }
    } else {
        // Display a message if no users are found
        echo '<div class="col-12"><p>No users found.</p></div>';
    }
} else {
    // Display a message for invalid or missing search requests
    echo '<div class="col-12"><p>Invalid request.</p></div>';
}
?>
