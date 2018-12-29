<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpstuff/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($_GET['delete'])){
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted = 1  WHERE id = '$id'");
	header('Location: products.php');
}

$dbpath = '';
if (isset($_GET['add']) || isset($_GET['edit'])){
$brandquery = $db->query("SELECT * FROM brand ORDER BY brand");
$parentquery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):'');
$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
$sizes = rtrim($sizes,',');
$saved_img = '';

if(isset($_GET['edit'])){
	$edit_id =(int)$_GET['edit'];
	$product_results = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
	$product = mysqli_fetch_assoc($product_results);
	if(isset($_GET['delete_image'])){
		$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];
		unlink($image_url);
		$db->query("UPDATE products SET image = '' WHERE id = '$edit_id");
		header('Location: products.php?edit=.$edit_id');
	}
	$category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):$product['categories']);
	$title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['title']);
	$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['brand']);
	$parent_query = $db->query("SELECT * FROM categories WHERE id = '$category'");
	$parent_result = mysqli_fetch_assoc($parent_query);
	$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parent_result['parent']);
	$price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$product['price']);
	$list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$product['list_price']);
	$description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$product['description']);
	$sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes']))?sanitize($_POST['sizes']):$product['sizes']);
	$sizes = rtrim($sizes,',');
	$saved_img = (($product['image'] != '')?$product['image']:'');
	$dbpath = $saved_img;
}
if (!empty($sizes)){
		$sizeString = sanitize($sizes);
		$sizeString = rtrim($sizeString,',');
		$sizesarray = explode(',',$sizeString);
		$sizearray = array();
		$quantityarray = array();
		foreach($sizesarray as $ss){
			$s = explode(':',$ss);
			$sizearray[] = $s[0];
			$quantityarray[] = $s[1];
		}
	}else{$sizesarray = array();}

if ($_POST) {
	
	$errors = array();
	

	$required = array('title', 'brand', 'price', 'parent' , 'child', 'sizes');
	foreach($required as $field){
		if($_POST[$field] == ''){
			$errors[] = 'All fields with an asterisk are required.';
			break;
		}
	}
	if(!empty($_FILES)){
		$photo = $_FILES['photo'];
		$name = $photo['name'];
		$namearray = explode('.', $name);
		$filename = $namearray[0];
		$fileext = $namearray[1];
		$mime = explode('/', $photo['type']);
		$mimetype = $mime[0];
		$mimeext = $mime[1];
		$tmplocation = $photo['tmp_name'];
		$filesize = $photo['size'];
		$allowed = array('png', 'jpg', 'jpeg', 'gif');
		$uploadname = md5(microtime()).'.'.$fileext;
		$uploadlocation = BASEURL.'imgs/products/'.$uploadname;
		$dbpath ='/phpstuff/imgs/products/'.$uploadname;
		if ($mimetype != 'image') {
			$errors[] = 'The file must be an image.';
		}
		if (!in_array($fileext, $allowed)){
			$errors[] = 'Image must be a png, jpg, jpeg or gif';
		}
		if ($filesize > 20000000) {
			$errors[] = 'File size too large. Please upload image under 20MB';
		}
	}

	if(!empty($errors)){
		echo display_errors($errors);
	}else{
		if(!empty($_FILES)){
		move_uploaded_file($tmplocation, $uploadlocation);
	}
		$insertsql = "INSERT INTO products (`title`, `price`, `list_price`, `brand`, `category`,`sizes`,`description`, `image`) VALUES ('$title','$price','$list_price', '$brand', '$categories', '$sizes','$description', '$dbpath')";
		if(isset($_GET['edit'])){
			$insertsql = "UPDATE products SET title = '$title', price = '$price', list_price = '$list_price', brand = '$brand', category = '$categories', sizes = '$sizes', image = '$dbpath', description = '$description' WHERE id='$edit_id";
		}
		$db->query($insertsql);
		header('Location: products.php');
	}
}
?>
	<h2 class="text-center"><?php echo ((isset($_GET['edit']))?'Edit':'Add');?> product</h2><hr>
	<form action="products.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data">
		<div class="row">
		<div class="form-group col-md-3">
			<label for="title">Title*:</label>
			<input type="text" name="title" class="form-control" id="title" value="<?php echo $title;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="brand">Brand*:</label>
			<select class="form-control" id="brand" name="brand">
				<option value=""<?php echo (($brand == '')?' selected':'');?>></option>
				<?php while($brand2 = mysqli_fetch_assoc($brandquery)): ?>
					<option value="<?php echo $brand2['id']; ?>"<?php echo (($brand == $brand2['id'])?' selected':'');?>><?php echo $brand2['brand'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="parent">Parent Category*:</label>
			<select class="form-control" id="parent" name="parent">
				<option value=""<?php echo (($parent == '')?' selected':'');?>></option>
				<?php while($parent2 = mysqli_fetch_assoc($parentquery)): ?>
				<option value="<?php echo $parent2['id'];?>"<?php echo (($parent == $parent2['id'])?' selected':'');?>><?php echo $parent2['category'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="child">Child Category*:</label>
			<select class="form-control" id="child" name="child">
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="price">Price*:</label>
			<input type="text" class="form-control" id="price" name="price" 
			value="<?php echo $price;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="list_price">List Price:</label>
			<input type="text" class="form-control" id="list_price" name="list_price" 
			value="<?php echo $list_price;?>">
		</div>
		<div class="form-group col-md-3">
			<label>Quantity & Sizes*:</label>
			<button class="btn btn-primary form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantity & Sizes</button>
		</div>
		<div class="form-group col-md-3">
			<label for="sizes">Quantity & Sizes Preview</label>
			<input type="text" class="form-control" name="sizes" id="sizes" value="<?php echo $sizes;?>" readonly>
		</div>
		<div class="form-group col-md-6">
			<label for="photo">Photo Product:</label>
			<?php if($saved_img != ''): ?>
				<div class="saved_img"><img src="<?php echo $saved_img;?>" alt="saved image"/><br>
					<a href="products.php?delete_image=1&edit=<?php echo $edit_id;?>" class="text-danger">Delete Image</a>
				</div>
			<?php else:?>
			<input type="file" name="photo" id="photo" class="form-control">
		<?php endif; ?>
		</div>
		<div class="form-group col-md-6">
			<label for="description">Description:</label>
			<textarea id="description" name="description" class="form-control" rows="6"><?php echo $description;?>
			</textarea>
			<div class ="text-right">
			<a href="products.php" class="btn btn-secondary">Cancel</a>
			<input type="submit" value="<?php echo ((isset($_GET['edit']))?'Update':'Add Product');?>" class="btn btn-success">
		</div><div class="clearfix"></div>
		</div>
	</div>
	</form>
	
	<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sizesModal">Quantity & Sizes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="container-fluid">
        <?php for($i=1;$i <= 12;$i++): ?>
        	<div class="row">
        	<div class="form-group col-md-4">
        		<label for="size<?php echo $i;?>">Size:</label>
        		<input class="form-control" type="text" name="size<?php echo$i;?>" id="size<?php echo$i;?>"  
        		value="<?php echo ((!empty($sizearray[$i-1]))?$sizearray[$i-1]:'');?>">
        	</div>
        	<div class="form-group col-md-2">
        		<label for="quantity<?php echo $i;?>">Quantity:</label>
        		<input class ="form-control" type="number" name="quantity<?php echo$i;?>" id="quantity<?php echo$i;?>"  
        		value="<?php echo ((!empty($quantityarray[$i-1]))?$quantityarray[$i-1]:'');?>" min="0">
        	</div>
    </div>
        <?php endfor; ?>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>

<?php }else{

$sql = "SELECT * FROM products WHERE deleted = 0";
$presults = $db->query($sql);
if (isset($_GET['featured'])){
	$id = (int)$_GET['id'];
	$featured = (int)$_GET['featured'];
	$featuredsql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
	$db->query($featuredsql);
	header('Location: products.php');
}

?>
<h2 class="text-center">Products</h2>
<hr>
<table class="table table-bordered table-condensed table-stripd">
	<thead>
		<th></th>
		<th>Product</th>
		<th>Price</th>
		<th>Category</th>
		<th>Featured</th>
		<th>Sold</th>
	</thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($presults)): 
			$childID = $product['categories'];
			$categorysql = "SELECT * FROM categories WHERE id = '$childID'";
			$result = $db->query($categorysql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$parentsql = "SELECT * FROM categories WHERE id = '$parentID'";
			$presult = $db->query($parentsql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].' - '.$child['category'];
		?>
			<tr>
				<td>
					<a href="products.php?edit=<?php echo $product['id'];?>" class="btn btn-secondary"><i class="fas fa-pencil-alt"></i></a>
					<a href="products.php?delete=<?php echo $product['id'];?>" class="btn btn-secondary"><i class="fas fa-trash-alt"></i></a>
				</td>
				<td><?php echo $product['title'];?></td>
				<td><?php echo money($product['price']);?></td>
				<td><?php echo $category;?></td>
				<td><a href="products.php?featured=<?php echo (($product['featured'] == 0)?'1':'0');?>&id=<?php echo $product['id'];?>" class="btn btn-secondary">
					<i class="fas fa-<?php echo (($product['featured'] == 1)?'minus':'plus');?>"></i>
				</a>
				&nbsp <?php echo (($product['featured'] == 1)?'Featured Product':'');?>
			</td>
				<td>0</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<a href="products.php?add=1" class="btn btn-success text-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>



<?php } include 'includes/footer.php';?>

