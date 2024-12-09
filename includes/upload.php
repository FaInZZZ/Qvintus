<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if (isset($_POST["submitnb"])) {
    $target_dir = "img/";
    $original_file_name = basename($_FILES["book_img"]["name"]);
    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    $random_prefix = uniqid(); 
    $target_file = $target_dir . $random_prefix . "_" . $original_file_name;

    $uploadOk = 1;

    if (!empty($_FILES["book_img"]["tmp_name"])) {
        $check = getimagesize($_FILES["book_img"]["tmp_name"]);
        if ($check !== false) {  
        } else {
            $uploadOk = 0;
        }
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
    } else {
        if (move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
            $bookimg = $random_prefix . "_" . $original_file_name; 
        } else {
            $bookimg = $currentBook['bok_img'] ?? null; 
        }
    }
}
?>
