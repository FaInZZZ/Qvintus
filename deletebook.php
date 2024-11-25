<?php
include_once 'includes/header.php';



if (isset($_GET['BookID'])) {
    $bookId = $_GET['BookID'];

   

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

    $stmt_deleteBook = $pdo->prepare('DELETE FROM table_bocker WHERE id_bok = :id_bok');
    $stmt_deleteBook->bindParam(':id_bok', $bookId, PDO::PARAM_INT);

    if ($stmt_deleteBook->execute()) {
        header("Location: books_list.php?delete=success");
        exit();
    } else {
        header("Location: books_list.php?delete=error");
        exit();
    }
} else {
    header("Location: books_list.php");
    exit();
}
?>
