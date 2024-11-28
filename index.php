<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$getRareBooks = getRareBook($pdo); 
$getPopularBooks = getPopularBook($pdo); 
$getPopularRNBooks = getPopularRNBook($pdo); 
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
  
</head>
<body>

<div class="container mt-4">
    <div class="text-center">
        <h2>Rare and Valuable</h2>
    </div>
    <div class="book-list-container" id="bookCarousel">
        <?php foreach ($getRareBooks as $book): ?>
        <div class="book-card me-3">
            <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 100%; height: 300px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($book['titel']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($book['beskrivning']); ?></p>
                <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="btn custom-btn">View</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="all-books.php?statusid=<?php echo $book['status_fk']; ?>" class="btn RnV" id="">See more</a>
</div>

<div class="container mt-4">
    <div class="text-center">
        <h2>Popular</h2>
    </div>
    <div class="book-list-container">
        <?php foreach ($getPopularBooks as $book): ?>
        <div class="book-card me-3">
            <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 100%; height: 300px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($book['titel']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($book['beskrivning']); ?></p>
                <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="btn custom-btn">View</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="all-books.php?statusid=<?php echo $book['status_fk']; ?>" class="btn RnV" id="">See more</a>
</div>

<div class="container mt-4">
    <div class="text-center">
        <h2>Popular right now!</h2>
    </div>
    <div class="d-flex flex-row flex-nowrap overflow-auto">
        <?php foreach ($getPopularRNBooks as $book): ?>
        <div class="card me-3" style="width: 18rem;">
            <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 100%; height: 300px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($book['titel']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($book['beskrivning']); ?></p>
                <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="btn custom-btn">View</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <a href="all-books.php?statusid=<?php echo $book['status_fk']; ?>" class="btn RnV" id="">See more</a>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    var bookListContainers = $('.book-list-container');
    var cardWidth = $('.book-card').outerWidth(true);  
    var scrollInterval = 4000;

    function autoScroll(container) {
        var totalCards = container.find('.book-card').length;
        var maxVisible = 5; 
        var scrollPosition = container.scrollLeft();

        container.scrollLeft(scrollPosition + cardWidth);

        if (scrollPosition + container.innerWidth() >= container[0].scrollWidth) {
            container.scrollLeft(0);
        }
    }

    function autoScrollAllContainers() {
        bookListContainers.each(function() {
            var container = $(this);
            autoScroll(container);
        });
    }

    setInterval(autoScrollAllContainers, scrollInterval);


    bookListContainers.each(function() {
        var container = $(this);
        var visibleCards = container.find('.book-card').slice(0, 5);
        container.scrollLeft(0);  

        container.css('display', 'flex');
        container.css('overflow-x', 'hidden');
        container.css('white-space', 'nowrap');
        container.find('.book-card').css('flex', '0 0 auto'); 
    });
});
</script>

</body>
</html>
