<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();





$bookId = isset($_GET['BookID']) ? $_GET['BookID'] : 0;

$bookData = getSingleBook($pdo, $bookId);
$getAuthorInformation = getAuthorInformation($pdo);
$getGenreInformation =  getGenreInformation($pdo);
$getDesignerInformation = getDesignerInformation($pdo);
$getCategoryInformation = getCategoryInformation($pdo);
$getGenreInformation = getGenreInformation($pdo);
$getSerieInformation = getSerieInformation($pdo);
$getLanguageInformation = getLanguageInformation($pdo);
$getStatusInformation = getStatusInformation($pdo);
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
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" 
                   value="<?php echo htmlspecialchars($bookData['title'] ?? ''); ?>" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="description" name="description" 
                   value="<?php echo htmlspecialchars($bookData['desc'] ?? ''); ?>" required>
        </div>

        <!-- Pages -->
        <div class="mb-3">
            <label for="Pages" class="form-label">Pages:</label>
            <input type="number" class="form-control" id="Pages" name="Pages" 
                   value="<?php echo htmlspecialchars($bookData['pages'] ?? ''); ?>" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="Price" class="form-label">Price:</label>
            <input type="number" class="form-control" id="Price" name="Price" 
                   value="<?php echo htmlspecialchars($bookData['price'] ?? ''); ?>" required>
        </div>

        <!-- Date -->
        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date" 
                   value="<?php echo htmlspecialchars($bookData['date'] ?? ''); ?>" required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="StatusSelect" class="form-label">Select Status:</label>
            <select id="StatusSelect" name="id_status" class="form-select w-100" required>
                <option value="">Select status</option>
                <?php foreach ($getStatusInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_status']); ?>" 
                            <?php echo ($row['id_status'] == $bookData['status_fk']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['status_namn']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Age Group -->
        <div class="mb-3">
            <label for="ageSelect" class="form-label">Select Age Group:</label>
            <select id="ageSelect" name="id_age" class="form-select w-100" required>
                <option value="">Select Age Group</option>
                <?php foreach ($getAgeInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_age']); ?>" 
                        <?php echo ($row['id_age'] == $bookData['id_age']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['age_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Category -->
        <div class="mb-3">
            <label for="categorySelect" class="form-label">Select Category:</label>
            <select id="categorySelect" name="id_category" class="form-select w-100" required>
                <option value="">Select category</option>
                <?php foreach ($getCategoryInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_category']); ?>" 
                        <?php echo ($row['id_category'] == $bookData['id_category']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Author(s) -->
        <div class="mb-3">
            <label for="authorSelect" class="form-label">Select Author(s):</label>
            <select id="authorSelect" name="id_author[]" class="form-select w-100" multiple required>
                <?php foreach ($getAuthorInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_author']); ?>" 
                        <?php echo in_array($row['id_author'], $bookData['authors']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['author_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Genre(s) -->
        <div class="mb-3">
            <label for="GenreSelect" class="form-label">Select Genre(s):</label>
            <select id="GenreSelect" name="id_genre[]" class="form-select w-100" multiple required>
                <?php foreach ($getGenreInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_genre']); ?>" 
                        <?php echo in_array($row['id_genre'], $bookData['genres']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['genre_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Publisher -->
        <div class="mb-3">
            <label for="publisherSelect" class="form-label">Select Publisher:</label>
            <select id="publisherSelect" name="id_publisher" class="form-select w-100" required>
                <option value="">Select Publisher</option>
                <?php foreach ($getPublisherInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_pub']); ?>" 
                        <?php echo ($row['id_pub'] == $bookData['publisher_fk']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['pub_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Serie -->
        <div class="mb-3">
            <label for="SerieSelect" class="form-label">Select Serie:</label>
            <select id="SerieSelect" name="id_serie" class="form-select w-100" required>
                <option value="">Select Serie</option>
                <?php foreach ($getSerieInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_serie']); ?>" 
                        <?php echo ($row['id_serie'] == $bookData['serie_fk']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['serie_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Language -->
        <div class="mb-3">
            <label for="LanguageSelect" class="form-label">Select Language:</label>
            <select id="LanguageSelect" name="id_language" class="form-select w-100" required>
                <option value="">Select language</option>
                <?php foreach ($getLanguageInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_lan']); ?>" 
                        <?php echo ($row['id_lan'] == $bookData['lan_fk']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['lan_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Designer(s) -->
        <div class="mb-3">
            <label for="designerSelect" class="form-label">Select Designer(s):</label>ä
            <select id="designerSelect" name="id_designer[]" class="form-select w-100" multiple required>
                <?php foreach ($getDesignerInformation as $row): ?>
                    <option value="<?php echo htmlspecialchars($row['id_designer']); ?>" 
                        <?php echo in_array($row['id_designer'], $bookData['designers']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['designer_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="mb-3">
    <label for="StockSelect" class="form-label">Select Stock:</label>
    <select id="StockSelect" name="id_stock" class="form-select w-100" required>
        <option value="">Select stock</option>
        <?php foreach ($getStockInformation as $row): ?>
            <option value="<?php echo htmlspecialchars($row['id_stock']); ?>" 
                <?php echo ($row['id_stock'] == $bookData['stock_fk']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($row['stock_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


        <!-- Image -->
        <div class="form-group">
            <label for="img">Add image</label>
            <input type="file" class="form-control" id="book_img" name="book_img" placeholder="Upload Image">
        </div>

        <button type="submit" name="submitEdit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#authorSelect, #GenreSelect, #designerSelect').select2({
            placeholder: "Select options",
            allowClear: true
        });
    });
</script>
</body>
</html>


