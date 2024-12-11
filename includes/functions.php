<?php
include_once 'includes/header.php';
include_once 'class.user.php';
$user = new User($pdo);


function getSingleBookInformation($pdo, $bookid) {
    $stmt_getBookdata = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            table_users.u_name,
            table_language.lan_name,
            table_status.status_namn,
            table_serie.serie_name,
            table_age.age_name,
            table_publisher.pub_name
        FROM 
            table_bocker
        INNER JOIN 
            table_publisher 
        ON 
            table_bocker.publisher_fk = table_publisher.id_pub
        INNER JOIN 
            table_users 
        ON 
            table_bocker.createdby_fk = table_users.u_id
        INNER JOIN 
            table_language
        ON
            table_bocker.lan_fk = table_language.id_lan
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
    $bookData['genres'] = $stmt_getGenres->fetchAll(PDO::FETCH_COLUMN);

    $stmt_getAuthors = $pdo->prepare('
        SELECT 
            table_author.author_name
        FROM 
            book_author
        INNER JOIN 
            table_author
        ON 
            book_author.id_author = table_author.id_author
        WHERE 
            book_author.id_book = :bookid
    ');
    $stmt_getAuthors->bindParam(':bookid', $bookid, PDO::PARAM_INT);
    $stmt_getAuthors->execute();
    $bookData['authors'] = $stmt_getAuthors->fetchAll(PDO::FETCH_COLUMN);

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
    $bookData['designers'] = $stmt_getDesigners->fetchAll(PDO::FETCH_COLUMN);

    return $bookData;
}





function getSingleBook($pdo, $bookID) {
    $stmt = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            table_users.u_name AS created_by_user, 
            table_category.id_category, 
            table_category.category_name, 
            GROUP_CONCAT(DISTINCT table_author.id_author) AS author_ids, 
            GROUP_CONCAT(DISTINCT table_genre.id_genre) AS genre_ids, 
            GROUP_CONCAT(DISTINCT table_designer.id_designer) AS designer_ids, 
            table_serie.id_serie, 
            table_serie.serie_name, 
            table_language.id_lan, 
            table_language.lan_name, 
            table_status.id_status, 
            table_status.status_namn,
            table_age.id_age, 
            table_age.age_name,
            table_publisher.id_pub AS publisher_fk, 
            table_publisher.pub_name,
            table_stock.id_stock AS stock_fk,
            table_stock.stock_name
        FROM 
            table_bocker
        LEFT JOIN 
            table_users ON table_bocker.createdby_fk = table_users.u_id
        LEFT JOIN 
            table_category ON table_bocker.category_fk = table_category.id_category
        LEFT JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author
        LEFT JOIN 
            book_genre ON table_bocker.id_bok = book_genre.book_id
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre
        LEFT JOIN 
            book_designer ON table_bocker.id_bok = book_designer.id_book
        LEFT JOIN 
            table_designer ON book_designer.id_designer = table_designer.id_designer
        LEFT JOIN 
            table_serie ON table_bocker.serie_fk = table_serie.id_serie
        LEFT JOIN 
            table_language ON table_bocker.lan_fk = table_language.id_lan
        LEFT JOIN 
            table_age ON table_bocker.age_fk = table_age.id_age
        LEFT JOIN 
            table_status ON table_bocker.status_fk = table_status.id_status
        LEFT JOIN 
           table_stock ON table_bocker.stock_fk = table_stock.id_stock
        LEFT JOIN 
            table_publisher ON table_bocker.publisher_fk = table_publisher.id_pub
        WHERE 
            table_bocker.id_bok = :id
        GROUP BY 
            table_bocker.id_bok
    ');

    $stmt->bindParam(':id', $bookID, PDO::PARAM_INT);
    $stmt->execute();
    
    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

    $bookData['authors'] = isset($bookData['author_ids']) ? explode(',', $bookData['author_ids']) : [];
    $bookData['genres'] = isset($bookData['genre_ids']) ? explode(',', $bookData['genre_ids']) : [];
    $bookData['designers'] = isset($bookData['designer_ids']) ? explode(',', $bookData['designer_ids']) : [];

    return $bookData;
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
    $stmt_getAuthordata = $pdo->prepare('SELECT id_author, author_name FROM table_author');
    
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

function getPublisherInformation($pdo) {
    $stmt_getPublisherData = $pdo->prepare('SELECT id_pub, pub_name FROM table_publisher');
    $stmt_getPublisherData->execute();
    return $stmt_getPublisherData->fetchAll(PDO::FETCH_ASSOC);
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
    $stmt = $pdo->prepare('INSERT INTO table_category (category_name) VALUES (:category_name)');
    $stmt->bindParam(':category_name', $_POST['CategoryName'], PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Category.</div>';
    }
}

function updateCategory($pdo, $CategoryId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_category SET category_name = :updatedName WHERE id_category = :CategoryId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':CategoryId', $CategoryId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Category.</div>';
    }
}

function deleteCategory($pdo, $CategoryId) {
    $stmt = $pdo->prepare("DELETE FROM table_category WHERE id_category = :CategoryId");
    $stmt->bindParam(':CategoryId', $CategoryId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully Deleted!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to delete category.</div>';
    }
}







function createserie($pdo) {
    $stmt = $pdo->prepare('INSERT INTO table_serie (serie_name) VALUES (:serie_name)');
    $stmt->bindParam(':serie_name', $_POST['serieName'], PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create serie.</div>';
    }
}

function updateserie($pdo, $serieId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_serie SET serie_name = :updatedName WHERE id_serie = :serieId");
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
    $stmt = $pdo->prepare('INSERT INTO table_author (author_name) VALUES (:author_name)');
    $stmt->bindParam(':author_name', $authorName, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Author successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create author.</div>';
    }
}


function updateAuthor($pdo, $authorId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_author SET author_name = :updatedName WHERE id_author = :authorId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">author successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update author.</div>';
    }
}

function deleteAuthor($pdo, $authorId) {
    $stmt = $pdo->prepare("DELETE FROM table_author WHERE id_author = :authorId");
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
    $stmt = $pdo->prepare('INSERT INTO table_language (lan_name) VALUES (:lan_name)');
    $stmt->bindParam(':lan_name', $lanName, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Languague successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Language.</div>';
    }
}


function updatelan($pdo, $lanId, $updatedName) {
    $stmt = $pdo->prepare("UPDATE table_language SET lan_name = :updatedName WHERE id_lan= :lanId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $stmt->bindParam(':lanId', $lanId, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Language successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update language.</div>';
    }
}

function deletelan($pdo, $lanId) {
    $stmt = $pdo->prepare("DELETE FROM table_language WHERE id_lan= :lanId");
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
    $stmt = $pdo->prepare('SELECT * FROM table_serie');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getLanguageInformation($pdo) {
    $stmt_getLandata = $pdo->prepare('
        SELECT * 
        FROM table_language');
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

function updateBook($pdo, $bookId)
{
    $bookimg = null;

    if (!empty($_FILES["book_img"]["tmp_name"])) {
        $target_dir = "img/";
        $original_file_name = basename($_FILES["book_img"]["name"]);
        $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
        $random_prefix = uniqid(); 
        $target_file = $target_dir . $random_prefix . "_" . $original_file_name;

        $uploadOk = 1;

        $check = getimagesize($_FILES["book_img"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
            die("Uploaded file is not an image.");
        }

        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        if ($uploadOk && move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
            $bookimg = $random_prefix . "_" . $original_file_name;
        } else {
            die("Failed to upload image.");
        }
    } else {
        $stmt_getCurrentImage = $pdo->prepare('SELECT bok_img FROM table_bocker WHERE id_bok = :id_bok');
        $stmt_getCurrentImage->bindParam(':id_bok', $bookId, PDO::PARAM_INT);
        $stmt_getCurrentImage->execute();
        $bookimg = $stmt_getCurrentImage->fetchColumn();
    }

    $stmt_update = $pdo->prepare('
    UPDATE table_bocker
    SET
        title = :title,
        `desc` = :description,
        pages = :pages,
        price = :price,
        date = :date,
        status_fk = :id_status,
        category_fk = :id_category,
        age_fk = :id_age,
        publisher_fk = :id_publisher,
        serie_fk = :id_serie,
        lan_fk = :id_language,
        stock_fk = :id_stock,
        bok_img = :book_img
    WHERE id_bok = :id_bok
');


    $stmt_update->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt_update->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
    $stmt_update->bindParam(':pages', $_POST['Pages'], PDO::PARAM_INT);
    $stmt_update->bindParam(':price', $_POST['Price'], PDO::PARAM_INT);
    $stmt_update->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
    $stmt_update->bindParam(':id_status', $_POST['id_status'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_category', $_POST['id_category'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_age', $_POST['id_age'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_publisher', $_POST['id_publisher'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_serie', $_POST['id_serie'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_language', $_POST['id_language'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_stock', $_POST['id_stock'], PDO::PARAM_INT);
    $stmt_update->bindParam(':book_img', $bookimg, PDO::PARAM_STR);
    $stmt_update->bindParam(':id_bok', $bookId, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success' role='alert'><strong>Success:</strong> Updated book</div>";
    } else {
        print_r($stmt_update->errorInfo());
        die('Failed to update book.');
    }
}


function insertNewBook($pdo) {
    $target_dir = "img/";
    $bookimg = null;

    if (!empty($_FILES['book_img']['name'])) {
        $original_file_name = basename($_FILES['book_img']['name']);
        $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
        $random_prefix = uniqid();
        $random_string = substr(md5(mt_rand()), 0, 6);
        $bookimg = $random_prefix . "_" . $random_string . "." . $imageFileType;
        $target_file = $target_dir . $bookimg;

        $uploadOk = 1;

        if (!empty($_FILES["book_img"]["tmp_name"])) {
            $check = getimagesize($_FILES["book_img"]["tmp_name"]);
            if ($check === false) {
                echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> File is not a valid image.</div>";
                $uploadOk = 0;
            }
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> Only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }

        if ($uploadOk === 1) {
            if (!move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
                echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> File upload failed.</div>";
                $bookimg = null;
            }
        } else {
            $bookimg = null;
        }
    }

    try {
        $stmt_insertNewBook = $pdo->prepare('
            INSERT INTO table_bocker (title, desc, age_fk, date, pages, price, serie_fk, category_fk, lan_fk, status_fk, createdby_fk, bok_img, stock_fk, publisher_fk) 
            VALUES (:title, :desc, :aldersrekommendation, :date, :pages, :price, :serie_fk, :category_fk, :lan_fk, :status_fk, :createdby_fk, :bok_img, :stock_fk, :publisher_fk)
        ');

        $stmt_insertNewBook->bindParam(":title", $_POST['title'], PDO::PARAM_STR);
        $stmt_insertNewBook->bindParam(":desc", $_POST['description'], PDO::PARAM_STR);
        $stmt_insertNewBook->bindParam(":aldersrekommendation", $_POST['id_age'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":date", $_POST['date'], PDO::PARAM_STR);
        $stmt_insertNewBook->bindParam(":pages", $_POST['pages'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":price", $_POST['price'], PDO::PARAM_STR);
        $stmt_insertNewBook->bindParam(":serie_fk", $_POST['id_Serie'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":category_fk", $_POST['id_category'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":lan_fk", $_POST['id_Language'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":status_fk", $_POST['id_status'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":stock_fk", $_POST['id_stock'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":createdby_fk", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt_insertNewBook->bindParam(":bok_img", $bookimg, PDO::PARAM_STR);
        $stmt_insertNewBook->bindParam(":publisher_fk", $_POST['id_publisher'], PDO::PARAM_INT);

        $stmt_insertNewBook->execute();
        $book_id = $pdo->lastInsertId();

        if (isset($_POST['id_author']) && is_array($_POST['id_author'])) {
            $stmt_insertAuthor = $pdo->prepare('
                INSERT INTO book_author (id_book, id_author)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_author'] as $author_id) {
                $stmt_insertAuthor->execute([$book_id, $author_id]);
            }
        }

        if (isset($_POST['id_genre']) && is_array($_POST['id_genre'])) {
            $stmt_insertGenre = $pdo->prepare('
                INSERT INTO book_genre (book_id, genre_id)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_genre'] as $genre_id) {
                $stmt_insertGenre->execute([$book_id, $genre_id]);
            }
        }

        if (isset($_POST['id_designer']) && is_array($_POST['id_designer'])) {
            $stmt_insertDesigner = $pdo->prepare('
                INSERT INTO book_designer (id_book, id_designer)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_designer'] as $designer_id) {
                $stmt_insertDesigner->execute([$book_id, $designer_id]);
            }
        }

        echo "<div class='alert alert-success' role='alert'><strong>Success:</strong> Book added successfully!</div>";
        return $book_id;

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}






function getBook($pdo) {
    $query = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            GROUP_CONCAT(DISTINCT table_author.author_name SEPARATOR ", ") AS authors
        FROM 
            table_bocker
        INNER JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author
        GROUP BY 
            table_bocker.id_bok
    ');
        
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}




function getRareBook($pdo) {
    $query = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            GROUP_CONCAT(table_author.author_name SEPARATOR ", ") AS authors
        FROM 
            table_bocker
        INNER JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author
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
                GROUP_CONCAT(table_author.author_name SEPARATOR ", ") AS authors
            FROM 
                table_bocker
            INNER JOIN 
                book_author ON table_bocker.id_bok = book_author.id_book
            INNER JOIN 
                table_author ON book_author.id_author = table_author.id_author
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




function getUserDetails($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT u_id, u_name, u_email, u_role_fk FROM table_users WHERE u_id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getRoles($pdo) {
    $stmt = $pdo->query("SELECT r_id, r_name FROM table_roles");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUser($pdo, $u_id, $u_email, $u_password, $u_role_fk) {
    $hashedPassword = !empty($u_password) ? password_hash($u_password, PASSWORD_DEFAULT) : null;

    $query = "UPDATE table_users SET u_email = ?, u_role_fk = ?";
    $params = [$u_email, $u_role_fk];

    if ($hashedPassword) {
        $query .= ", u_password = ?";
        $params[] = $hashedPassword;
    }

    $query .= " WHERE u_id = ?";
    $params[] = $u_id;

    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}

function updatecurrentUser($pdo, $u_id, $u_email, $u_password, $u_role_fk) {
    $hashedPassword = !empty($u_password) ? password_hash($u_password, PASSWORD_DEFAULT) : null;

    $query = "UPDATE table_users SET u_email = ?, u_role_fk = ?";
    $params = [$u_email, $u_role_fk];

    if ($hashedPassword) {
        $query .= ", u_password = ?";
        $params[] = $hashedPassword;
    }

    $query .= " WHERE u_id = ?";
    $params[] = $u_id;

    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}



function searchUsers($pdo, $search) {
    $search = "%" . $search . "%";
    $stmt = $pdo->prepare("
        SELECT u_id, u_name, u_email 
        FROM table_users 
        WHERE u_name LIKE :search OR u_email LIKE :search
    ");
    $stmt->bindValue(':search', $search, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getBooksByGenre($pdo, $genreID) {
    $stmt = $pdo->prepare('
        SELECT 
            table_bocker.*, 
            GROUP_CONCAT(DISTINCT table_author.author_name) AS authors,
            GROUP_CONCAT(DISTINCT table_genre.genre_name) AS genres
        FROM 
            table_bocker
        LEFT JOIN 
            book_genre ON table_bocker.id_bok = book_genre.book_id
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre
        LEFT JOIN 
            book_author ON table_bocker.id_bok = book_author.id_book
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author
        WHERE 
            book_genre.genre_id = :genreID
        GROUP BY 
            table_bocker.id_bok
    ');

    $stmt->bindParam(':genreID', $genreID, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>