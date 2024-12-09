<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();





$bookId= isset($_GET['BookID']) ? $_GET['BookID'] : 0;

$bookData = getSingleBookInformation($pdo, $bookId);
$getCategoryInformation = getCategoryInformation($pdo);
$getAuthorInformation = getAuthorInformation($pdo);
$getGenreInformation = getGenreInformation($pdo);
$getSerieInformation = getSerieInformation($pdo);
$getLanguageInformation = getLanguageInformation($pdo);
$getStatusInformation = getStatusInformation($pdo);
$getDesignerInformation = getDesignerInformation($pdo); 
$getStockInformation = getStockInformation($pdo);
$getAgeInformation = getAgeInformation($pdo);
$getPublisherInformation = getPublisherInformation($pdo);

if (isset($_POST['submitEdit'])) {
    $updateBook = updateBook($pdo, $bookId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
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
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($bookData['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($bookData['description']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="pages" class="form-label">Pages:</label>
            <input type="number" class="form-control" id="pages" name="pages" value="<?php echo htmlspecialchars($bookData['pages']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($bookData['price']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="ageSelect" class="form-label">Select Age</label>
            <select id="ageSelect" name="id_age" class="form-select w-100">
                <option value="">Choose Age</option>
                <?php foreach ($getAgeInformation as $row): ?>
                    <option value="<?php echo $row['id_age']; ?>" <?php echo ($row['id_age'] == $bookData['id_age']) ? 'selected' : ''; ?>>
                        <?php echo $row['age_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="categorySelect" class="form-label">Select Category</label>
            <select id="categorySelect" name="id_kategori" class="form-select w-100">
                <option value="">Choose a Category</option>
                <?php foreach ($getCategoryInformation as $row): ?>
                    <option value="<?php echo $row['id_kategori']; ?>" <?php echo ($row['id_kategori'] == $bookData['id_kategori']) ? 'selected' : ''; ?>>
                        <?php echo $row['kategori_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="authorSelect" class="form-label">Select Author(s)</label>
            <select id="authorSelect" name="id_author[]" class="form-select w-100" multiple>
                <?php foreach ($getAuthorInformation as $row): ?>
                    <option value="<?php echo $row['id_forfattare']; ?>" <?php echo (in_array($row['id_forfattare'], $bookData['authors'])) ? 'selected' : ''; ?>>
                        <?php echo $row['forfattare_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="GenreSelect" class="form-label">Select Genre(s)</label>
            <select id="GenreSelect" name="id_genre[]" class="form-select w-100" multiple>
                <?php foreach ($getGenreInformation as $row): ?>
                    <option value="<?php echo $row['id_genre']; ?>" <?php echo (in_array($row['id_genre'], $bookData['genres'])) ? 'selected' : ''; ?>>
                        <?php echo $row['genre_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="publisherSelect" class="form-label">Select Publisher</label>
            <select id="publisherSelect" name="id_publisher" class="form-select w-100">
                <option value="">Choose Publisher</option>
                <?php foreach ($getPublisherInformation as $row): ?>
                    <option value="<?php echo $row['id_pub']; ?>" <?php echo ($row['id_pub'] == $bookData['id_publisher']) ? 'selected' : ''; ?>>
                        <?php echo $row['pub_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($bookData['date']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="StatusSelect" class="form-label">Select Status</label>
            <select id="StatusSelect" name="id_status" class="form-select w-100">
                <option value="">Choose a Status</option>
                <?php foreach ($getStatusInformation as $row): ?>
                    <option value="<?php echo $row['id_status']; ?>" <?php echo ($row['id_status'] == $bookData['id_status']) ? 'selected' : ''; ?>>
                        <?php echo $row['status_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="submitEdit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
</body>
</html>
