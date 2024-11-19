<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$user->checkLoginStatus();

$getBookInformation = getBook($pdo);




?>



<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h1>Single Book</h1>


<div class="container mt-5">

        
<img src="<?php foreach ($getBookInformation as $row) { echo 'img/' . htmlspecialchars($row['bok_img']);} ?>" class="card-img-top d-flex" alt="Book Image" style="width: 180px; height: 300px; object-fit: cover;">
        <ul class="nav nav-tabs" id="bookTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Book Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="product-info-tab" data-bs-toggle="tab" data-bs-target="#product-info" type="button" role="tab" aria-controls="product-info" aria-selected="false">Information</button>
            </li>
        </ul>
        <div class="tab-content mt-3" id="bookTabsContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <p><strong>Description</strong></p>
                <p>
                <?php foreach ($getBookInformation as $row) {echo htmlspecialchars($row['beskrivning']);} ?>
                </p>
            </div>
            <div class="tab-pane fade" id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                <ul>
                    <li><strong>Pages: <?php foreach ($getBookInformation as $row) {echo htmlspecialchars($row['sidor']);} ?></strong></li>
                    <li><strong>Release: <?php foreach ($getBookInformation as $row) {echo htmlspecialchars($row['utgiven']);} ?></strong> </li>
                    <li><strong>Langugage:</strong> <?php foreach ($getBookInformation as $row) {echo htmlspecialchars($row['sprak_namn']);} ?></li>
                    <li><strong>Price: <?php foreach ($getBookInformation as $row) {echo htmlspecialchars($row['pris']);} ?>€</strong></li>
                </ul>
            </div>
        </div>
    </div>




</body>
</html>