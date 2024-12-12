<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/admin.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Dashboard</title>
</head>
<body>




<main class="container mt-4">
        <div class="row justify-content-center">
            <div class="text-center mb-3 mt-3">
        <h1>Admin dashboard</h1>
        </div>
            <div class="col-lg-4 col-md-6">
                <a href="search-accounts.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Edit Users</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="editaccount.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Edit account</h5>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="register.php" class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Register user</h5>
                    </div>
                </a>
            </div>
            
            
          
        </div>
    </main>
    
</body>
</html>