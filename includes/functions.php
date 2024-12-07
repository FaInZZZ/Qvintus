<?php
include_once 'includes/header.php';
include_once 'class.user.php';
$user = new User($pdo);


function getSingleBookInformation($pdo, $bookid) {
    // Fetch main book data
    $stmt_getBookdata = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            table_users.u_name,
            table_spark.sprak_namn,
            table_status.status_namn,
            table_serie.serie_namn,
            table_age.age_name
        FROM 
            table_bocker
        INNER JOIN 
            table_users 
        ON 
            table_bocker.skapad_av_fk = table_users.u_id
        INNER JOIN 
            table_spark
        ON
            table_bocker.sprak_fk = table_spark.id_sprak
        INNER JOIN 
            table_age
        ON
            table_bocker.age_fk = table_age.id_age
        INNER JOIN 
            table_status
        ON
            table_bocker.status_fk = table_status.id_status
        INNER JOIN 
            table_serie
        ON
            table_bocker.serie_fk = table_serie.id_serie
        WHERE 
            table_bocker.id_bok = :bookid
    ');

    $stmt_getBookdata->bindParam(':bookid', $bookid, PDO::PARAM_INT);
    $stmt_getBookdata->execute();
    $bookData = $stmt_getBookdata->fetch(PDO::FETCH_ASSOC);

    if (!$bookData) {
        return null;
    }


    $stmt_getGenres = $pdo->prepare('
        SELECT 
            table_genre.genre_name
        FROM 
            book_genre
        INNER JOIN 
            table_genre
        ON 
            book_genre.genre_id = table_genre.id_genre
        WHERE 
            book_genre.book_id = :bookid
    ');

    $stmt_getGenres->bindParam(':bookid', $bookid, PDO::PARAM_INT);
    $stmt_getGenres->execute();
    $genres = $stmt_getGenres->fetchAll(PDO::FETCH_COLUMN);
    $bookData['genres'] = $genres;

    $stmt_getAuthors = $pdo->prepare('
        SELECT 
            table_forfattare.forfattare_namn
        FROM 
            book_author
        INNER JOIN 
            table_forfattare
        ON 
            book_author.id_author = table_forfattare.id_forfattare
        WHERE 
            book_author.id_book = :bookid
    ');

    $stmt_getAuthors->bindParam(':bookid', $bookid, PDO::PARAM_INT);
    $stmt_getAuthors->execute();
    $authors = $stmt_getAuthors->fetchAll(PDO::FETCH_COLUMN);
    $bookData['authors'] = $authors;

    $stmt_getGenres->bindParam(':bookid', $bookid, PDO::PARAM_INT);
    $stmt_getGenres->execute();
    $genres = $stmt_getGenres->fetchAll(PDO::FETCH_COLUMN);
    $bookData['genres'] = $genres;

    $stmt_getDesigners = $pdo->prepare('
    SELECT 
        table_designer.designer_name
    FROM 
        book_designer
    INNER JOIN 
        table_designer
    ON 
        book_designer.id_designer = table_designer.id_designer
    WHERE 
        book_designer.id_book = :bookid
');

$stmt_getDesigners->bindParam(':bookid', $bookid, PDO::PARAM_INT);
$stmt_getDesigners->execute();
$designers = $stmt_getDesigners->fetchAll(PDO::FETCH_COLUMN);
$bookData['designers'] = $designers;


    return $bookData;
}




function getSingleBook($pdo, $bookID) {
    $stmt = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            table_users.u_name AS created_by_user, 
            table_category.id_kategori, 
            table_category.kategori_namn, 
            table_forfattare.id_forfattare, 
            table_forfattare.forfattare_namn, 
            table_genre.id_genre, 
            table_genre.genre_namn, 
            table_serie.id_serie, 
            table_serie.serie_namn, 
            table_spark.id_sprak, 
            table_spark.sprak_namn, 
            table_status.id_status, 
            table_status.status_namn, 
            table_form.id_form_eller_illu, 
            table_form.form_eller_illu_namn
        FROM 
            table_bocker
        INNER JOIN 
            table_users 
        ON 
            table_bocker.skapad_av_fk = table_users.u_id
        INNER JOIN 
            table_category 
        ON 
            table_bocker.kategori_fk = table_category.id_kategori
        INNER JOIN 
            table_forfattare 
        ON 
            table_bocker.forfattare_fk = table_forfattare.id_forfattare
        INNER JOIN 
            table_genre 
        ON 
            table_bocker.genre_fk = table_genre.id_genre
        INNER JOIN 
            table_serie 
        ON 
            table_bocker.serie_fk = table_serie.id_serie
        INNER JOIN 
            table_spark 
        ON 
            table_bocker.sprak_fk = table_spark.id_sprak
        INNER JOIN 
            table_status 
        ON 
            table_bocker.status_fk = table_status.id_status
        INNER JOIN 
            table_form 
        ON 
            table_bocker.form_eller_illu_fk = table_form.id_form_eller_illu
        WHERE 
            table_bocker.id_bok = :id
    ');

    $stmt->bindParam(':id', $bookID, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}



function updateBook($pdo, $bookId) {
    $user = new User($pdo);

    $user->checkLoginStatus();

    $bookimg = basename($_FILES['book_img']['name']);
    $stmt_getBookOwner = $pdo->prepare('SELECT skapad_av_fk FROM table_bocker WHERE id_bok = :id_bok');
    $stmt_getBookOwner->bindParam(':id_bok', $bookId, PDO::PARAM_INT);
    $stmt_getBookOwner->execute();
    $book = $stmt_getBookOwner->fetch(PDO::FETCH_ASSOC);

    if ($book['skapad_av_fk'] != $_SESSION['user_id']) {
        if (!$user->checkUserRole(300)) {
            header("Location: admin.php");
            exit();
        }
    }

    $stmt_updateBook = $pdo->prepare('
        UPDATE table_bocker 
        SET 
            titel = :titel,
            beskrivning = :beskrivning,
            aldersrekommendation = :aldersrekommendation,
            utgiven = :utgiven,
            sidor = :sidor,
            pris = :pris,
            serie_fk = :serie_fk,
            forfattare_fk = :forfattare_fk,
            form_eller_illu_fk = :form_eller_illu_fk,
            kategori_fk = :kategori_fk,
            genre_fk = :genre_fk,
            sprak_fk = :sprak_fk,
            status_fk = :status_fk,
            bok_img = :bok_img,
            skapad_av_fk = :skapad_av_fk
        WHERE 
            id_bok = :id_bok
    ');

    $stmt_updateBook->bindParam(":titel", $_POST['title'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":beskrivning", $_POST['description'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":aldersrekommendation", $_POST['age_recommendation'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":utgiven", $_POST['date'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":sidor", $_POST['pages'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":pris", $_POST['price'], PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":serie_fk", $_POST['id_serie'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":forfattare_fk", $_POST['author'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":form_eller_illu_fk", $_POST['designer'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":kategori_fk", $_POST['category'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":genre_fk", $_POST['genre'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":sprak_fk", $_POST['language'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":status_fk", $_POST['status'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":skapad_av_fk", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_updateBook->bindParam(":bok_img", $bookimg, PDO::PARAM_STR);
    $stmt_updateBook->bindParam(":id_bok", $bookId, PDO::PARAM_INT);

    $stmt_updateBook->execute();
}


function getCategoryInformation($pdo) {
    $stmt_getCategorydata = $pdo->prepare('
        SELECT * 
        FROM table_category');
    $stmt_getCategorydata->execute();
    

    return $stmt_getCategorydata->fetchAll(PDO::FETCH_ASSOC);
}

function getStockInformation($pdo) {
    $stmt_getStockdata = $pdo->prepare('
        SELECT * 
        FROM table_stock');
    $stmt_getStockdata->execute();
    

    return $stmt_getStockdata->fetchAll(PDO::FETCH_ASSOC);
}

function getAuthorInformation($pdo) {
    $stmt_getAuthordata = $pdo->prepare('SELECT id_forfattare, forfattare_namn FROM table_forfattare');
    
    $stmt_getAuthordata->execute();
    $Authors = $stmt_getAuthordata->fetchAll(PDO::FETCH_ASSOC);
    return $Authors;
}

function getAgeInformation($pdo) {
    $stmt_getAgedata = $pdo->prepare('
        SELECT * 
        FROM table_age');
    $stmt_getAgedata->execute();
    

    return $stmt_getAgedata->fetchAll(PDO::FETCH_ASSOC);
}



function getGenreInformation($pdo) {
    $stmt_getGenredata = $pdo->prepare('SELECT id_genre, genre_name FROM table_genre');
    
    $stmt_getGenredata->execute();
    $genres = $stmt_getGenredata->fetchAll(PDO::FETCH_ASSOC);
    return $genres;
}




function createGenre($pdo, $genreName, $isPopular) {
    $status = $isPopular ? 3 : 4;

    $stmt = $pdo->prepare('INSERT INTO table_genre (genre_name, p_status_fk) VALUES (:genre_name, :p_status_fk)');
    $stmt->bindParam(':genre_name', $genreName, PDO::PARAM_STR);
    $stmt->bindParam(':p_status_fk', $status, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Genre successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create genre.</div>';
    }
}



function updateGenre($pdo, $genreId, $updatedName, $isPopular) {

    $status = $isPopular ? 3 : 4;

    $stmt = $pdo->prepare("UPDATE table_genre SET genre_name = :updatedName, p_status_fk = :status WHERE id_genre = :genreId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Genre successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update genre.</div>';
    }
}


function deleteGenre($pdo, $genreId) {
    $stmt = $pdo->prepare("DELETE FROM table_genre WHERE id_genre = :genreId");
    $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Genre successfully Deleted</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete genre.</div>';
    }
}





function createCategory($pdo) {
    $stmt = $pdo->prepare('INSERT INTO table_category (kategori_namn) VALUES (:category_name)');
    $stmt->bindParam(':category_name', $_POST['CategoryName'], PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Category.</div>';
    }
}

function updateCategory($pdo, $CategoryId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_category SET kategori_namn = :updatedName WHERE id_kategori = :CategoryId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':CategoryId', $CategoryId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Category.</div>';
    }
}

function deleteCategory($pdo, $CategoryId) {
    $stmt = $pdo->prepare("DELETE FROM table_category WHERE id_kategori = :CategoryId");
    $stmt->bindParam(':CategoryId', $CategoryId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully Deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete category.</div>';
    }
}







function createserie($pdo) {
    $stmt = $pdo->prepare('INSERT INTO table_serie (serie_namn) VALUES (:serie_name)');
    $stmt->bindParam(':serie_name', $_POST['serieName'], PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create serie.</div>';
    }
}

function updateserie($pdo, $serieId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_serie SET serie_namn = :updatedName WHERE id_serie = :serieId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':serieId', $serieId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create serie.</div>';
    }
}

function deleteserie($pdo, $serieId) {
    $stmt = $pdo->prepare("DELETE FROM table_serie WHERE id_serie = :serieId");
    $stmt->bindParam(':serieId', $serieId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete serie.</div>';
    }
}







function createAge($pdo, $AgeName) {
    $stmt = $pdo->prepare('INSERT INTO table_age (age_name) VALUES (:age_name)');
    $stmt->bindParam(':age_name', $_POST['AgeName'], PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Age successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create age.</div>';
    }
}

function updateAge($pdo, $AgeId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_age SET Age_name = :updatedName WHERE id_age = :AgeId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':AgeId', $AgeId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Age successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Age.</div>';
    }
}

function deleteAge($pdo, $AgeId) {
    $stmt = $pdo->prepare("DELETE FROM table_age WHERE id_age = :AgeId");
    $stmt->bindParam(':AgeId', $AgeId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Age successfully Deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete Age.</div>';
    }
}










function createAuthor($pdo, $authorName) {
    $stmt = $pdo->prepare('INSERT INTO table_forfattare (forfattare_namn) VALUES (:author_name)');
    $stmt->bindParam(':author_name', $authorName, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Author successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create author.</div>';
    }
}


function updateAuthor($pdo, $authorId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_forfattare SET forfattare_namn = :updatedName WHERE id_forfattare = :authorId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">author successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update author.</div>';
    }
}

function deleteAuthor($pdo, $authorId) {
    $stmt = $pdo->prepare("DELETE FROM table_forfattare WHERE id_forfattare = :authorId");
    $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Author successfully Deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete Author.</div>';
    }
}





function createDesigner($pdo, $DesignerName) {
    $stmt = $pdo->prepare('INSERT INTO table_designer (designer_name) VALUES (:Designer_name)');
    $stmt->bindParam(':Designer_name', $DesignerName, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Designer successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Designer.</div>';
    }
}


function updateDesigner($pdo, $designerId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_designer SET designer_name = :updatedName WHERE id_designer = :DesignerId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':DesignerId', $designerId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Designer successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Designer.</div>';
    }
}

function deleteDesigner($pdo, $designerId) {
    $stmt = $pdo->prepare("DELETE FROM table_designer WHERE id_designer = :DesignerId");
    $stmt->bindParam(':DesignerId', $designerId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Designer successfully deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete designer.</div>';
    }
}



function createlan($pdo, $lanName) {
    $stmt = $pdo->prepare('INSERT INTO table_spark (sprak_namn) VALUES (:lan_name)');
    $stmt->bindParam(':lan_name', $lanName, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Languague successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Language.</div>';
    }
}


function updatelan($pdo, $lanId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_spark SET sprak_namn = :updatedName WHERE id_sprak= :lanId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':lanId', $lanId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Language successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update language.</div>';
    }
}

function deletelan($pdo, $lanId) {
    $stmt = $pdo->prepare("DELETE FROM table_spark WHERE id_sprak= :lanId");
    $stmt->bindParam(':lanId', $lanId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">language successfully deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete language.</div>';
    }
}

function getPopularGenres($pdo) {
    $stmt = $pdo->prepare("
        SELECT genre_name, id_genre
        FROM table_genre
        WHERE p_status_fk = 3
        LIMIT 6
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}




function getSerieInformation($pdo) {
    $stmt_getSeriedata = $pdo->prepare('
        SELECT * 
        FROM table_serie');
    $stmt_getSeriedata->execute();
    

    return $stmt_getSeriedata->fetchAll(PDO::FETCH_ASSOC);
}

function getLanguageInformation($pdo) {
    $stmt_getLandata = $pdo->prepare('
        SELECT * 
        FROM table_spark');
    $stmt_getLandata->execute();
    

    return $stmt_getLandata->fetchAll(PDO::FETCH_ASSOC);
}

function getStatusInformation($pdo) {
    $stmt_getStatusdata = $pdo->prepare('
        SELECT * 
        FROM table_status');
    $stmt_getStatusdata->execute();
    

    return $stmt_getStatusdata->fetchAll(PDO::FETCH_ASSOC);
}

function getDesignerInformation($pdo) {
 
        $stmt_getdesignersdata = $pdo->prepare('SELECT id_designer, designer_name FROM table_designer');
        
        $stmt_getdesignersdata->execute();
        $designers = $stmt_getdesignersdata->fetchAll(PDO::FETCH_ASSOC);
        return $designers;
}


function insertNewBook($pdo) {
    $bookimg = basename($_FILES['book_img']['name']);

    // Insert the book details into table_bocker
    $stmt_insertNewBook = $pdo->prepare('
        INSERT INTO table_bocker (titel, beskrivning, age_fk, utgiven, sidor, pris, serie_fk, kategori_fk, sprak_fk, status_fk, skapad_av_fk, bok_img, stock_fk) 
        VALUES (:titel, :beskrivning, :aldersrekommendation, :utgiven, :sidor, :pris, :serie_fk, :kategori_fk, :sprak_fk, :status_fk, :skapad_av_fk, :bok_img, :stock_fk)
    ');

    $stmt_insertNewBook->bindParam(":titel", $_POST['title'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":beskrivning", $_POST['description'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":aldersrekommendation", $_POST['id_age'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":utgiven", $_POST['date'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":sidor", $_POST['pages'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":pris", $_POST['price'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":serie_fk", $_POST['id_Serie'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":kategori_fk", $_POST['id_kategori'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":sprak_fk", $_POST['id_Language'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":status_fk", $_POST['id_status'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":stock_fk", $_POST['id_stock'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":skapad_av_fk", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":bok_img", $bookimg, PDO::PARAM_STR);

    $stmt_insertNewBook->execute();
    $book_id = $pdo->lastInsertId();

    // Insert authors into book_author many-to-many table
    if (isset($_POST['id_author']) && is_array($_POST['id_author'])) {
        $stmt_insertAuthor = $pdo->prepare('
            INSERT IGNORE INTO book_author (id_book, id_author)
            VALUES (:book_id, :author_id)
        ');

        foreach ($_POST['id_author'] as $author_id) {
            $stmt_insertAuthor->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            $stmt_insertAuthor->bindParam(':author_id', $author_id, PDO::PARAM_INT);
            $stmt_insertAuthor->execute();
        }
    }

    // Insert genres into book_genre many-to-many table
    if (isset($_POST['id_genre']) && is_array($_POST['id_genre'])) {
        $stmt_insertGenre = $pdo->prepare('
            INSERT IGNORE INTO book_genre (book_id, genre_id)
            VALUES (:book_id, :genre_id)
        ');

        foreach ($_POST['id_genre'] as $genre_id) {
            $stmt_insertGenre->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            $stmt_insertGenre->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            $stmt_insertGenre->execute();
        }
    }

    // Insert designers into book_designer many-to-many table
    if (isset($_POST['id_designer']) && is_array($_POST['id_designer'])) {
        $stmt_insertDesigner = $pdo->prepare('
            INSERT IGNORE INTO book_designer (id_book, id_designer)
            VALUES (:book_id, :designer_id)
        ');

        foreach ($_POST['id_designer'] as $designer_id) {
            $stmt_insertDesigner->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            $stmt_insertDesigner->bindParam(':designer_id', $designer_id, PDO::PARAM_INT);
            $stmt_insertDesigner->execute();
        }
    }

    return $book_id;
}




function getBook($pdo) {

    $stmt_getBookdata = $pdo->prepare('
    SELECT 
        table_bocker.*, 
        table_users.u_name AS created_by_user, 
        table_category.kategori_namn, 
        table_forfattare.forfattare_namn, 
        table_genre.genre_namn, 
        table_serie.serie_namn, 
        table_spark.sprak_namn, 
        table_status.status_namn, 
        table_form.form_eller_illu_namn
    FROM 
        table_bocker
    INNER JOIN 
        table_users 
    ON 
        table_bocker.skapad_av_fk = table_users.u_id
    INNER JOIN 
        table_category 
    ON 
        table_bocker.kategori_fk = table_category.id_kategori
    INNER JOIN 
        table_forfattare 
    ON 
        table_bocker.forfattare_fk = table_forfattare.id_forfattare
    INNER JOIN 
        table_genre 
    ON 
        table_bocker.genre_fk = table_genre.id_genre
    INNER JOIN 
        table_serie 
    ON 
        table_bocker.serie_fk = table_serie.id_serie
    INNER JOIN 
        table_spark 
    ON 
        table_bocker.sprak_fk = table_spark.id_sprak
    INNER JOIN 
        table_status 
    ON 
        table_bocker.status_fk = table_status.id_status
    INNER JOIN 
        table_form 
    ON 
        table_bocker.form_eller_illu_fk = table_form.id_form_eller_illu
');

$stmt_getBookdata->execute();

return $stmt_getBookdata->fetchAll(PDO::FETCH_ASSOC);


}



function getRareBook($pdo) {
    $query = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            GROUP_CONCAT(table_forfattare.forfattare_namn SEPARATOR ", ") AS authors
        FROM 
            table_bocker
        INNER JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        INNER JOIN 
            table_forfattare ON book_author.id_author = table_forfattare.id_forfattare
        WHERE 
            table_bocker.status_fk = 1
        GROUP BY 
            table_bocker.id_bok
    ');
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function getPopularBook($pdo) {
  
        $query = $pdo->prepare('
            SELECT 
                table_bocker.*, 
                GROUP_CONCAT(table_forfattare.forfattare_namn SEPARATOR ", ") AS authors
            FROM 
                table_bocker
            INNER JOIN 
                book_author ON table_bocker.id_bok = book_author.id_book
            INNER JOIN 
                table_forfattare ON book_author.id_author = table_forfattare.id_forfattare
            WHERE 
                table_bocker.status_fk = 3
            GROUP BY 
                table_bocker.id_bok
        ');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    




function insertNewHistory($pdo) {
    $bookimg = basename($_FILES['book_img']['name']);

    $stmt_insertNewHistory = $pdo->prepare('INSERT INTO table_history (history_title, history_desc, history_img) VALUES (:history_title, :history_desc, :history_img)');

    $stmt_insertNewHistory->bindParam(":history_title", $_POST['history_title'], PDO::PARAM_STR);
    $stmt_insertNewHistory->bindParam(":history_desc", $_POST['history_desc'], PDO::PARAM_STR);
    $stmt_insertNewHistory->bindParam(":history_img", $bookimg, PDO::PARAM_STR);
    
    $stmt_insertNewHistory->execute();

}



function getLatestHistories($pdo) {
   $stmt = $pdo->prepare("SELECT * FROM `table_history` ORDER BY `id_history` DESC LIMIT 3");
   $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>