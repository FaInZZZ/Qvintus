<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <div class="container">
        <h1>Search Users</h1>
        <input type="text" id="searchInput" name="search" placeholder="Search for a user" class="form-control mb-3">
        <div class="row" id="userResults"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                const searchValue = $(this).val();

                if (searchValue.trim().length > 0) {
                    $.ajax({
                        url: 'includes/search-accounts.php',
                        type: 'GET',
                        data: { search: searchValue },
                        success: function (response) {
                            $('#userResults').html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    $('#userResults').html('');
                }
            });
        });
    </script>
</body>
</html>
