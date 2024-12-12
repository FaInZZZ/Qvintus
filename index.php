<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

$getRareBooks = getRareBook($pdo); 
$getPopularBooks = getPopularBook($pdo); 
$getPopularGenres = getPopularGenres($pdo); 
$histories = getLatestHistories($pdo);
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

    <main>
    <div class="container mt-5">
            <div class="mb-3 d-flex align-items-center">
                <input type="text" id="search-box" class="form-control me-2" placeholder="Search for books, authors, genres, etc.">
                <button class="btn custom-btn" onclick="closesearch()">Close</button>
            </div>
            <div id="search-results" class="list-group"></div>
        </div>

        <div class="container mt-4 rarebooks">
            <div class="text-center">
                <h2>Rare and Valuable</h2>
            </div>
            <div class="book-list-container" id="rareBooksCarousel">
                <?php foreach ($getRareBooks as $book): ?>
                <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="book-card-link" style=" text-decoration: none; color: inherit;">
                    <div class="book-card me-3">
                        <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 100%; height: 300px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                            <h6 class="card-title"><?php echo htmlspecialchars($book['authors']); ?></h6>
                            <h7 class="card-title"><?php echo htmlspecialchars($book['category_name']); ?></h7>
                            <div class="text-end">
                                <p class="card-text"><?php echo htmlspecialchars($book['price']); ?>€</p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
<div class="see-more-container d-flex justify-content-end mt-5">
    <a href="all-books.php?statusid=<?php echo $book['status_fk']; ?>" class="btn RnV">See more</a>
</div>



<<div class="container mt-5 populargenres" style=" margin-bottom: 200px;">
    <div class="text-center">
        <h2>Popular Genres</h2>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach ($getPopularGenres as $genre): ?>
        <div class="col">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo htmlspecialchars($genre['genre_name']); ?></h5>
                    <a href="genre-books.php?genreID=<?php echo $genre['id_genre']; ?>" class="btn custom-btn btn-sm">Explore Genre</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container mt-5 popularbooks">
    <div class="text-center">
        <h2>Popular</h2>
    </div>
    <div class="book-list-container" id="popularBooksCarousel">
        <?php foreach ($getPopularBooks as $book): ?>
        <a href="single-book.php?BookID=<?php echo $book['id_bok']; ?>" class="book-card-link" style="text-decoration: none; color: inherit;">
            <div class="book-card me-3">
                <img src="<?php echo 'img/' . htmlspecialchars($book['bok_img']); ?>" class="card-img-top" alt="Book Image" style="width: 100%; height: 300px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($book['title']); ?></h5>
                    <h6 class="card-title"><?php echo htmlspecialchars($book['authors']); ?></h6>
                    <h7 class="card-title"><?php echo htmlspecialchars($book['category_name']); ?></h7>
                    <div class="text-end">
                        <p class="card-text"><?php echo htmlspecialchars($book['price']); ?>€</p>
                    </div>
                 
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <div class="see-more-container d-flex justify-content-end mt-5">
        <a href="all-books.php?statusid=<?php echo $book['status_fk']; ?>" class="btn RnV">See more</a>
    </div>
</div>




<section class="container py-5 text-center custom-section-height mb-5 mt-5">
    <div class="card p-5 border-0 rounded">
        <h2 class="h2 text-dark mb-3">Can't find what you are looking for?</h2>
        <p class="lead text-muted mb-4">No problem, we can handle most requests, big or small.</p>
        <div class="d-flex justify-content-center">
            <a href="contact.php" class="btn custom-btn btn-lg custom-btn-width">Make a request</a>
        </div>
    </div>
</section>

<section class="container py-5 mt-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2 class="h2 text-dark mb-3 text-center">Greetings from Qvintus</h2>
            <p class="lead text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin condimentum felis ut lacus imperdiet, ut mollis eros dapibus. Proin ex nisl, mollis volutpat pulvinar vestibulum, ultricies quis lacus. Phasellus ornare maximus odio at ornare. Nullam quis purus in mi cursus convallis. Nam mattis rhoncus est. In vel blandit justo. Morbi eget lobortis metus. Suspendisse eu laoreet magna.
In eget arcu viverra, ultrices felis vitae, tincidunt diam.  Cras dignissim diam eget nibh auctor cursus. Integer sit amet purus eget magna euismod iaculis. Maecenas nec tortor viverra, cursus leo sit amet, pharetra mauris. Proin sit amet nibh ut purus auctor pharetra ac vitae dolor. In justo mauris, accumsan nec sollicitudin nec, malesuada in felis. Donec nec ligula condimentum ex hendrerit venenatis id in risus. Phasellus cursus non risus in facilisis. Nam viverra ullamcorper elit sed gravida. Sed tempor dolor mi, a mattis ex sodales et. Donec suscipit tellus a leo convallis luctus.</p>
        </div>
        <div class="col-md-6">
            <img src="img/Gamla-Stans-Bokhandel-besok-scaled.jpg" class="img-fluid rounded" alt="Your Image">
        </div>
    </div>
</section>


<div class="container my-5">
        <h1 class="text-center mb-4">Latest Histories</h1>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php foreach ($histories as $history): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="img/<?= htmlspecialchars($history['history_img']) ?>" 
                             class="card-img-top" 
                             alt="History Image" 
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($history['history_title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($history['history_desc']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
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

document.getElementById('search-box').addEventListener('input', function () {
        const query = this.value;

        fetch(`includes/searchindex.php?search=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('search-results').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function closesearch() {
        window.location.reload();
    }
</script>


<?php include_once 'includes/footer.php'; ?>

</body>
</html>
