<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$item = array();
$item[] = array(
	'id' => $product_id,
	'size' => $size,
	'quantity' => $quantity,
);

$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
$product = mysqli_fetch_assoc($query);
$_SESSION['success_flash'] = $product['title']. ' added to basket.';

if($basket_id != ''){
	$basket_query = $db->query("SELECT * FROM basket WHERE id ='{$basket_id}'");
	$basket = mysqli_fetch_assoc($basket_query);var_dump($basket);
	$previous_items = json_decode($basket['items'],true);
	$item_match = 0;
	$new_items = array();
	foreach($previous_items as $p_item){
		if($item[0]['id'] ==$p_item['id'] && $item[0]['size'] == $p_item['size']){
			$p_item['quantity'] = $p_item['quantity'] + $item[0]['quantity'];
			if($p_item['quantity'] > $available){
				$p_item['quantity'] = $available;
			}
			$item_match = 1;
		}
		$new_items[] = $p_item;
	}
	if($item_match != 1){
		$new_items = array_merge($item,$previous_items);
	}
	$items_json = json_encode($new_items);
	$basket_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
	$db ->query("UPDATE basket SET items = '{$items_json}', expire_date = '{basket_expire}' WHERE id = '{$basket_id}'");
	setcookie(BASKET_COOKIE,'',1,"/",$domain,false);
	setcookie(BASKET_COOKIE,$basket_id,BASKET_COOKIE_EXPIRE,'/',$domain,false);

}else{
	$items_json = json_encode($item);
	$basket_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
	$db->query("INSERT INTO basket (items,expire_date) VALUES('{$items_json}','{$basket_expire}')");
	$basket_id = $db->insert_id;
	setcookie(BASKET_COOKIE,$basket_id,BASKET_COOKIE_EXPIRE,'/',$domain,false);
}
?>