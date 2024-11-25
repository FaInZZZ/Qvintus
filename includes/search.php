<?php
include_once 'config.php';

if (isset($_GET['search'])) {
    $search = "%" . $_GET['search'] . "%";  

    $stmt = $pdo->prepare("
        SELECT 
            table_bocker.id_bok,
            table_bocker.titel,
            table_bocker.bok_img,
            table_forfattare.forfattare_namn AS forfattare,
            table_category.kategori_namn AS kategori,
            table_genre.genre_namn AS genre,
            table_serie.serie_namn AS serie
        FROM 
            table_bocker
        INNER JOIN 
            table_forfattare ON table_bocker.forfattare_fk = table_forfattare.id_forfattare
        INNER JOIN 
            table_category ON table_bocker.kategori_fk = table_category.id_kategori
        INNER JOIN 
            table_genre ON table_bocker.genre_fk = table_genre.id_genre
        INNER JOIN 
            table_serie ON table_bocker.serie_fk = table_serie.id_serie
        WHERE 
            table_bocker.titel LIKE ? OR 
            table_forfattare.forfattare_namn LIKE ? OR 
            table_category.kategori_namn LIKE ? OR 
            table_genre.genre_namn LIKE ? OR 
            table_serie.serie_namn LIKE ?
    ");


    $stmt->execute([$search, $search, $search, $search, $search]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php if (isset($results) && $results): ?>
            <?php foreach ($results as $row): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo 'img/' . htmlspecialchars($row['bok_img']); ?>" class="card-img-top" alt="Book Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['titel']); ?></h5>
                            <p class="card-text"><strong>Författare:</strong> <?php echo htmlspecialchars($row['forfattare']); ?></p>
                            <p class="card-text"><strong>Kategori:</strong> <?php echo htmlspecialchars($row['kategori']); ?></p>
                            <p class="card-text"><strong>Genre:</strong> <?php echo htmlspecialchars($row['genre']); ?></p>
                            <p class="card-text"><strong>Serie:</strong> <?php echo htmlspecialchars($row['serie']); ?></p>
                            <?php echo "<a href='single-book.php?BookID=" . $row['id_bok'] . "' class='btn btn-primary'>View</a>"; ?>
                            <?php echo "<a href='editbook.php?BookID=" . $row['id_bok'] . "' class='btn btn-warning'>Edit</a>"; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No results found.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
