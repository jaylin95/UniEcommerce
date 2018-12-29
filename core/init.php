<?php
$db = mysqli_connect('127.0.0.1','root','','database1');
if(mysqli_connect_errno()) {
	echo 'Database connection failed with following errors: '. mysqli_connect_error();
	die();
}

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/config.php';
require_once BASEURL.'helpers/helpers.php';

$basket_id = '';
if(isset($_COOKIE[BASKET_COOKIE])){
	$basket_id = sanitize($_COOKIE[BASKET_COOKIE]);
	
}

if(isset($_SESSION['SBUser'])){
	$user_id = $_SESSION['SBUser'];
	$query = $db->query("SELECT * FROM users WHERE id = '$user_id'");
	$user_data = mysqli_fetch_assoc($query);
	$fullname = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fullname[0];
	$user_data['last'] = $fullname[1];

}

if(isset($_SESSION['success_flash'])){
	echo '<div class="bg-success"><p class="text-center"></p>'.$_SESSION['success_flash'].'</div>';
	unset($_SESSION['success_flash']);
}

if(isset($_SESSION['error_flash'])){
	echo '<div class="bg-danger"><p class="text-center"></p>'.$_SESSION['error_flash'].'</div>';
	unset($_SESSION['error_flash']);
}


