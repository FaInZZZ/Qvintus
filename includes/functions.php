<?php
include_once 'includes/header.php';
include_once 'includes/class.user.php';

function getSingleBookInformation($pdo, $bookid) {
    // Prepare and execute query to fetch main book details along with related data
    $stmt_getBookdata = $pdo->prepare('
        SELECT 
            table_books.*,                            -- Fetch all columns from the books table
            table_users.u_name,                       -- Name of the user who created the book entry
            table_language.lan_name,                  -- Language of the book
            table_status.status_namn,                 -- Status of the book (e.g., available, checked out)
            table_serie.serie_name,                   -- Series the book belongs to
            table_age.age_name,                       -- Age category for the book
            table_publisher.pub_name,                 -- Publisher of the book
            table_stock.stock_name                    -- Stock status of the book
        FROM 
            table_books
        INNER JOIN 
            table_publisher 
        ON 
            table_books.publisher_fk = table_publisher.id_pub  -- Join with publishers
        INNER JOIN 
            table_users 
        ON 
            table_books.createdby_fk = table_users.u_id        -- Join with users
        INNER JOIN 
            table_language
        ON
            table_books.lan_fk = table_language.id_lan         -- Join with languages
        INNER JOIN 
            table_age
        ON
            table_books.age_fk = table_age.id_age              -- Join with age categories
        INNER JOIN 
            table_status
        ON
            table_books.status_fk = table_status.id_status     -- Join with statuses
        INNER JOIN 
            table_serie
        ON
            table_books.serie_fk = table_serie.id_serie        -- Join with series
        INNER JOIN 
            table_stock
        ON
            table_books.stock_fk = table_stock.id_stock        -- Join with stock statuses
        WHERE 
            table_books.id_bok = :bookid                       -- Filter by book ID
    ');
    $stmt_getBookdata->bindParam(':bookid', $bookid, PDO::PARAM_INT); // Bind book ID securely
    $stmt_getBookdata->execute();                                   // Execute query
    $bookData = $stmt_getBookdata->fetch(PDO::FETCH_ASSOC);         // Fetch book details as an associative array

    // Fetch genres associated with the book
    $stmt_getGenres = $pdo->prepare('
        SELECT 
            table_genre.genre_name                           -- Genre names
        FROM 
            book_genre
        INNER JOIN 
            table_genre
        ON 
            book_genre.genre_id = table_genre.id_genre       -- Join with genres
        WHERE 
            book_genre.book_id = :bookid                     -- Filter by book ID
    ');
    $stmt_getGenres->bindParam(':bookid', $bookid, PDO::PARAM_INT);  // Bind book ID
    $stmt_getGenres->execute();                                    // Execute query
    $bookData['genres'] = $stmt_getGenres->fetchAll(PDO::FETCH_COLUMN); // Fetch all genres as an array

    // Fetch authors associated with the book
    $stmt_getAuthors = $pdo->prepare('
        SELECT 
            table_author.author_name                        -- Author names
        FROM 
            book_author
        INNER JOIN 
            table_author
        ON 
            book_author.id_author = table_author.id_author  -- Join with authors
        WHERE 
            book_author.id_book = :bookid                   -- Filter by book ID
    ');
    $stmt_getAuthors->bindParam(':bookid', $bookid, PDO::PARAM_INT); // Bind book ID
    $stmt_getAuthors->execute();                                  // Execute query
    $bookData['authors'] = $stmt_getAuthors->fetchAll(PDO::FETCH_COLUMN); // Fetch all authors as an array

    // Fetch designers associated with the book
    $stmt_getDesigners = $pdo->prepare('
        SELECT 
            table_designer.designer_name                     -- Designer names
        FROM 
            book_designer
        INNER JOIN 
            table_designer
        ON 
            book_designer.id_designer = table_designer.id_designer -- Join with designers
        WHERE 
            book_designer.id_book = :bookid                  -- Filter by book ID
    ');
    $stmt_getDesigners->bindParam(':bookid', $bookid, PDO::PARAM_INT); // Bind book ID
    $stmt_getDesigners->execute();                                 // Execute query
    $bookData['designers'] = $stmt_getDesigners->fetchAll(PDO::FETCH_COLUMN); // Fetch all designers as an array

    // Return the complete book data with all related information
    return $bookData;
}






function getSingleBook($pdo, $bookID) {
    // Prepare a SQL query to fetch all book details along with related data
    $stmt = $pdo->prepare('
        SELECT 
            table_books.*,                               -- All fields from the books table
            table_users.u_name AS created_by_user,       -- Name of the user who created the book entry
            table_category.id_category,                  -- Category ID
            table_category.category_name,                -- Category name
            GROUP_CONCAT(DISTINCT table_author.id_author) AS author_ids,   -- Concatenate author IDs
            GROUP_CONCAT(DISTINCT table_genre.id_genre) AS genre_ids,      -- Concatenate genre IDs
            GROUP_CONCAT(DISTINCT table_designer.id_designer) AS designer_ids, -- Concatenate designer IDs
            table_serie.id_serie,                        -- Series ID
            table_serie.serie_name,                      -- Series name
            table_language.id_lan,                       -- Language ID
            table_language.lan_name,                     -- Language name
            table_status.id_status,                      -- Status ID
            table_status.status_namn,                    -- Status name
            table_age.id_age,                            -- Age category ID
            table_age.age_name,                          -- Age category name
            table_publisher.id_pub AS publisher_fk,      -- Publisher ID
            table_publisher.pub_name,                    -- Publisher name
            table_stock.id_stock AS stock_fk,            -- Stock ID
            table_stock.stock_name                       -- Stock status name
        FROM 
            table_books
        LEFT JOIN 
            table_users ON table_books.createdby_fk = table_users.u_id        -- Link to the user who created the entry
        LEFT JOIN 
            table_category ON table_books.category_fk = table_category.id_category -- Link to the books category
        LEFT JOIN 
            book_author ON table_books.id_bok = book_author.id_book           -- Link books to their authors
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author     -- Fetch author names
        LEFT JOIN 
            book_genre ON table_books.id_bok = book_genre.book_id             -- Link books to their genres
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre          -- Fetch genre names
        LEFT JOIN 
            book_designer ON table_books.id_bok = book_designer.id_book       -- Link books to their designers
        LEFT JOIN 
            table_designer ON book_designer.id_designer = table_designer.id_designer -- Fetch designer names
        LEFT JOIN 
            table_serie ON table_books.serie_fk = table_serie.id_serie        -- Link books to their series
        LEFT JOIN 
            table_language ON table_books.lan_fk = table_language.id_lan      -- Link books to their language
        LEFT JOIN 
            table_age ON table_books.age_fk = table_age.id_age                -- Link books to their age category
        LEFT JOIN 
            table_status ON table_books.status_fk = table_status.id_status    -- Link books to their status
        LEFT JOIN 
            table_stock ON table_books.stock_fk = table_stock.id_stock        -- Link books to their stock status
        LEFT JOIN 
            table_publisher ON table_books.publisher_fk = table_publisher.id_pub -- Link books to their publisher
        WHERE 
            table_books.id_bok = :id                                          -- Filter by book ID
        GROUP BY 
            table_books.id_bok                                                -- Group results by book ID
    ');

    // Bind the book ID securely to the query to prevent SQL injection
    $stmt->bindParam(':id', $bookID, PDO::PARAM_INT);
    // Execute the query
    $stmt->execute();
    
    // Fetch the book data as an associative array
    $bookData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Convert concatenated author IDs into an array
    $bookData['authors'] = isset($bookData['author_ids']) ? explode(',', $bookData['author_ids']) : [];
    // Convert concatenated genre IDs into an array
    $bookData['genres'] = isset($bookData['genre_ids']) ? explode(',', $bookData['genre_ids']) : [];
    // Convert concatenated designer IDs into an array
    $bookData['designers'] = isset($bookData['designer_ids']) ? explode(',', $bookData['designer_ids']) : [];

    // Return the complete book data with all related information
    return $bookData;
}





// Function to fetch all category information from the database
function getCategoryInformation($pdo) {
    $stmt_getCategorydata = $pdo->prepare('
        SELECT * 
        FROM table_category'); // Query to select all fields from the category table
    $stmt_getCategorydata->execute(); // Execute the query

    return $stmt_getCategorydata->fetchAll(PDO::FETCH_ASSOC); // Return all category records as an associative array
}

// Function to fetch all stock information from the database
function getStockInformation($pdo) {
    $stmt_getStockdata = $pdo->prepare('
        SELECT * 
        FROM table_stock'); // Query to select all fields from the stock table
    $stmt_getStockdata->execute(); // Execute the query

    return $stmt_getStockdata->fetchAll(PDO::FETCH_ASSOC); // Return all stock records as an associative array
}

// Function to fetch all author information from the database
function getAuthorInformation($pdo) {
    $stmt_getAuthordata = $pdo->prepare('
        SELECT id_author, author_name 
        FROM table_author'); // Query to select author ID and name from the author table
    $stmt_getAuthordata->execute(); // Execute the query

    $Authors = $stmt_getAuthordata->fetchAll(PDO::FETCH_ASSOC); // Fetch all author records as an associative array
    return $Authors; // Return the author information
}

// Function to fetch all age category information from the database
function getAgeInformation($pdo) {
    $stmt_getAgedata = $pdo->prepare('
        SELECT * 
        FROM table_age'); // Query to select all fields from the age table
    $stmt_getAgedata->execute(); // Execute the query

    return $stmt_getAgedata->fetchAll(PDO::FETCH_ASSOC); // Return all age records as an associative array
}

// Function to fetch all genre information from the database
function getGenreInformation($pdo) {
    $stmt_getGenredata = $pdo->prepare('
        SELECT id_genre, genre_name 
        FROM table_genre'); // Query to select genre ID and name from the genre table
    $stmt_getGenredata->execute(); // Execute the query

    $genres = $stmt_getGenredata->fetchAll(PDO::FETCH_ASSOC); // Fetch all genre records as an associative array
    return $genres; // Return the genre information
}

// Function to fetch all publisher information from the database
function getPublisherInformation($pdo) {
    $stmt_getPublisherData = $pdo->prepare('
        SELECT id_pub, pub_name 
        FROM table_publisher'); // Query to select publisher ID and name from the publisher table
    $stmt_getPublisherData->execute(); // Execute the query

    return $stmt_getPublisherData->fetchAll(PDO::FETCH_ASSOC); // Return all publisher records as an associative array
}






// Function to create a new genre
function createGenre($pdo, $genreName, $isPopular) {
    // Determine the status based on whether the genre is popular
    $status = $isPopular ? 3 : 4;

    // Prepare the SQL statement to insert a new genre
    $stmt = $pdo->prepare('INSERT INTO table_genre (genre_name, p_status_fk) VALUES (:genre_name, :p_status_fk)');
    $stmt->bindParam(':genre_name', $genreName, PDO::PARAM_STR); // Bind the genre name
    $stmt->bindParam(':p_status_fk', $status, PDO::PARAM_INT);  // Bind the status

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Genre successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create genre.</div>';
    }
}

// Function to update an existing genre
function updateGenre($pdo, $genreId, $updatedName, $isPopular) {
    // Determine the status based on whether the genre is popular
    $status = $isPopular ? 3 : 4;

    // Prepare the SQL statement to update the genre
    $stmt = $pdo->prepare("UPDATE table_genre SET genre_name = :updatedName, p_status_fk = :status WHERE id_genre = :genreId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated genre name
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);          // Bind the updated status
    $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);        // Bind the genre ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Genre successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update genre.</div>';
    }
}

// Function to delete a genre
function deleteGenre($pdo, $genreId) {
    try {
        // Prepare the SQL statement to delete a genre
        $stmt = $pdo->prepare("DELETE FROM table_genre WHERE id_genre = :genreId");
        $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT); // Bind the genre ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Genre successfully deleted.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete genre.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete genre. This genre is associated with one or more books.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// Function to create a new category
function createCategory($pdo) {
    // Prepare the SQL statement to insert a new category
    $stmt = $pdo->prepare('INSERT INTO table_category (category_name) VALUES (:category_name)');
    $stmt->bindParam(':category_name', $_POST['CategoryName'], PDO::PARAM_STR); // Bind the category name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Category.</div>';
    }
}

// Function to update an existing category
function updateCategory($pdo, $CategoryId, $updatedName) {
    // Prepare the SQL statement to update the category
    $stmt = $pdo->prepare("UPDATE table_category SET category_name = :updatedName WHERE id_category = :CategoryId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated category name
    $stmt->bindParam(':CategoryId', $CategoryId, PDO::PARAM_INT);   // Bind the category ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Category successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Category.</div>';
    }
}

// Function to delete a category
function deleteCategory($pdo, $categoryId) {
    try {
        // Prepare the SQL statement to delete a category
        $stmt = $pdo->prepare("DELETE FROM table_category WHERE id_category = :categoryId");
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT); // Bind the category ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Category successfully deleted.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete category.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">
                Cannot delete category. This category is associated with one or more books. Please remove the association first.
            </div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">
                An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '
            </div>';
        }
    }
}









// Function to create a new series
function createSerie($pdo) {
    // Prepare the SQL query to insert a new series
    $stmt = $pdo->prepare('INSERT INTO table_serie (serie_name) VALUES (:serie_name)');
    $stmt->bindParam(':serie_name', $_POST['serieName'], PDO::PARAM_STR); // Bind the series name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create serie.</div>';
    }
}

// Function to update an existing series
function updateSerie($pdo, $serieId, $updatedName) {
    // Prepare the SQL query to update the series
    $stmt = $pdo->prepare("UPDATE table_serie SET serie_name = :updatedName WHERE id_serie = :serieId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated series name
    $stmt->bindParam(':serieId', $serieId, PDO::PARAM_INT);         // Bind the series ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Serie successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update serie.</div>';
    }
}

// Function to delete a series
function deleteSerie($pdo, $serieId) {
    try {
        // Prepare the SQL query to delete the series
        $stmt = $pdo->prepare("DELETE FROM table_serie WHERE id_serie = :serieId");
        $stmt->bindParam(':serieId', $serieId, PDO::PARAM_INT); // Bind the series ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Serie successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete serie.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete serie. This serie is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}



// Function to create a new publisher
function createpublisher($pdo) {
    // Prepare the SQL query to insert a new publisher
    $stmt = $pdo->prepare('INSERT INTO table_publisher (pub_name) VALUES (:publisher_name)');
    $stmt->bindParam(':publisher_name', $_POST['publisherName'], PDO::PARAM_STR); // Bind the publisher name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">publisher successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create publisher.</div>';
    }
} 

// Function to update an existing publishers
function updatepublisher($pdo, $publisherId, $updatedName) {
    // Prepare the SQL query to update the publishers
    $stmt = $pdo->prepare("UPDATE table_publisher SET publisher_name = :updatedName WHERE id_pub = :publisherId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated publishers name
    $stmt->bindParam(':publisherId', $publisherId, PDO::PARAM_INT);         // Bind the publishers ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">publisher successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update publisher.</div>';
    }
}

// Function to delete a publishers
function deletepublisher($pdo, $publisherId) {
    try {
        // Prepare the SQL query to delete the publishers
        $stmt = $pdo->prepare("DELETE FROM table_publisher WHERE id_pub = :publisherId");
        $stmt->bindParam(':publisherId', $publisherId, PDO::PARAM_INT); // Bind the publishers ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">publisher successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete publisher.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete publisher. This publisher is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}





// Function to create a new age category
function createAge($pdo, $AgeName) {
    // Prepare the SQL query to insert a new age category
    $stmt = $pdo->prepare('INSERT INTO table_age (age_name) VALUES (:age_name)');
    $stmt->bindParam(':age_name', $_POST['AgeName'], PDO::PARAM_STR); // Bind the age name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Age successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create age.</div>';
    }
}

// Function to update an existing age category
function updateAge($pdo, $AgeId, $updatedName) {
    // Prepare the SQL query to update the age category
    $stmt = $pdo->prepare("UPDATE table_age SET age_name = :updatedName WHERE id_age = :AgeId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated age name
    $stmt->bindParam(':AgeId', $AgeId, PDO::PARAM_INT);             // Bind the age ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Age successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update age.</div>';
    }
}

// Function to delete an age category
function deleteAge($pdo, $AgeId) {
    try {
        // Prepare the SQL query to delete the age category
        $stmt = $pdo->prepare("DELETE FROM table_age WHERE id_age = :AgeId");
        $stmt->bindParam(':AgeId', $AgeId, PDO::PARAM_INT); // Bind the age ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Age successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete age.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete age. This age is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}












// Function to create a new author
function createAuthor($pdo, $authorName) {
    // Prepare the SQL statement to insert a new author
    $stmt = $pdo->prepare('INSERT INTO table_author (author_name) VALUES (:author_name)');
    $stmt->bindParam(':author_name', $authorName, PDO::PARAM_STR); // Bind the author name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Author successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create author.</div>';
    }
}

// Function to update an existing author
function updateAuthor($pdo, $authorId, $updatedName) {
    // Prepare the SQL statement to update an author
    $stmt = $pdo->prepare("UPDATE table_author SET author_name = :updatedName WHERE id_author = :authorId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated author name
    $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);       // Bind the author ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Author successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update author.</div>';
    }
}

// Function to delete an author
function deleteAuthor($pdo, $authorId) {
    try {
        // Prepare the SQL statement to delete an author
        $stmt = $pdo->prepare("DELETE FROM table_author WHERE id_author = :authorId");
        $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT); // Bind the author ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Author successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete author.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete Author. This author is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// Function to create a new designer
function createDesigner($pdo, $DesignerName) {
    // Prepare the SQL statement to insert a new designer
    $stmt = $pdo->prepare('INSERT INTO table_designer (designer_name) VALUES (:Designer_name)');
    $stmt->bindParam(':Designer_name', $DesignerName, PDO::PARAM_STR); // Bind the designer name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Designer successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Designer.</div>';
    }
}

// Function to update an existing designer
function updateDesigner($pdo, $designerId, $updatedName) {
    // Prepare the SQL statement to update a designer
    $stmt = $pdo->prepare("UPDATE table_designer SET designer_name = :updatedName WHERE id_designer = :DesignerId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated designer name
    $stmt->bindParam(':DesignerId', $designerId, PDO::PARAM_INT);   // Bind the designer ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Designer successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update Designer.</div>';
    }
}

// Function to delete a designer
function deleteDesigner($pdo, $designerId) {
    try {
        // Prepare the SQL statement to delete a designer
        $stmt = $pdo->prepare("DELETE FROM table_designer WHERE id_designer = :designerId");
        $stmt->bindParam(':designerId', $designerId, PDO::PARAM_INT); // Bind the designer ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Designer successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete designer.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete designer. This designer is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// Function to create a new language
function createlan($pdo, $lanName) {
    // Prepare the SQL statement to insert a new language
    $stmt = $pdo->prepare('INSERT INTO table_language (lan_name) VALUES (:lan_name)');
    $stmt->bindParam(':lan_name', $lanName, PDO::PARAM_STR); // Bind the language name

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Language successfully created!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to create Language.</div>';
    }
}



// Function to update an existing language
function updatelan($pdo, $lanId, $updatedName) {
    // Prepare the SQL statement to update the language name
    $stmt = $pdo->prepare("UPDATE table_language SET lan_name = :updatedName WHERE id_lan = :lanId");
    $stmt->bindParam(':updatedName', $updatedName, PDO::PARAM_STR); // Bind the updated language name
    $stmt->bindParam(':lanId', $lanId, PDO::PARAM_INT);            // Bind the language ID

    // Execute the query and display success or error message
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Language successfully updated!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Failed to update language.</div>';
    }
}

// Function to delete a language
function deletelan($pdo, $lanId) {
    try {
        // Prepare the SQL statement to delete the language
        $stmt = $pdo->prepare("DELETE FROM table_language WHERE id_lan = :lanId");
        $stmt->bindParam(':lanId', $lanId, PDO::PARAM_INT); // Bind the language ID

        // Execute the query and display success or error message
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">Language successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete language.</div>';
        }
    } catch (PDOException $e) {
        // Handle foreign key constraint violation
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete language. This language is associated with one or more items.</div>';
        } else {
            // Handle unexpected errors
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// Function to fetch popular genres
function getPopularGenres($pdo) {
    // Prepare the SQL query to fetch genres marked as popular (p_status_fk = 3)
    $stmt = $pdo->prepare("
        SELECT genre_name, id_genre
        FROM table_genre
        WHERE p_status_fk = 3
        LIMIT 6 -- Limit to the top 6 popular genres
    ");
    $stmt->execute(); // Execute the query

    // Return the results as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}

// Function to fetch all series information
function getSerieInformation($pdo) {
    // Prepare the SQL query to select all series data
    $stmt = $pdo->prepare('SELECT * FROM table_serie');
    $stmt->execute(); // Execute the query

    // Return all series records as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch all language information
function getLanguageInformation($pdo) {
    // Prepare the SQL query to select all language data
    $stmt_getLandata = $pdo->prepare('
        SELECT * 
        FROM table_language
    ');
    $stmt_getLandata->execute(); // Execute the query

    // Return all language records as an associative array
    return $stmt_getLandata->fetchAll(PDO::FETCH_ASSOC);
}


// Function to fetch all status information
function getStatusInformation($pdo) {
    // Prepare the SQL query to select all fields from the status table
    $stmt_getStatusdata = $pdo->prepare('
        SELECT * 
        FROM table_status
    ');

    // Execute the query
    $stmt_getStatusdata->execute();

    // Return all status records as an associative array
    return $stmt_getStatusdata->fetchAll(PDO::FETCH_ASSOC);
}

// Function to fetch all designer information
function getDesignerInformation($pdo) {
    // Prepare the SQL query to select designer IDs and names from the designer table
    $stmt_getdesignersdata = $pdo->prepare('
        SELECT id_designer, designer_name 
        FROM table_designer
    ');

    // Execute the query
    $stmt_getdesignersdata->execute();

    // Fetch all designer records as an associative array
    $designers = $stmt_getdesignersdata->fetchAll(PDO::FETCH_ASSOC);

    // Return the designer information
    return $designers;
}




function updateBook($pdo, $bookId) {
    // Initialize the User object to handle role-based permission checks
    $user = new User($pdo);

    // Fetch the user ID of the creator of the book
    $stmt_getCreatedBy = $pdo->prepare('SELECT createdby_fk FROM table_books WHERE id_bok = :id_bok');
    $stmt_getCreatedBy->bindParam(':id_bok', $bookId, PDO::PARAM_INT);
    $stmt_getCreatedBy->execute();
    $createdBy = $stmt_getCreatedBy->fetchColumn();

    // Check if the current user is either the creator or has an admin role (role ID 100)
    if ($_SESSION['user_id'] !== $createdBy && !$user->checkUserRole(100)) {
        die('<div class="alert alert-danger" role="alert"><strong>Failed:</strong> You do not have permission to update this book</div>');
    }

    // Handle book image upload
    $bookimg = null;

    if (!empty($_FILES["book_img"]["tmp_name"])) {
        $target_dir = "img/";
        $original_file_name = basename($_FILES["book_img"]["name"]);
        $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
        $random_prefix = uniqid(); // Generate a unique prefix for the file name
        $target_file = $target_dir . $random_prefix . "_" . $original_file_name;

        $uploadOk = 1;

        // Validate that the uploaded file is an image
        $check = getimagesize($_FILES["book_img"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
            die("Uploaded file is not an image.");
        }

        // Validate the file extension
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Attempt to upload the image
        if ($uploadOk && move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
            $bookimg = $random_prefix . "_" . $original_file_name;
        } else {
            die("Failed to upload image.");
        }
    } else {
        // If no new image is uploaded, use the existing image
        $stmt_getCurrentImage = $pdo->prepare('SELECT bok_img FROM table_books WHERE id_bok = :id_bok');
        $stmt_getCurrentImage->bindParam(':id_bok', $bookId, PDO::PARAM_INT);
        $stmt_getCurrentImage->execute();
        $bookimg = $stmt_getCurrentImage->fetchColumn();
    }

    // Prepare the SQL statement to update the book record
    $stmt_update = $pdo->prepare('
        UPDATE table_books
        SET
            title = :title,
            description = :description,
            pages = :pages,
            price = :price,
            `date` = :date, 
            status_fk = :id_status,
            category_fk = :id_category,
            age_fk = :id_age,
            publisher_fk = :id_pub,
            serie_fk = :id_serie,
            lan_fk = :id_language,
            stock_fk = :id_stock,
            bok_img = :book_img
        WHERE id_bok = :id_bok
    ');

    // Bind parameters to the SQL query
    $stmt_update->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt_update->bindParam(':description', $_POST['description'], PDO::PARAM_STR);
    $stmt_update->bindParam(':pages', $_POST['Pages'], PDO::PARAM_INT);
    $stmt_update->bindParam(':price', $_POST['Price'], PDO::PARAM_INT);
    $stmt_update->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
    $stmt_update->bindParam(':id_status', $_POST['id_status'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_category', $_POST['id_category'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_age', $_POST['id_age'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_pub', $_POST['id_pub'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_serie', $_POST['id_serie'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_language', $_POST['id_language'], PDO::PARAM_INT);
    $stmt_update->bindParam(':id_stock', $_POST['id_stock'], PDO::PARAM_INT);
    $stmt_update->bindParam(':book_img', $bookimg, PDO::PARAM_STR);
    $stmt_update->bindParam(':id_bok', $bookId, PDO::PARAM_INT);

    // Execute the query and handle the result
    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success' role='alert'><strong>Success:</strong> Updated book</div>";
    } else {
        print_r($stmt_update->errorInfo());
        die('<div class="alert alert-danger" role="alert"><strong>Failed:</strong> Failed to update book.</div>');
    }
}



function insertNewBook($pdo) {
    // Define the target directory for storing uploaded book images
    $target_dir = "img/";
    $bookimg = null;

    // Handle image upload if a file is provided
    if (!empty($_FILES['book_img']['name'])) {
        $original_file_name = basename($_FILES['book_img']['name']);
        $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION)); // Extract the file type
        $random_prefix = uniqid(); // Generate a unique prefix for the file name
        $random_string = substr(md5(mt_rand()), 0, 6); // Generate a random string for additional uniqueness
        $bookimg = $random_prefix . "_" . $random_string . "." . $imageFileType; // Create the new file name
        $target_file = $target_dir . $bookimg;

        $uploadOk = 1;

        // Validate the file as an image
        if (!empty($_FILES["book_img"]["tmp_name"])) {
            $check = getimagesize($_FILES["book_img"]["tmp_name"]);
            if ($check === false) {
                echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> File is not a valid image.</div>";
                $uploadOk = 0;
            }
        }

        // Restrict allowed file types
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> Only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }

        // Attempt to upload the file if validations pass
        if ($uploadOk === 1) {
            if (!move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
                echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> File upload failed.</div>";
                $bookimg = null; // Reset the image variable on failure
            }
        } else {
            $bookimg = null; // Reset the image variable if upload validations fail
        }
    }

    try {
        // Prepare the SQL statement to insert the book details
        $stmt_insertNewBook = $pdo->prepare('
            INSERT INTO table_books (title, description, age_fk, date, pages, price, serie_fk, category_fk, lan_fk, status_fk, createdby_fk, bok_img, stock_fk, publisher_fk) 
            VALUES (:title, :desc, :aldersrekommendation, :date, :pages, :price, :serie_fk, :category_fk, :lan_fk, :status_fk, :createdby_fk, :bok_img, :stock_fk, :publisher_fk)
        ');

        // Bind parameters for the main book details
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
        $stmt_insertNewBook->bindParam(":publisher_fk", $_POST['id_pub'], PDO::PARAM_INT);

        // Execute the insertion of the main book data
        $stmt_insertNewBook->execute();
        $book_id = $pdo->lastInsertId(); // Retrieve the newly inserted book ID

        // Insert associated authors if provided
        if (isset($_POST['id_author']) && is_array($_POST['id_author'])) {
            $stmt_insertAuthor = $pdo->prepare('
                INSERT INTO book_author (id_book, id_author)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_author'] as $author_id) {
                $stmt_insertAuthor->execute([$book_id, $author_id]);
            }
        }

        // Insert associated genres if provided
        if (isset($_POST['id_genre']) && is_array($_POST['id_genre'])) {
            $stmt_insertGenre = $pdo->prepare('
                INSERT INTO book_genre (book_id, genre_id)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_genre'] as $genre_id) {
                $stmt_insertGenre->execute([$book_id, $genre_id]);
            }
        }

        // Insert associated designers if provided
        if (isset($_POST['id_designer']) && is_array($_POST['id_designer'])) {
            $stmt_insertDesigner = $pdo->prepare('
                INSERT INTO book_designer (id_book, id_designer)
                VALUES (?, ?)
            ');
            foreach ($_POST['id_designer'] as $designer_id) {
                $stmt_insertDesigner->execute([$book_id, $designer_id]);
            }
        }

        // Display success message and return the book ID
        echo "<div class='alert alert-success' role='alert'><strong>Success:</strong> Book added successfully!</div>";
        return $book_id;

    } catch (PDOException $e) {
        // Handle errors during the process
        echo "<div class='alert alert-danger' role='alert'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}







// Function to retrieve all books along with their authors
function getBook($pdo) {
    // Prepare the SQL query to fetch book details and their associated authors
    $query = $pdo->prepare('
        SELECT 
            table_books.*,                                -- Fetch all fields from the books table
            GROUP_CONCAT(DISTINCT table_author.author_name SEPARATOR ", ") AS authors -- Concatenate authors 
        FROM 
            table_books
        INNER JOIN 
            book_author ON table_books.id_bok = book_author.id_book    -- Join to associate books with authors
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author -- Fetch author details
        GROUP BY 
            table_books.id_bok                              -- Group results by book ID to avoid duplication
    ');

    // Execute the query
    $query->execute();

    // Return all results as an associative array
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Function to retrieve rare books along with their authors and categories
function getRareBook($pdo) {
    // Prepare the SQL query to fetch rare books (status_fk = 1), their authors, and categories
    $query = $pdo->prepare('
        SELECT 
            table_books.*,                              -- Fetch all fields from the books table
            table_category.*,                            -- Fetch all fields from the category table
            GROUP_CONCAT(table_author.author_name SEPARATOR ", ") AS authors -- Concatenate authors
        FROM 
            table_books
        INNER JOIN 
            book_author ON table_books.id_bok = book_author.id_book    -- Join to associate books with authors
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author -- Fetch author details
        INNER JOIN 
            table_category ON table_books.category_fk = table_category.id_category -- Associate books with categories
        WHERE 
            table_books.status_fk = 1                  -- Filter for books with status "rare" (status_fk = 1)
        GROUP BY 
            table_books.id_bok                          -- Group results by book ID
    ');

    // Execute the query
    $query->execute();

    // Return all results as an associative array
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

// Function to retrieve popular books along with their authors and categories
function getPopularBook($pdo) {
    // Prepare the SQL query to fetch popular books (status_fk = 3), their authors, and categories
    $query = $pdo->prepare('
        SELECT 
            table_books.*,                              -- Fetch all fields from the books table
            table_category.*,                            -- Fetch all fields from the category table
            GROUP_CONCAT(table_author.author_name SEPARATOR ", ") AS authors -- Concatenate authors
        FROM 
            table_books
        INNER JOIN 
            book_author ON table_books.id_bok = book_author.id_book    -- Join to associate books with authors
        INNER JOIN 
            table_author ON book_author.id_author = table_author.id_author -- Fetch author details
        INNER JOIN 
            table_category ON table_books.category_fk = table_category.id_category -- Associate books with categories
        WHERE 
            table_books.status_fk = 3                  -- Filter for books with status "popular" (status_fk = 3)
        GROUP BY 
            table_books.id_bok                          -- Group results by book ID
    ');

    // Execute the query
    $query->execute();

    // Return all results as an associative array
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

    




function insertNewHistory($pdo) {
    try {
        // Get the uploaded image file name
        $bookimg = basename($_FILES['book_img']['name']);

        // Prepare the SQL query to insert a new history record
        $stmt_insertNewHistory = $pdo->prepare('
            INSERT INTO table_history (history_title, history_desc, history_img) 
            VALUES (:history_title, :history_desc, :history_img)
        ');

        // Bind parameters securely to prevent SQL injection
        $stmt_insertNewHistory->bindParam(":history_title", $_POST['history_title'], PDO::PARAM_STR);
        $stmt_insertNewHistory->bindParam(":history_desc", $_POST['history_desc'], PDO::PARAM_STR);
        $stmt_insertNewHistory->bindParam(":history_img", $bookimg, PDO::PARAM_STR);

        // Execute the query
        $stmt_insertNewHistory->execute();

        // Provide user feedback on successful insertion
        echo '<div class="alert alert-success" role="alert">New history successfully added!</div>';
    } catch (Exception $e) {
        // Handle any exceptions and display error messages
        echo '<div class="alert alert-danger" role="alert">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

    



function getLatestHistories($pdo) {
    // Prepare the SQL query to fetch the latest 3 histories
    $stmt = $pdo->prepare("
        SELECT * 
        FROM table_history 
        ORDER BY id_history DESC 
        LIMIT 3
    ");

    // Execute the query
    $stmt->execute();

    // Return the fetched histories as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





function getUserDetails($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT u_id, u_name, u_email, u_role_fk FROM table_users WHERE u_id = :id");
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function getRoles($pdo) {
    // Query to fetch all roles from the roles table
    $stmt = $pdo->query("
        SELECT r_id, r_name 
        FROM table_roles
    ");

    // Return the fetched roles as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function updateUser($pdo, $u_id, $u_email, $u_password, $u_role_fk) {
    try {
        // Start building the query to update user details
        $query = "UPDATE table_users SET u_email = :email, u_role_fk = :role";

        // Conditionally include the password update
        if (!empty($u_password)) {
            $query .= ", u_password = :password";
        }

        $query .= " WHERE u_id = :id"; // Add the WHERE clause to target the user

        // Prepare the query
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':email', $u_email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $u_role_fk, PDO::PARAM_INT);
        $stmt->bindParam(':id', $u_id, PDO::PARAM_INT);

        // Hash and bind the password if provided
        if (!empty($u_password)) {
            $hashedPassword = password_hash($u_password, PASSWORD_DEFAULT); // Securely hash the password
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        // Execute the query and handle feedback
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">User updated successfully!</div>';
            return true;
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to update the user. Please try again.</div>';
            return false;
        }
    } catch (PDOException $e) {
        // Catch and display any errors
        echo '<div class="alert alert-danger" role="alert">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        return false;
    }
}




function updatecurrentUser($pdo, $u_id, $u_email, $u_password, $u_role_fk) {
    try {
        // Start building the SQL query for updating the user's information
        $query = "UPDATE table_users SET u_email = :email, u_role_fk = :role";

        // Conditionally include the password update if provided
        if (!empty($u_password)) {
            $query .= ", u_password = :password";
        }

        // Append the WHERE clause to target the specific user
        $query .= " WHERE u_id = :id";

        // Prepare the query
        $stmt = $pdo->prepare($query);

        // Bind the email, role, and user ID parameters
        $stmt->bindParam(':email', $u_email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $u_role_fk, PDO::PARAM_INT);
        $stmt->bindParam(':id', $u_id, PDO::PARAM_INT);

        // Hash and bind the password if it is provided
        if (!empty($u_password)) {
            $hashedPassword = password_hash($u_password, PASSWORD_DEFAULT); // Securely hash the password
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        }

        // Execute the query and provide feedback
        if ($stmt->execute()) {
            echo '<div class="alert alert-success" role="alert">User updated successfully!</div>';
            return true;
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to update the user. Please try again.</div>';
            return false;
        }
    } catch (PDOException $e) {
        // Catch and display errors in case of failure
        echo '<div class="alert alert-danger" role="alert">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        return false;
    }
}




function searchUsers($pdo, $search) {
    try {
        // Format the search term for a partial match using wildcards
        $search = "%" . $search . "%";

        // Prepare the SQL query to search for users by name or email
        $stmt = $pdo->prepare("
            SELECT u_id, u_name, u_email 
            FROM table_users 
            WHERE u_name LIKE :search OR u_email LIKE :search
        ");

        // Bind the search term to the query
        $stmt->bindValue(':search', $search, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Fetch the search results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Provide feedback to the user
        if (!empty($results)) {
            echo '<div class="alert alert-success" role="alert">';
            echo count($results) . ' user(s) found for the search term.';
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning" role="alert">No users found for the search term.</div>';
        }

        // Return the search results
        return $results;
    } catch (PDOException $e) {
        // Handle errors and provide feedback
        echo '<div class="alert alert-danger" role="alert">An error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        return [];
    }
}




function getBooksByGenre($pdo, $genreID) {
    $stmt = $pdo->prepare('
        SELECT 
            table_books.*,                                  -- Fetch all fields from the books table
            GROUP_CONCAT(DISTINCT table_author.author_name) AS authors, -- Concatenate authors
            GROUP_CONCAT(DISTINCT table_genre.genre_name) AS genres     -- Concatenate genres
        FROM 
            table_books
        LEFT JOIN 
            book_genre ON table_books.id_bok = book_genre.book_id -- Link books to genres
        LEFT JOIN 
            table_genre ON book_genre.genre_id = table_genre.id_genre -- Fetch genre details
        LEFT JOIN 
            book_author ON table_books.id_bok = book_author.id_book -- Link books to authors
        LEFT JOIN 
            table_author ON book_author.id_author = table_author.id_author -- Fetch author details
        WHERE 
            book_genre.genre_id = :genreID                    -- Filter by the given genre ID
        GROUP BY 
            table_books.id_bok                               -- Group results by book ID to avoid duplication
    ');

    // Bind the genre ID to the query securely
    $stmt->bindParam(':genreID', $genreID, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Return the results as an associative array
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



?>