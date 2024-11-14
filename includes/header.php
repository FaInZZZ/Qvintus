<?php
require_once 'includes/class.user.php';
require_once 'includes/config.php';
$user = new User($pdo);

if(isset($_GET['logout'])){
	$user->logout();
}
//Menylänkar synliga för inloggade oberoende av roll
$menuLinks = array(
    array(
        "title" => "Home",
        "url" => "home.php"
    ),
    array(
        "title" => "Account",
        "url" => "account.php"
    )
);
// Menylänkar synliga enbart för admins
$adminMenuLinks = array(
    array(
        "title" => "Adminpage",
        "url" => "admin.php"
    )
);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Powerol</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<header class="container-fluid bg-dark">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  
    <a class="navbar-brand" href="#">Powerol</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
	  <?php
	  //Generera meny från arrayer
	  if(isset($_SESSION['user_id'])){
	  foreach($menuLinks as $menuItem){
        echo "<li class='nav-item'>
          <a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
        </li>";
	  }
	  }
	  if(isset($_SESSION['user_id'])){
		  if($user->checkUserRole(300)){
		  foreach($adminMenuLinks as $menuItem){
			echo "<li class='nav-item'>
			  <a class='nav-link' href='{$menuItem['url']}'>{$menuItem['title']}</a>
			</li>";
		  }
	  }
	
	  }
	  else{
		header("Location: login.php");
	  }
		?>
		
		
		
      </ul>
    </div>
  </div>
</nav>

</header>