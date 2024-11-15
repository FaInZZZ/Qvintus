<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();

$getCategoryInformation = getCategoryInformation($pdo);
$getAuthorInformation = getAuthorInformation($pdo);
$getGenreInformation = getGenreInformation($pdo);
$getSerieInformation = getSerieInformation($pdo);
$getLanguageInformation = getLanguageInformation($pdo);


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
    <form action="/submit" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Titel:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="pages" class="form-label">Antal sidor:</label>
            <input type="number" class="form-control" id="pages" name="pages" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Pris:</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <div class="mb-3">
            <label for="age_recommendation" class="form-label">Åldersrekommendation:</label>
            <input type="text" class="form-control" id="age_recommendation" name="age_recommendation" required>
        </div>

        <div class="mb-3">
            <label for="categorySelect" class="form-label">Select Category</label>
            <select id="categorySelect" name="id_kategori" class="form-select w-100">
                <option value="">Choose a Category</option>
                <?php foreach ($getCategoryInformation as $row): ?>
                    <option value="<?php echo $row['id_kategori']; ?>">
                        <?php echo $row['kategori_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="AuthorSelect" class="form-label">Select Author</label>
            <select id="AuthorSelect" name="id_author" class="form-select w-100">
                <option value="">Choose a Author</option>
                <?php foreach ($getAuthorInformation as $row): ?>
                    <option value="<?php echo $row['id_forfattare']; ?>">
                        <?php echo $row['forfattare_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="GenreSelect" class="form-label">Select Genre</label>
            <select id="GenreSelect" name="id_genre" class="form-select w-100">
                <option value="">Choose a Genre</option>
                <?php foreach ($getGenreInformation as $row): ?>
                    <option value="<?php echo $row['id_genre']; ?>">
                        <?php echo $row['genre_namn']; ?>
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
                        <?php echo $row['serie_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="LanguageSelect" class="form-label">Select Language</label>
            <select id="LanguageSelect" name="id_Language" class="form-select w-100">
                <option value="">Choose a Language</option>
                <?php foreach ($getLanguageInformation as $row): ?>
                    <option value="<?php echo $row['id_sprak']; ?>">
                        <?php echo $row['sprak_namn']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Skicka</button>
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
</script>

    
</body>
</html>