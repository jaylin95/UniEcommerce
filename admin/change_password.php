<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();

?>


<div id="login-form">
	<div>
		
	<?php
		if($_POST){
			if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = 'You must fill out all fields.';
			}

			if(strlen($password) < 6){
				$errors[] = 'Password must be at least 6 characters';
			}

			if($password != $confirm){
				$errors[] = 'Please make sure new password and confirm password are matching.';
			}


			if(!password_verify($old_password, $hashed)){
				$errors[] = 'Wrong password, please try again.';
			}

			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				$db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
				$_SESSION['success_flash'] = 'Your password has been changed';
				header('Location: index.php');
			}
		}
	?>

	</div>
	
	

	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="post">
		<div class="form-group">
			<label for="old_password">Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?php echo $old_password;?>">
		</div>
		<div class="form-group">
			<label for="password">New Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?php echo $password;?>">
		</div>
		<div class="form-group">
			<label for="confirm">Confirm Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?php echo $confirm;?>">
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-secondary">Cancel</a>
			<input type="submit" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/phpstuff/index.php" alt="home">Visit Site</p>
</div>


<?php include 'includes/footer.php'; ?>