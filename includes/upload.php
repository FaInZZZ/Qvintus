<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';

if(isset($_POST["submitnb"])) {

    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["book_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(!empty($_FILES["book_img"]["tmp_name"])) {
        $check = getimagesize($_FILES["book_img"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {    
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

   

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["book_img"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["book_img"]["name"])) . " has been uploaded.";
            $bookimg = basename($_FILES["book_img"]["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
            $bookimg = $currentBook['bok_img']; 
        }
    }
    
}
?>



