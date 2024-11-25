<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();

if (!isset($_GET['BookID'])) {
    die("BookID is required.");
}

$bookID = $_GET['BookID'];

$currentBook = getSingleBook($pdo, $bookID);
if (!$currentBook) {
    die("Book not found.");
}

$getCategoryInformation = getCategoryInformation($pdo);
$getAuthorInformation = getAuthorInformation($pdo);
$getGenreInformation = getGenreInformation($pdo);
$getSerieInformation = getSerieInformation($pdo);
$getLanguageInformation = getLanguageInformation($pdo);
$getStatusInformation = getStatusInformation($pdo);
$getDesignerInformation = getDesignerInformation($pdo);

if (isset($_POST['submitUpdate'])) {
    updateBook($pdo, $bookID);
    header("Location: home.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Book</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($currentBook['titel']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($currentBook['beskrivning']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="pages" class="form-label">Pages:</label>
            <input type="number" class="form-control" id="pages" name="pages" value="<?php echo htmlspecialchars($currentBook['sidor']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($currentBook['pris']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="age_recommendation" class="form-label">Age Recommendation:</label>
            <input type="text" class="form-control" id="age_recommendation" name="age_recommendation" value="<?php echo htmlspecialchars($currentBook['aldersrekommendation']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select class="form-select" id="category" name="category">
                <?php foreach ($getCategoryInformation as $category): ?>
                    <option value="<?php echo $category['id_kategori']; ?>" 
                        <?php echo isset($currentBook['id_kategori']) && $currentBook['id_kategori'] == $category['id_kategori'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['kategori_namn']); ?>
                    </option>

                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="author" class="form-label">Author:</label>
            <select class="form-select" id="author" name="author">
                <?php foreach ($getAuthorInformation as $author): ?>
                    <option value="<?php echo $author['id_forfattare']; ?>" 
                        <?php echo isset($currentBook['id_forfattare']) && $currentBook['id_forfattare'] == $author['id_forfattare'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($author['forfattare_namn']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        

        <div class="mb-3">
            <label for="genre" class="form-label">Genre:</label>
            <select class="form-select" id="genre" name="genre">
                <?php foreach ($getGenreInformation as $genre): ?>
                    <option value="<?php echo $genre['id_genre']; ?>" 
                        <?php echo isset($currentBook['id_genre']) && $currentBook['id_genre'] == $genre['id_genre'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($genre['genre_namn']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
    <label for="serie" class="form-label">Series:</label>
    <select class="form-select" id="serie" name="id_serie"> 
        <?php foreach ($getSerieInformation as $serie): ?>
            <option value="<?php echo $serie['id_serie']; ?>" 
                <?php echo isset($currentBook['id_serie']) && $currentBook['id_serie'] == $serie['id_serie'] ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($serie['serie_namn']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


        <div class="mb-3">
            <label for="language" class="form-label">Language:</label>
            <select class="form-select" id="language" name="language">
                <?php foreach ($getLanguageInformation as $language): ?>
                        <option value="<?php echo $language['id_sprak']; ?>" 
                            <?php echo isset($currentBook['id_sprak']) && $currentBook['id_sprak'] == $language['id_sprak'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($language['sprak_namn']); ?>
                        </option>

                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="designer" class="form-label">Designer:</label>
            <select class="form-select" id="designer" name="designer">
                <?php foreach ($getDesignerInformation as $designer): ?>
                    <option value="<?php echo $designer['id_form_eller_illu']; ?>" 
                        <?php echo isset($currentBook['id_form_eller_illu']) && $currentBook['id_form_eller_illu'] == $designer['id_form_eller_illu'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($designer['form_eller_illu_namn']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" id="status" name="status">
                <?php foreach ($getStatusInformation as $status): ?>
                    <option value="<?php echo $status['id_status']; ?>" 
                        <?php echo isset($currentBook['id_status']) && $currentBook['id_status'] == $status['id_status'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($status['status_namn']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

                <div class="form-group">
                    <label for="img">edit image</label>
                    <input type="file" class="form-control" id="book_img" name="book_img" placeholder="Upload Image"></input>
                </div>

      

        <button type="submit" name="submitUpdate" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
