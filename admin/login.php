<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$errors = array();

?>

<div id="login-form">
	<div>
		
	<?php
		if($_POST){
			if(empty($_POST['email']) || empty($_POST['password'])){
				$errors[] = 'You must provide an email and password.';
			}

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'Please enter a valid email address.';
			}

			if(strlen($password) < 6){
				$errors[] = 'Password must be at least 6 characters';
			}

			$query = $db->query("SELECT * FROM users WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			$user_count = mysqli_num_rows($query); 
			if($user_count == 0){
				$errors[] = 'User does not exist.';
			}

			if(!password_verify($password, $user['password'])){
				$errors[] = 'Wrong password, please try again.';
			}

			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				$user_id = $user['id'];
				login($user_id);
			}
		}
	?>

	</div>
	
	

	</div>
	<h2 class="text-center">Login</h2><hr>
	<form action="login.php" method="post">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" name="email" id="email" class="form-control" value="<?php echo $email;?>">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?php echo $password;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/phpstuff/index.php" alt="home">Visit Site</p>
</div>


<?php include 'includes/footer.php'; ?>