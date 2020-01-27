<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include ($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Sales return</title>
</head>
<script>
	$('#return_side').click();
	$('#return_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Create return</p>
	<hr>
	<form method="POST" action="return_validation" id='sales_return_form'>
		<label>Insert the delivery order to be return</label>
		<input type="text" class="form-control" name="delivery_order_name" id='delivery_order_name' required>
		<br>
		<button type='button' class="button_default_dark" id='submit_sales_return_button'>Proceed</button>
	</form>
</div>

<script>
	$('#submit_sales_return_button').click(function(){
		$.ajax({
			url:'sales_return_search.php',
			data:{
				delivery_order_name: $('#delivery_order_name').val()
			},
			success:function(response){
				if(response == 0){
					alert('Please insert a valid delivery order');
					return false;
				} else if(response == 1){
					$('#sales_return_form').submit();
				}
			},
			type:'POST',
		})
	});
</script>