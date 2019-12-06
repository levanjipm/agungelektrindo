<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confrim delivery order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p style='font-family:museo'>Confirm delivery order</p>
	<hr>
	<div class='row'>
<?php
	$sql = "SELECT * FROM code_delivery_order WHERE isdelete = '0' AND sent = '0' AND company = 'AE'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do = $results->fetch_assoc()){
			$sql_sales_order 		= "SELECT type FROM code_salesorder WHERE id = '" . $row_do['so_id'] . "'";
			$result_sales_order 	= $conn->query($sql_sales_order);
			$sales_order 			= $result_sales_order ->fetch_assoc();
			$type 					= $sales_order['type'];
			
			$project_id 			= $row_do['project_id'];
			$customer_id 			= $row_do['customer_id'];
			if($customer_id != 0){
				$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
				$result_customer 	= $conn->query($sql_customer);
				$row_customer 		= $result_customer->fetch_assoc();
				$customer_name 		= $row_customer['name'];
			} else {
				$sql 				= "SELECT code_salesorder.retail_address, code_salesorder.retail_name, code_salesorder.retail_phone, code_salesorder.retail_phone
									FROM code_salesorder
									JOIN code_delivery_order ON code_salesorder.id = code_delivery_order.so_id
									WHERE code_delivery_order.id = '" . $row_do['id'] . "'";
				$result 			= $conn->query($sql);
				$customer 			= $result->fetch_assoc();
				$customer_name 		= $customer['retail_name'];
			}
?>
		<div class="col-sm-2 col-xs-3">
			<h1 style='font-size:4em;text-align:center'><i class="fa fa-file-text-o" aria-hidden="true"></i></h1>
			<br>
			<p style="text-align:center"><?= $row_do['name'];?></p>
			<p style="text-align:center"><b><?= $customer_name?></b></p>	
			<p style="text-align:center">
				<button class='button_success_dark' onclick='view_delivery_order(<?= $row_do['id'] ?>)'><i class="fa fa-check" aria-hidden="true"></i></button>
			</p>
		</div>
<?php
		}
?>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_delivery_order(n){
		$.ajax({
			url:'delivery_order_confirm_view.php',
			data:{
				delivery_order_id:n
			},
			type:'POST',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn(300);
			}
		})
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_box').html('');
		$('.full_screen_wrapper').fadeOut(300);
	});
</script>
<?php } else { ?>
			<div class="col-xs-12" style="text-align:center">
<?php echo ('There are no delivery order need to be approved'); ?>
			</div>
<?php } ?>
	</div>
</div>