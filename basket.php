<?php

require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
$total = null;

if($basket_id != ''){
	$basket_query = $db->query("SELECT * FROM basket WHERE id = '{$basket_id}'");
	$result = mysqli_fetch_assoc($basket_query);
	$items = json_decode($result['items'],true);
	$i = 1;
	$sub_total = 0;
	$item_count = 0;
}

?>

<div class ="row">
<div class="col-md-12">
		<h2 class="text-center">My Basket</h2><hr>
		<?php if($basket_id == ''): ?>
			<div class ="bg-danger">
				<p class="text-center">
					Basket is empty, add some items!
				</p>
			</div>
		<?php else: ?>
			<table class="table table-bordered table-condensed table-striped">
				<thead>
					<th>#</th>
					<th>Item</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Size</th>
					<th>Total</th>
				</thead>
				<tbody>
					<?php
					foreach($items as $item){
						$product_id = $item['id'];
						$product_query = $db->query("SELECT * FROM products WHERE id = '{$product_id}'");
						$product = mysqli_fetch_assoc($product_query);
						$size_array = explode(',',$product['sizes']);
						foreach($size_array as $size_string){
							$s = explode(':',$size_string);
							if($s[0] == $item['size']){
								$available = $s[1];
							}
						}
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $product['title'];?></td>
							<td><?php echo money($product['price']);?></td>
							<td>
								<button class="btn btn-xs btn-secondary" onclick="update_basket('remove','<?php echo $product['id'];?>', '<?php echo $item['size'];?>');">-</button>
								<?php echo $item['quantity'];?>
								<?php if($item['quantity'] < $available): ?>
									<button class="btn btn-xs btn-secondary" onclick="update_basket('add','<?php echo $product['id'];?>', '<?php echo $item['size'];?>');">+</button>
								<?php else: ?>
									<span class="text-danger">Maximum ammount reached, cannot add more.</span>
							<?php endif; ?>
							</td>
							<td><?php echo $item['size'];?></td>
							<td><?php echo money($item['quantity'] * $product['price']);?></td>
						</tr>
						<?php
						$i++;
						$item_count += $item['quantity'];
						$total += ($product['price'] * $item['quantity']);
					}

					$tax = TAXRATE * $sub_total;
					$tax = number_format($tax,2);
					$grand_total = $tax + $total;
					?>
				</tbody>
			</table>
			<table class="table table-bordered table-condensed text-right">
				<legend>Item(s) Totals</legend>
				<thead>
				<th>Total Items</th>
				<th>Sub Total</th>
				<th>Tax</th>
				<th>Grand Total</th>
			</thead>
				<tbody>
					<tr>
						<td><?php echo $item_count;?></td>
						<td><?php echo money($total);?></td>
						<td><?php echo money($tax);?></td>
						<td><?php echo money($grand_total);?></td>
					</tr>
				</tbody>
			</table>
			<!-- Button trigger modal -->
<button type="button" class="btn btn-primary text-right" data-toggle="modal" data-target="#exampleModal">
  Check Out <i class="fas fa-check"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="checkout_modal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutModalLabel">Shipping Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
		<?php endif; ?>
		</div>


</div>


<?php include 'includes/footer.php'; ?>