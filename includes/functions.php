<?php
include_once 'includes/header.php';
include_once 'class.user.php';
$user = new User($pdo);


function getSingleBookInformation($pdo, $bookid) {
    $stmt_getBookdata = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            table_users.u_name,
            table_spark.sprak_namn,
            table_forfattare.forfattare_namn,
            table_genre.genre_namn,
            table_form.form_eller_illu_namn,
            table_status.status_namn,
            table_serie.serie_namn
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
            table_forfattare
        ON
            table_bocker.forfattare_fk = table_forfattare.id_forfattare
        INNER JOIN 
            table_genre
        ON
            table_bocker.genre_fk = table_genre.id_genre
        INNER JOIN 
            table_form
        ON
            table_bocker.form_eller_illu_fk = table_form.id_form_eller_illu
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

    return $stmt_getBookdata->fetch(PDO::FETCH_ASSOC); 
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

function getAuthorInformation($pdo) {
    $stmt_getAuthordata = $pdo->prepare('
        SELECT * 
        FROM table_forfattare');
    $stmt_getAuthordata->execute();
    

    return $stmt_getAuthordata->fetchAll(PDO::FETCH_ASSOC);
}


function getGenreInformation($pdo) {
    $stmt_getGenredata = $pdo->prepare('
        SELECT * 
        FROM table_genre');
    $stmt_getGenredata->execute();
    

    return $stmt_getGenredata->fetchAll(PDO::FETCH_ASSOC);
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
    $stmt_getFormdata = $pdo->prepare('
        SELECT * 
        FROM table_form');
    $stmt_getFormdata->execute();
    

    return $stmt_getFormdata->fetchAll(PDO::FETCH_ASSOC);
}


function insertNewBook($pdo) {
    $bookimg = basename($_FILES['book_img']['name']);

    $stmt_insertNewBook = $pdo->prepare('INSERT INTO table_bocker (titel, beskrivning, aldersrekommendation, utgiven, sidor, pris, serie_fk, forfattare_fk, form_eller_illu_fk, kategori_fk, genre_fk, sprak_fk, status_fk, skapad_av_fk, bok_img) VALUES (:titel, :beskrivning, :aldersrekommendation, :utgiven, :sidor, :pris, :serie_fk, :forfattare_fk, :form_eller_illu_fk, :kategori_fk, :genre_fk, :sprak_fk, :status_fk, :skapad_av_fk, :bok_img)');

    $stmt_insertNewBook->bindParam(":titel", $_POST['title'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":beskrivning", $_POST['description'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":aldersrekommendation", $_POST['age_recommendation'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":utgiven", $_POST['date'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":sidor", $_POST['pages'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":pris", $_POST['price'], PDO::PARAM_STR);
    $stmt_insertNewBook->bindParam(":serie_fk", $_POST['id_Serie'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":forfattare_fk", $_POST['id_author'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":form_eller_illu_fk", $_POST['id_Designer'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":kategori_fk", $_POST['id_kategori'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":genre_fk", $_POST['id_genre'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":sprak_fk", $_POST['id_Language'], PDO::PARAM_INT); 
    $stmt_insertNewBook->bindParam(":status_fk", $_POST['id_status'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":skapad_av_fk", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt_insertNewBook->bindParam(":bok_img", $bookimg, PDO::PARAM_INT);
    
    $stmt_insertNewBook->execute();

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
    $stmt_getbookdata = $pdo->prepare('
        SELECT * 
        FROM table_bocker
        WHERE status_fk = 1');
    $stmt_getbookdata->execute();
    

    return $stmt_getbookdata->fetchall(PDO::FETCH_ASSOC);
}

function getPopularBook($pdo) {
    $stmt_getbookdata = $pdo->prepare('
        SELECT * 
        FROM table_bocker
        WHERE status_fk = 2');
    $stmt_getbookdata->execute();
    

    return $stmt_getbookdata->fetchall(PDO::FETCH_ASSOC);
}

function getPopularRNBook($pdo) {
    $stmt_getbookdata = $pdo->prepare('
        SELECT * 
        FROM table_bocker
        WHERE status_fk = 3');
    $stmt_getbookdata->execute();
    

    return $stmt_getbookdata->fetchall(PDO::FETCH_ASSOC);
}


?>