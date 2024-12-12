<?php
include_once 'includes/config.php';
include_once 'includes/header.php';

if(isset($_POST['user-login'])){
	$errorMessage = $user->login($_POST['uname'], $_POST['upass']);
}

?>


<div class="container">
<?php 
	if(isset($_GET['newuser'])){
		echo "	<div class='alert alert-success text-center mt-2' role='alert'>
					You have successfully registered. Please log in using the form below.
				</div>";
	}
	if(isset($errorMessage)){
		echo "<div class='alert alert-danger text-center mt-2' role='alert'>";
					
		foreach($errorMessage as $item){
		echo $item;
	}
	echo "</div>";
	}
	
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/login.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Qvintus</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-sm">
					<div class="card-body">
						<h1 class="text-center mb-4">Login Form</h1>
						<form action="" method="post">
							<div class="mb-3">
								<label for="uname" class="form-label">Username or Email</label>
								<input type="text" name="uname" id="uname" class="form-control" placeholder="Enter your username or email" required>
							</div>
							<div class="mb-3">
								<label for="upass" class="form-label">Password</label>
								<input type="password" name="upass" id="upass" class="form-control" placeholder="Enter your password" required>
							</div>
							
								<input type="submit" name="user-login" value="Login" class="btn custom-btn btn-lg w-100">
						
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once 'includes/footerfixed.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
