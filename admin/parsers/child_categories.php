<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
$parentID = (int)$_POST['parentID'];

$childquery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
ob_start();
?>
	<option value=""></option>
	<?php while($child = mysqli_fetch_assoc($childquery)): ?>
		<option value="<?php echo $child['id'];?>"><?php echo $child['category'];?></option>
	<?php endwhile; ?>
<?php echo ob_get_clean();?>