<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();



?>


<div class="container">
<?php 
	echo "<h2>Välkommen {$_SESSION['user_name']}</h2>";
?>
</div>	
<?php 
include_once 'includes/footer.php';
?>