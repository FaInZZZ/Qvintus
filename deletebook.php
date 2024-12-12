<?php
include_once 'includes/header.php';
$user->checkLoginStatus();
$user->checkUserRole(5);
if (isset($_GET['BookID'])) {
    $bookId = $_GET['BookID'];

    try {
        $stmt_getBookOwner = $pdo->prepare('SELECT createdby_fk FROM table_books WHERE id_bok = :id_bok');
        $stmt_getBookOwner->bindParam(':id_bok', $bookId, PDO::PARAM_INT);
        $stmt_getBookOwner->execute();
        $book = $stmt_getBookOwner->fetch(PDO::FETCH_ASSOC);

        if ($book['createdby_fk'] != $_SESSION['user_id']) {
            if (!$user->checkUserRole(300)) {
                echo '<div class="alert alert-danger" role="alert">You do not have permission to delete this book.</div>';
                exit();
            }
        }

        $stmt_deleteBook = $pdo->prepare('DELETE FROM table_books WHERE id_bok = :id_bok');
        $stmt_deleteBook->bindParam(':id_bok', $bookId, PDO::PARAM_INT);

        if ($stmt_deleteBook->execute()) {
            echo '<div class="alert alert-success" role="alert">Book successfully deleted!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Failed to delete book.</div>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000' && strpos($e->getMessage(), '1451') !== false) {
            echo '<div class="alert alert-warning" role="alert">Cannot delete this book as it belongs to dashboard items.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">An unexpected error occurred: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
} else {
    echo '<div class="alert alert-danger" role="alert">No book ID provided.</div>';
}
