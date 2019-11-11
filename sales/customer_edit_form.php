<?php
	include('../codes/connect.php');
	$customer_id		= $_POST['customer_id'];
	$sql_customer		= "SELECT * FROM customer WHERE id = '$customer_id'";
	$result_customer	= $conn->query($sql_customer);
	$customer			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
	$customer_phone		= $customer['phone'];
	$customer_prefix	= $customer['prefix'];
	$cutomer_pic		= $customer['pic'];
?>
	<h2 style='font-family:bebasneue'>Edit customer data</h2>
	<input type='hidden' id='customer_id' value='<?= $customer_id ?>'>
	<label>Name</label>
	<input type='text' class='form-control' value='<?= $customer_name ?>' id='customer_name'>
	<label>Address</label>
	<textarea class='form-control' style='resize:none' id='customer_address'><?= $customer_address ?></textarea>
	<label>City</label>
	<input type='text' class='form-control' id='customer_city' value='<?= $customer_city ?>'>
	<label>Phone number</label>
	<input type='text' class='form-control' id='customer_phone' value='<?= $customer_phone ?>'>
	<br>
	<button type='button' class='button_success_dark' id='submit_change_button'>Submit</button>
	<script>
		$('#submit_change_button').click(function(){
			var customer_name		= $('#customer_name').val();
			var customer_address	= $('#customer_address').val();
			var customer_city		= $('#customer_city').val();
			var customer_phone		= $('#customer_phone').val();
			
			if(customer_name == '' || customer_address == '' || customer_city == '' || customer_phone == ''){
				alert('Please fill all the inputs');
			} else {
				$.ajax({
					url:'customer_edit.php',
					data:{
						customer_id			: <?= $customer_id ?>,
						customer_name		: customer_name,
						customer_address	: customer_address,	
						customer_city		: customer_city,
						customer_phone		: customer_phone,
					},
					type:'POST',
					beforeSend:function(){
						$('#submit_change_button').attr('disabled',true);
					},
					success:function(){
						location.reload();
					}
				});
			}
		});
	</script>