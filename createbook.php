<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$user->checkLoginStatus();

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

if (isset($_POST['submitnb'])) {
    $submitNewBook = insertNewBook($pdo);
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
    <title>Document</title>
</head>
<body>

<div class="container mt-5">
    <h2>Skapa ny bok</h2>
    
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">description:</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>

        <div class="mb-3">
            <label for="pages" class="form-label">pages:</label>
            <input type="number" class="form-control" id="pages" name="pages" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">price:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="mb-3">
            <label for="ageSelect" class="form-label">Select Age</label>
            <select id="ageSelect" name="id_age" class="form-select w-100">
                <option value="">Choose Age</option>
                <?php foreach ($getAgeInformation as $row): ?>
                    <option value="<?php echo $row['id_age']; ?>">
                        <?php echo $row['age_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="categorySelect" class="form-label">Select Category</label>
            <select id="categorySelect" name="id_category" class="form-select w-100">
                <option value="">Choose a Category</option>
                <?php foreach ($getCategoryInformation as $row): ?>
                    <option value="<?php echo $row['id_category']; ?>">
                        <?php echo $row['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

 

        <div class="mb-3">
    <label for="authorSelect" class="form-label">Select Author(s)</label>
    <select id="authorSelect" name="id_author[]" class="form-select w-100" multiple>
        <?php foreach ($getAuthorInformation as $row): ?>
            <option value="<?php echo $row['id_author']; ?>">
                <?php echo $row['author_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

        <div class="mb-3">
    <label for="GenreSelect" class="form-label">Select Genre(s)</label>
    <select id="GenreSelect" name="id_genre[]" class="form-select w-100" multiple>
        <?php foreach ($getGenreInformation as $row): ?>
            <option value="<?php echo $row['id_genre']; ?>">
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
            <option value="<?php echo $row['id_pub']; ?>">
                <?php echo $row['pub_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


        <div class="mb-3">
            <label for="SerieSelect" class="form-label">Select Serie</label>
            <select id="SerieSelect" name="id_Serie" class="form-select w-100">
                <option value="">Choose a Serie</option>
                <?php foreach ($getSerieInformation as $row): ?>
                    <option value="<?php echo $row['id_serie']; ?>">
                        <?php echo $row['serie_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="LanguageSelect" class="form-label">Select Language</label>
            <select id="LanguageSelect" name="id_Language" class="form-select w-100">
                <option value="">Choose a Language</option>
                <?php foreach ($getLanguageInformation as $row): ?>
                    <option value="<?php echo $row['id_lan']; ?>">
                        <?php echo $row['lan_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="mb-3">
    <label for="DesignerSelect" class="form-label">Select Designer(s)</label>
    <select id="DesignerSelect" name="id_designer[]" class="form-select w-100" multiple>
        <?php foreach ($getDesignerInformation as $row): ?>
            <option value="<?php echo $row['id_designer']; ?>">
                <?php echo $row['designer_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
            <label for="StatusSelect" class="form-label">Select Status</label>
            <select id="StatusSelect" name="id_status" class="form-select w-100">
                <option value="">Choose a Status</option>
                <?php foreach ($getStatusInformation as $row): ?>
                    <option value="<?php echo $row['id_status']; ?>">
                        <?php echo $row['status_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="StockSelect" class="form-label">Select Stock</label>
            <select id="StockSelect" name="id_stock" class="form-select w-100">
                <option value="">Choose stock</option>
                <?php foreach ($getStockInformation as $row): ?>
                    <option value="<?php echo $row['id_stock']; ?>">
                        <?php echo $row['stock_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

            <div class="form-group">
                    <label for="img">Add image</label>
                    <input type="file" class="form-control" id="book_img" name="book_img" placeholder="Upload Image"></input>
                </div>

        <button type="submit" name="submitnb" class="btn btn-primary">Skicka</button>
    </form>
</div>


  <script>
  $(document).ready(function() {
    $('#categorySelect').select2();  
  });
  $(document).ready(function() {
    $('#AuthorSelect').select2();  
  });
  $(document).ready(function() {
    $('#GenreSelect').select2();  
  });
  $(document).ready(function() {
    $('#SerieSelect').select2();  
  });
  $(document).ready(function() {
    $('#LanguageSelect').select2();  
  });
  $(document).ready(function() {
    $('#StatusSelect').select2();  
  });
  $(document).ready(function() {
    $('#DesignerSelect').select2();  
  });

  $(document).ready(function() {
        $('#GenreSelect').select2({
            placeholder: "Choose Genres",
            allowClear: true
        });
    });

    $(document).ready(function() {
        $('#authorSelect').select2({
            placeholder: "Choose Genres",
            allowClear: true
        });
    });

    $(document).ready(function() {
    $('#DesignerSelect').select2({
        placeholder: "Choose Designers",
        allowClear: true
    });
});

  
</script>

    
</body>
</html>