</div>
</div>

<footer class="text-center" id="footer">&copy; Copyright 2018 E-Commerce Coursework</footer>


</div>

<script>
	
function detailsmodal(id){
	var data = {"id" : id};
	jQuery.ajax({
		url: '/phpstuff/includes/detailsmodal.php',
		method : "post",
		data : data,
		success: function(data){
			jQuery('body').append(data);
			jQuery('#details-modal').modal('toggle');
		},
		error: function(){
			alert("Oops! Something went wrong!");
		}
	});

}

function update_basket(mode,edit_id,edit_size){
	var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
	jQuery.ajax({
		url : '/phpstuff/admin/parsers/update_basket.php',
		method : "post",
		data : data,
		success : function(){
			location.reload();},
		error: function(){
			alert("Error.");
		}
	});
}

function add_to_basket(){
	jQuery('#modal_errors').html("");
	var size = jQuery('#size').val();
	var quantity = jQuery('#quantity').val();
	var available = jQuery('#available').val();
	var error = '';
	var data = jQuery('#add_product_form').serialize();
	if(size == '' || quantity == '' || quantity == 0){
		error += '<p class="text-danger text-center">You must select a size and quantity.</p>';
		jQuery('#modal_errors').html(error);
		return;
	}else if(quantity > available){
		error += '<p class="text-danger text-center">There are only '+available+' available.</p>';
		jQuery('#modal_errors').html(error);
		return;
	}else{
		jQuery.ajax({
			url : '/phpstuff/admin/parsers/add_basket.php',
			method : 'post',
			data : data,
			success : function(){
				location.reload();
			},
				error : function(){
					alert("Error");
				}
		});
	}
}

</script>


	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>