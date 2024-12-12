<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();
$user->checkUserRole(5);

if (isset($_POST['cserie'])) {
    $serieName = $_POST['serieName'];
    if (!empty($serieName)) {
        createserie($pdo, $serieName); 
    }
}

if (isset($_POST['editserie'])) {
    $serieId = $_POST['serieId'];
    $updatedName = $_POST['updatedName'];
    if (!empty($updatedName) && !empty($serieId)) {
        updateserie($pdo, $serieId, $updatedName);
    }
}

if (isset($_POST['deleteserie'])) {
    $serieId = $_POST['serieId'];
    if (!empty($serieId)) {
        deleteserie($pdo, $serieId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-around align-items-center mb-4 flex-wrap">
            <h1 class="text">Manage Series</h1>
            <div>
                <button type="button" class="btn custom-btn btn-lg me-3 w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalCreate">Create serie</button>
                <button type="button" class="btn btn-secondary btn-lg w-auto mb-2" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit serie</button>
            </div>
        </div>
    </div>

   
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg">
                    <h5 class="modal-title text-white" id="modalCreateLabel">Create serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="serieName" class="form-label">serie</label>
                            <input type="text" class="form-control" id="serieName" name="serieName" placeholder="Enter serie name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="cserie" class="btn custom-btn btn-lg w-100">Create</button>
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
                    <h5 class="modal-title" id="modalEditLabel">Edit serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchserie" placeholder="Search for Series" class="form-control mb-3">
                    <div id="resultserie" class="row"></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="modalEditFormLabel">Edit serie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" id="serieId" name="serieId">
                        <div class="mb-3">
                            <label for="updatedName" class="form-label">Updated serie Name</label>
                            <input type="text" class="form-control" id="updatedName" name="updatedName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="editserie" class="btn custom-btn btn-lg w-100">Save Changes</button>
                        <button type="submit" name="deleteserie" class="btn btn-danger btn-lg w-100">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#searchserie").on("input", function() {
                var query = $(this).val();
                if (query != "") {
                    $.ajax({
                        url: "includes/searchserie.php",
                        method: "GET",
                        data: { search: query },
                        success: function(response) {
                            $("#resultserie").html(response);
                            $(".edit-btn").on("click", function() {
                                var serieId = $(this).data("id");
                                var serieName = $(this).data("name");
                                $("#serieId").val(serieId);
                                $("#updatedName").val(serieName);
                                $("#modalEdit").modal('hide');
                                $("#modalEditForm").modal('show');
                            });
                        }
                    });
                } else {
                    $("#resultserie").html("");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <?php include_once 'includes/footerfixed.php'; ?>
</body>
</html>
