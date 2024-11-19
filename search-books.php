<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX Search</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <input type="text" id="search" placeholder="Search for projects...">
    <div id="result"></div>

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
</body>
</html>

