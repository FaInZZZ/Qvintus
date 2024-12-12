

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
      "title" => "Dashboard",
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
<link rel="stylesheet" href="../assets/css/styleforheader.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

</head>
<body>
<header class="container-fluid custom-bg">
	<nav class="navbar navbar-expand-lg navbar-dark custom-bg">
  <div class="container-fluid custom-bg">
  
    <a class="navbar-brand" href="index.php">Qvintus</a>
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
