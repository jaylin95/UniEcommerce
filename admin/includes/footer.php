</div>
</div>

<footer class="text-center" id="footer">&copy; Copyright 2018 E-Commerce Coursework</footer>


</div>

	<script>
		function updateSizes(){
			var sizeString = '';
			for(var i=1;i<=12;i++){
				if(jQuery('#size'+i).val()!= ''){
					sizeString += jQuery('#size' +i).val()+':'+jQuery('#quantity'+i).val()+',';
				}
			}
			jQuery('#sizes').val(sizeString);
		}


		
			function get_child_options(){
			var parentID = jQuery('#parent').val();
			jQuery.ajax({
				url: '/phpstuff/admin/parsers/child_categories.php',
				type: 'POST',
				data: {parentID : parentID},
				success: function(data){
					jQuery('#child').html(data);
				},
				error: function(){alert("Oops! An error has occured.")},
			});
		}
		jQuery('select[name="parent"]').change(get_child_options);
	}
	</script>



	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>