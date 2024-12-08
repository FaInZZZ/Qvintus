<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST['cauthor'])) {
    $authorName = $_POST['authorName'];
    if (!empty($authorName)) {
        createauthor($pdo, $authorName); 
    }
}

if (isset($_POST['editauthor'])) {
    $authorId = $_POST['authorId'];
    $updatedName = $_POST['updatedName'];
    if (!empty($updatedName) && !empty($authorId)) {
        updateauthor($pdo, $authorId, $updatedName);
    }
}

if (isset($_POST['deleteauthor'])) {
    $authorId = $_POST['authorId'];
    if (!empty($authorId)) {
        deleteauthor($pdo, $authorId);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage authors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text-color-cus">Manage authors</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create author</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit author</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg ">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Create author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="authorName" class="form-label">author Name</label>
                            <input type="text" class="form-control" id="authorName" name="authorName" placeholder="Enter author name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="cauthor" class="btn custom-btn btn-lg w-100">Create</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchauthor" placeholder="Search for authors..." class="form-control mb-3">
                    <div id="resultauthor" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditFormLabel">Edit author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="authorId" name="authorId">
                        <div class="mb-3">
                            <label for="updatedName" class="form-label">Updated author Name</label>
                            <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editauthor" class="btn custom-btn btn-lg w-100">Save Changes</button>
                        <button type="submit" name="deleteauthor" class="btn btn-danger btn-lg w-100">Delete</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchauthor").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchauthor.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultauthor").html(response);
                            $(".edit-btn").on("click", function() {
                                var authorId = $(this).data("id");
                                var authorName = $(this).data("name");
                                $("#authorId").val(authorId);
                                $("#updatedName").val(authorName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultauthor").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
