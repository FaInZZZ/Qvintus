<?php
include_once 'includes/header.php';

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



?>