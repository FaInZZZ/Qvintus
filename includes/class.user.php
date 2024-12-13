<?php
class User {
  // Stores the username of the user. Initialized with a default value for guests.
  private $username;
  
  // Represents the role of the user, determining their access level.
  private $role;
  
  // Holds the PDO object for database interactions.
  private $pdo;
  
  // Stores error messages generated during user operations.
  private $errorMessages = [];
  
  // Tracks the error state for operations, 0 means no errors.
  private $errorState = 0;

  // Constructor initializes the default role, username, and database connection.
  // Parameters:
  // - $pdo (PDO): The PDO object used for database interactions.
  function __construct($pdo) {
	$this->role = 4; // Default role is set to 4, likely representing a guest.
	$this->username = "RandomGuest123"; // Default username for unauthenticated users.
	$this->pdo = $pdo; // Assigns the PDO object for database use.
  }
  
  // Cleans input data by trimming whitespace, stripping slashes, and converting special characters.
  // Parameters:
  // - $data (string): The input data to be cleaned.
  // Returns:
  // - (string): The sanitized input data.
  private function cleanInput($data){
		$data = trim($data); // Removes unnecessary whitespace.
		$data = stripslashes($data); // Removes slashes from input.
		$data = htmlspecialchars($data); // Converts special characters to HTML entities to prevent XSS.
		return $data;
	}
  
  // Validates user registration inputs including username, email, and password.
  // Parameters:
  // - $uname (string): The username provided by the user.
  // - $umail (string): The user's email address.
  // - $upass (string): The user's password.
  // - $upassrepeat (string): Confirmation of the password.
  // Returns:
  // - (array|string): Array of error messages if validation fails, or 1 if validation succeeds.
  public function checkUserRegisterInput($uname, $umail, $upass, $upassrepeat){
	  $this->errorState = 0;
		if(isset($_POST['register-submit'])){
		  // Checks if the username or email is already taken.
		  $stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
		  $stmt_checkUsername->bindParam(":uname", $uname, PDO::PARAM_STR);
		  $stmt_checkUsername->bindParam(":email", $umail, PDO::PARAM_STR);
		  $stmt_checkUsername->execute();
		  
		  if($stmt_checkUsername->rowCount() > 0){
			  array_push($this->errorMessages,"Username or email is already taken! ");
			  $this->errorState = 1;
		}
	  }
	  else{
		  // Checks if the email is already taken.
		  $stmt_checkUserEmail = $this->pdo->prepare('SELECT * FROM table_users WHERE u_email = :email');
		  $stmt_checkUserEmail->bindParam(":email", $umail, PDO::PARAM_STR);
		  $stmt_checkUserEmail->execute();
		  
		  if($stmt_checkUserEmail->rowCount() > 0){
			  array_push($this->errorMessages,"Email is already taken! ");
			  $this->errorState = 1;
		}
	  }

	  // Validates password match and length.
	  if($upass !== $upassrepeat){
		  array_push($this->errorMessages,"Passwords do not match! ");
		  $this->errorState = 1;
	  }
	  else{
		  if(strlen($upass) < 8){
			array_push($this->errorMessages,"Password is too short! ");
			$this->errorState = 1;
		  }
	  }
	  
	  // Validates email format.
	  if (!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorMessages,"Email not in correct format! ");
			$this->errorState = 1;
		}
	  
	 if($this->errorState === 1){ 
	 return $this->errorMessages;
	 }
	 else {
		 return 1;
	 }
  }
  
  // Handles user registration by inserting user data into the database.
  // Parameters:
  // - $uname (string): The username provided by the user.
  // - $umail (string): The user's email address.
  // - $upass (string): The user's password.
  public function register($uname, $umail, $upass){
	  $hashedPassword = password_hash($upass, PASSWORD_DEFAULT); // Hashes the password for security.
	  $uname = $this->cleanInput($uname); // Cleans the username input.
	  
	  // Inserts user data into the database.
	  $stmt_registerUser = $this->pdo->prepare('INSERT INTO table_users (u_name, u_password, u_email, u_role_fk) VALUES (:name, :pw, :email, 1)');
	  $stmt_registerUser->bindParam(":name", $uname, PDO::PARAM_STR);
	  $stmt_registerUser->bindParam(":pw", $hashedPassword, PDO::PARAM_STR);
	  $stmt_registerUser->bindParam(":email", $umail, PDO::PARAM_STR);
	  
	  if($stmt_registerUser->execute()){
		  header("Location: login.php?newuser=1"); // Redirect to login page on success.
	  }
	  else{
		  array_push($this->errorMessages, "Your info was input correctly,but something went wrong when saving to database, please be in touch with support!");
	  }
	  
  }
  
  // Handles user login by verifying credentials and starting a session.
  // Parameters:
  // - $unamemail (string): The username or email provided by the user.
  // - $upass (string): The user's password.
  // Returns:
  // - (array|string): Array of error messages if validation fails, or nothing if successful.
 public function login($unamemail, $upass){
	$this->errorState = 0;
	// Checks if the username or email exists in the database.
	$stmt_checkUsername = $this->pdo->prepare('SELECT * FROM table_users WHERE u_name = :uname OR u_email = :email');
	$stmt_checkUsername->bindParam(":uname", $unamemail, PDO::PARAM_STR);
	$stmt_checkUsername->bindParam(":email", $unamemail, PDO::PARAM_STR);
	$stmt_checkUsername->execute();

	if($stmt_checkUsername->rowCount() === 0){
		  array_push($this->errorMessages,"Username or email does not exist! ");
		  $this->errorState = 1;
	}

	$userData = $stmt_checkUsername->fetch();
	
	// Verifies the password.
	if(password_verify($upass, $userData['u_password'])){
		// Initializes user session variables on successful login.
		$_SESSION['user_id'] = $userData['u_id'];
		$_SESSION['user_name'] = $userData['u_name'];
		$_SESSION['user_mail'] = $userData['u_email'];
		$_SESSION['user_role'] = $userData['u_role_fk'];
		header("Location: home.php");
	}
	else{
		array_push($this->errorMessages,"Password is incorrect! ");
		return $this->errorMessages;
	}
 }

 // Checks if the user is logged in, otherwise redirects to the login page.
 // Returns:
 // - (bool): True if logged in, otherwise redirects to login page.
	public function checkLoginStatus(){
		if(isset($_SESSION['user_id'])){
			return true;
		}
		else{
			header("Location: login.php");
		}
	}
	
	// Checks if the user's role level meets or exceeds the specified value.
	// Parameters:
	// - $val (int): The minimum required role level.
	// Returns:
	// - (bool): True if the user's role level meets or exceeds the value, otherwise

  
  // Checks if the user's role level meets or exceeds the specified value.
  public function checkUserRole($val){
    $stmt_checkUserRoleLevel = $this->pdo->prepare('SELECT * FROM table_roles WHERE r_id = :rid');
    $stmt_checkUserRoleLevel->bindParam(":rid", $_SESSION['user_role'], PDO::PARAM_INT);
    $stmt_checkUserRoleLevel->execute();
    $result = $stmt_checkUserRoleLevel->fetch();

    if ($result['r_level'] >= $val) {
      return true;
    } else {
      return false;
    }
  }

  public function logout() {
    // Start the session if it hasn't been started already
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page or homepage
    header("Location: login.php");
    exit;
}

  
}

