

<?php
include_once 'includes/upload.php';
require_once 'includes/class.user.php';
require_once 'includes/config.php';
$user = new User($pdo);

if(isset($_GET['logout'])){
	$user->logout();
}
$menuLinks = array(
    array(
        "title" => "Home",
        "url" => "index.php"
    ),
    array(
      "title" => "Books",
      "url" => "all-books.php"
    ),
    array(
      "title" => "Activity",
      "url" => "activity.php"
    ),
    array(
      "title" => "Contact us",
      "url" => "contact.php"
  )
);
$adminMenuLinks = array(
    array(
        "title" => "Adminpage",
        "url" => "admin-dashboard.php"
    )
);
$LoginMenuLinks = array(
  array(
      "title" => "dashboard",
      "url" => "book-dashboard.php"
  )
);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Qvintus</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="../assets/css/styleforheader.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<header class="container-fluid custom-bg">
	<nav class="navbar navbar-expand-lg navbar-dark custom-bg">
  <div class="container-fluid custom-bg">
  
    <a class="navbar-brand" href="#">Qvintus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

    <ul class="navbar-nav">

    <?php
    
    foreach ($menuLinks as $menuItem) {
        echo "<li class='nav-item'>
                <a class='nav-link text-white' href='{$menuItem['url']}'>{$menuItem['title']}</a>
              </li>";
    }

    if (isset($_SESSION['user_id'])) {
        if ($user->checkUserRole(300)) {
            foreach ($adminMenuLinks as $menuItem) {
                echo "<li class='nav-item'>
                        <a class='nav-link text-white' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                      </li>";
            }
        }

        if ($user->checkUserRole(5)) {
            foreach ($LoginMenuLinks as $menuItem) {
                echo "<li class='nav-item'>
                        <a class='nav-link text-white' href='{$menuItem['url']}'>{$menuItem['title']}</a>
                      </li>";
            }
        }

        echo "<li class='nav-item'>
                <a class='nav-link text-white' href='?logout=1'>Log out</a>
              </li>";
    }
    ?>
</ul>
    </div>
  </div>
</nav>

<style>
  .custom-bg {
    background-color: #8a7336; 
    color: white; 
}
</style>
</header>
