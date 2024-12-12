<?php
include_once 'includes/functions.php';
include_once 'includes/header.php';
$user->checkLoginStatus();



?>


<div class="container text-center mt-5">
<?php 
	echo "<h2>Welcome {$_SESSION['user_name']}</h2>";
?>
</div>	

<?php include_once 'includes/footerfixed.php'; ?>
