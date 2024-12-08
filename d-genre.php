<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST['cgenre'])) {
    $genreName = $_POST['genreName'];
    $isPopular = isset($_POST['isPopular']) ? true : false;

    if (!empty($genreName)) {
        createGenre($pdo, $genreName, $isPopular); 
    }
}


if (isset($_POST['editGenre'])) {
    $genreId = $_POST['genreId'];
    $updatedName = $_POST['updatedName'];
    $isPopular = isset($_POST['isPopularEdit']) ? true : false;

    if (!empty($updatedName) && !empty($genreId)) {
        updateGenre($pdo, $genreId, $updatedName, $isPopular);
    }
}


if (isset($_POST['deleteGenre'])) {
    $genreId = $_POST['genreId'];
    if (!empty($genreId)) {
        deleteGenre($pdo, $genreId);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Genres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text-color-cus">Manage Genres</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create Genre</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit Genre</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header custom-bg ">
                <h5 class="modal-title text-white" id="modalCreateLabel">Create Genre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="genreName" class="form-label">Genre Name</label>
                        <input type="text" class="form-control" id="genreName" name="genreName" placeholder="Enter genre name" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="isPopular" name="isPopular">
                        <label for="isPopular" class="form-check-label">Mark as Popular</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="cgenre" class="btn custom-btn btn-lg w-100">Create</button>
                    <button type="button" class="btn btn-secondary btn-lg w-100" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


    
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="modalEditLabel">Edit Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchGenre" placeholder="Search for genres..." class="form-control mb-3">
                    <div id="resultGenre" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="modalEditFormLabel">Edit Genre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" id="genreId" name="genreId">
                    <div class="mb-3">
                        <label for="updatedName" class="form-label">Updated Genre Name</label>
                        <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="isPopularEdit" name="isPopularEdit">
                        <label for="isPopularEdit" class="form-check-label">Mark as Popular</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editGenre" class="btn custom-btn btn-lg w-100">Save Changes</button>
                    <button type="submit" name="deleteGenre" class="btn btn-danger btn-lg w-100">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script>
        $(document).ready(function() {
            $("#searchGenre").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchgenre.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultGenre").html(response);
                            $(".edit-btn").on("click", function() {
                                var genreId = $(this).data("id");
                                var genreName = $(this).data("name");
                                $("#genreId").val(genreId);
                                $("#updatedName").val(genreName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultGenre").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
