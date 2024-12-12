<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$user->checkLoginStatus();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Project Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold">Search Projects</h1>
            <p class="text-muted">Find the books you are looking for by typing keywords below.</p>
        </div>

        <div class="mb-4">
            <input type="text" id="search" class="form-control form-control-lg" placeholder="Search for projects...">
        </div>

        <div id="result" class="row g-3">
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/search.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#result").html(response);
                        }
                    });
                } else {
                    $("#result").html("");
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
