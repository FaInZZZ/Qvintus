<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST['cgenre'])) {
    $Cgenre = createGenre($pdo);
}

if (isset($_POST['egenre'])) {
    $Egenre = editGenre($pdo);
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    try {
        // Prepare a statement to search for genres in your database.
        $stmt = $pdo->prepare("SELECT id_genre, genre_namn FROM table_genre WHERE genre_namn LIKE :query");
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Fetch the results and output them.
        $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($genres) > 0) {
            foreach ($genres as $genre) {
                // Each result should be clickable to trigger the edit modal.
                echo '<div onclick="openEditModal(' . htmlspecialchars($genre['id_genre']) . ', \'' . htmlspecialchars($genre['genre_namn']) . '\')">'
                     . htmlspecialchars($genre['genre_namn']) . '</div>';
            }
        } else {
            echo '<div>No genres found</div>';
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Modals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal1">Create</button>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal2">Edit</button>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal3">Delete</button>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="modal1" tabindex="-1" aria-labelledby="modal1Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal1Label">Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="genreName" class="form-label">Genre Name</label>
                            <input type="text" class="form-control" id="genreName" name="genreName" placeholder="Enter genre name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="cgenre" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="modal2Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal2Label">Edit Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="editGenreForm">
                    <div class="modal-body">
                        <input type="text" id="search" placeholder="Search for Genres" onkeyup="searchGenre()">
                        <div id="result"></div>
                        <hr>
                        <input type="hidden" id="genreId" name="genreId">
                        <input type="text" id="genreName" name="genreName" placeholder="Edit Genre Name">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="egenre" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal (Placeholder) -->
    <div class="modal fade" id="modal3" tabindex="-1" aria-labelledby="modal3Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal3Label">Delete Genre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your delete logic here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchGenre() {
            var searchValue = document.getElementById('search').value;

            if (searchValue.length > 1) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'search_genre.php?query=' + encodeURIComponent(searchValue), true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('result').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            } else {
                document.getElementById('result').innerHTML = '';
            }
        }

        function openEditModal(genreId, genreName) {
            document.getElementById('genreId').value = genreId;
            document.getElementById('genreName').value = genreName;

            var editModal = new bootstrap.Modal(document.getElementById('modal2'));
            editModal.show();
        }

        function submitEditGenre() {
            document.getElementById('editGenreForm').submit();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
