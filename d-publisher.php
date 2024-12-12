<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();
$user->checkUserRole(5);

if (isset($_POST['cpublisher'])) {
    $publisherName = $_POST['publisherName'];
    if (!empty($publisherName)) {
        createpublisher($pdo, $publisherName); 
    }
}

if (isset($_POST['editpublisher'])) {
    $publisherId = $_POST['publisherId'];
    $updatedName = $_POST['updatedName'];
    if (!empty($updatedName) && !empty($publisherId)) {
        updatepublisher($pdo, $publisherId, $updatedName);
    }
}

if (isset($_POST['deletepublisher'])) {
    $publisherId = $_POST['publisherId'];
    if (!empty($publisherId)) {
        deletepublisher($pdo, $publisherId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage publishers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text">Manage publishers</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create publisher</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit publisher</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Create publisher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="publisherName" class="form-label">publisher</label>
                            <input type="text" class="form-control" id="publisherName" name="publisherName" placeholder="Enter publisher name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="cpublisher" class="btn custom-btn btn-lg w-100">Create</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit publisher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchpublisher" placeholder="Search for publishers" class="form-control mb-3">
                    <div id="resultpublisher" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditFormLabel">Edit publisher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="publisherId" name="publisherId">
                        <div class="mb-3">
                            <label for="updatedName" class="form-label">Updated publisher Name</label>
                            <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editpublisher" class="btn custom-btn btn-lg w-100">Save Changes</button>
                        <button type="submit" name="deletepublisher" class="btn btn-danger btn-lg w-100">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchpublisher").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchpublisher.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultpublisher").html(response);
                            $(".edit-btn").on("click", function() {
                                var publisherId = $(this).data("id");
                                var publisherName = $(this).data("name");
                                $("#publisherId").val(publisherId);
                                $("#updatedName").val(publisherName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultpublisher").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once 'includes/footerfixed.php'; ?>
</body>
</html>
