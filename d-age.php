<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST['createAge'])) {
    $AgeName = $_POST['AgeName'];
    if (!empty($AgeName)) {
        createAge($pdo, $AgeName); 
    }
}

if (isset($_POST['editAge'])) {
    $AgeId = $_POST['AgeId'];
    $updatedName = $_POST['updatedName'];
    if (!empty($updatedName) && !empty($AgeId)) {
        updateAge($pdo, $AgeId, $updatedName);
    }
}

if (isset($_POST['deleteAge'])) {
    $AgeId = $_POST['AgeId'];
    if (!empty($AgeId)) {
        deleteAge($pdo, $AgeId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text">Manage Ages</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create Age</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit Age</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Create Age</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="AgeName" class="form-label">Age</label>
                            <input type="number" class="form-control" id="AgeName" name="AgeName" placeholder="Enter Age name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="createAge" class="btn custom-btn btn-lg w-100">Create</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit Age</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="number" id="searchAge" placeholder="Search for Ages" class="form-control mb-3">
                    <div id="resultAge" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditFormLabel">Edit Age</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="AgeId" name="AgeId">
                        <div class="mb-3">
                            <label for="updatedName" class="form-label">Updated Age Name</label>
                            <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editAge" class="btn custom-btn btn-lg w-100">Save Changes</button>
                        <button type="submit" name="deleteAge" class="btn btn-danger btn-lg w-100">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchAge").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchAge.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultAge").html(response);
                            $(".edit-btn").on("click", function() {
                                var AgeId = $(this).data("id");
                                var AgeName = $(this).data("name");
                                $("#AgeId").val(AgeId);
                                $("#updatedName").val(AgeName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultAge").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
