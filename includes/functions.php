<?php

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


?>