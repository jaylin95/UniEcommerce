<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
$mode = sanitize($_POST['mode']);
$edit_size = sanitize($_POST['edit_size']);
$edit_id = sanitize($_POST['edit_id']);
$basket_query = $db->query("SELECT * FROM basket WHERE id = '{$basket_id}'");
$result = mysqli_fetch_assoc($basket_query);
$items = json_decode($result['items'],true);
$updated_items = array();
$domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);

if($mode == 'remove'){
	foreach($items as $item){
		if($item['id'] == $edit_id && $item['size'] == $edit_size){
			$item['quantity'] = $item['quantity'] - 1;
		}
		if($item['quantity'] > 0){
			$updated_items[] = $item;
		}
	}
}

if($mode == 'add'){
	foreach($items as $item){
		if($item['id'] == $edit_id && $item['size'] == $edit_size){
			$item['quantity'] = $item['quantity'] + 1;
		}
		
			$updated_items[] = $item;
		
	}
}

if(!empty($updated_items)){
	$json_updated = json_encode($updated_items);
	$db->query("UPDATE basket SET items = '{$json_updated}' WHERE id = '{$basket_id}'");
	$_SESSION['success_flash'] = 'Your basket has been updated.';
}

if(empty($updated_items)){
	$db->query("DELETE FROM basket WHERE id ='{$basket_id}'");
	setcookie(BASKET_COOKIE,'',1,"/",$domain,false);
}

?>