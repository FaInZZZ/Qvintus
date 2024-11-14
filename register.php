<?php

include_once 'includes/header.php';

if(isset($_POST['register-submit'])){
	$feedback = $user->checkUserRegisterInput($_POST['uname'], $_POST['umail'], $_POST['upass'], $_POST['upassrepeat']);
	
	if($feedback === 1){
		$user->register($_POST['uname'], $_POST['umail'], $_POST['upass']);
	}
	else{
		foreach($feedback as $item){
			echo $item;
		}
	}
}
?>


<div class="container">
<h1>Register form</h1>
    <form method="post">
		<label for="uname" class="form-label">Username</label><br>
        <input type="text" class="form-control" name="uname" id="uname"><br>
		<label for="umail" class="form-label">Email</label><br>
        <input type="text" class="form-control" name="umail" id="umail"><br>
		<label for="upass" class="form-label">Password</label><br>
        <input type="password" class="form-control" name="upass" id="upass"><br>
		<label for="upassrepeat" class="form-label">Repeat password</label><br>
        <input type="password" class="form-control" name="upassrepeat" id="upassrepeat"><br>
        <input type="submit" class="btn btn-primary py-2 px-5" name="register-submit" value="Register">
    </form>
</div>	@
<?php 
include_once 'includes/footer.php';
?>