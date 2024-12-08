<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST['clan'])) {
    $lanName = $_POST['lanName'];
    if (!empty($lanName)) {
        createlan($pdo, $lanName); 
    }
}

if (isset($_POST['editlan'])) {
    $lanId = $_POST['lanId'];
    $updatedName = $_POST['updatedName'];
    if (!empty($updatedName) && !empty($lanId)) {
        updatelan($pdo, $lanId, $updatedName);
    }
}

if (isset($_POST['deletelan'])) {
    $lanId = $_POST['lanId'];
    if (!empty($lanId)) {
        deletelan($pdo, $lanId);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage lans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text-color-cus">Manage lans</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create lan</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit lan</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg ">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Create lan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="lanName" class="form-label">lan Name</label>
                            <input type="text" class="form-control" id="lanName" name="lanName" placeholder="Enter lan name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="clan" class="btn custom-btn btn-lg w-100">Create</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit lan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchlan" placeholder="Search for lans..." class="form-control mb-3">
                    <div id="resultlan" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditFormLabel">Edit lan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="lanId" name="lanId">
                        <div class="mb-3">
                            <label for="updatedName" class="form-label">Updated lan Name</label>
                            <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editlan" class="btn custom-btn btn-lg w-100">Save Changes</button>
                        <button type="submit" name="deletelan" class="btn btn-danger btn-lg w-100">Delete</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchlan").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchlan.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultlan").html(response);
                            $(".edit-btn").on("click", function() {
                                var lanId = $(this).data("id");
                                var lanName = $(this).data("name");
                                $("#lanId").val(lanId);
                                $("#updatedName").val(lanName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultlan").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

