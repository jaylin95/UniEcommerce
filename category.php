<?php 
require_once 'core/init.php';
include 'includes/head.php'; 
include 'includes/navigation.php';
include 'includes/headerfull.php';
include 'includes/leftsidebar.php';

if(isset($_GET['cat'])){
	$cat_id = sanitize($_GET['cat']);
}else{
	$cat_id = '';
}

$sql = "SELECT * FROM products WHERE categories = '$cat_id'";
$product_query = $db->query($sql);
$category = get_category($cat_id);
?>

	<!-- main content -->
		<div class="col-md-8">
			<h2 class="text-center"><?php echo $category['parent']. '-' . $category['child'];?></h2>
			<?php while($product = mysqli_fetch_assoc($product_query)) : ?>
			<div class="row">
				<div class="col-md-3">
					<h4><?php echo $product['title']; ?></h4>
					<img src="<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" />
					<p class="list-price text-danger">List Price <s>£<?php echo $product['list_price']; ?></s></p>
					<p class="price">Our Price: £<?php echo $product['price']; ?></p>
					<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['id']; ?>)">Details</button>
				</div>
			</div>
			<?php endwhile; ?>
		</div>

	<?php
		include 'includes/rightsidebar.php';
		include 'includes/footer.php';
	?>