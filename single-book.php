<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$bookid = isset($_GET['BookID']) ? (int)$_GET['BookID'] : 0;

if (empty($bookid)) {
    echo "<p>Invalid Book ID.</p>";
    exit;
}

$getSingleBookInformation = getSingleBookInformation($pdo, $bookid);

if (!$getSingleBookInformation) {
    echo "<p>Book not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Book</title>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo 'img/' . htmlspecialchars($getSingleBookInformation['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 300px; height: 400px; object-fit: cover;">
        </div>
        <div class="col-md-8">
            <h1><?php echo htmlspecialchars($getSingleBookInformation['title']); ?></h1>
            <h4>Authors: 
                <?php if (!empty($getSingleBookInformation['authors'])): ?>
                    <?php echo htmlspecialchars(implode(', ', $getSingleBookInformation['authors'])); ?>
                <?php else: ?>
                    No authors available
                <?php endif; ?>
            </h4>
            <h3><?php echo htmlspecialchars($getSingleBookInformation['price']); ?>€</h3>
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
                    <p><?php echo htmlspecialchars($getSingleBookInformation['desc']); ?></p>
                </div>
                <div class="tab-pane fade" id="product-info" role="tabpanel" aria-labelledby="product-info-tab">
                    <ul>
                        <li><strong>Pages:</strong> <?php echo htmlspecialchars($getSingleBookInformation['pages']); ?></li>
                        <li><strong>Release:</strong> <?php echo htmlspecialchars($getSingleBookInformation['date']); ?></li>
                        <li><strong>Language:</strong> <?php echo htmlspecialchars($getSingleBookInformation['lan_name']); ?></li>
                        <li><strong>Price:</strong> <?php echo htmlspecialchars($getSingleBookInformation['price']); ?>€</li>
                        <li><strong>Genre:</strong> 
                            <?php if (!empty($getSingleBookInformation['genres'])): ?>
                                <?php echo htmlspecialchars(implode(', ', $getSingleBookInformation['genres'])); ?>
                            <?php else: ?>
                                No genres available
                            <?php endif; ?>
                        </li>
                        <li><strong>Designer:</strong> 
                            <?php if (!empty($getSingleBookInformation['designers'])): ?>
                                <?php echo htmlspecialchars(implode(', ', $getSingleBookInformation['designers'])); ?>
                            <?php else: ?>
                                No designers available
                            <?php endif; ?>
                        </li>
                        <li><strong>Status:</strong> <?php echo htmlspecialchars($getSingleBookInformation['status_namn']); ?></li>
                        <li><strong>Age recommendation:</strong> <?php echo htmlspecialchars($getSingleBookInformation['age_name']); ?></li>
                        <li><strong>Serie:</strong> <?php echo htmlspecialchars($getSingleBookInformation['serie_name']); ?></li>
                        <li><strong>Publisher:</strong> <?php echo htmlspecialchars($getSingleBookInformation['pub_name']); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
