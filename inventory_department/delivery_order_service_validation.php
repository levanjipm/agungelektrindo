<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id 		= $_POST['id'];
	$sql 		= "SELECT * FROM code_salesorder WHERE id = '" . $id . "'";
	$result 	= $conn->query($sql);
	if(mysqli_num_rows($result) == 0 || empty($_POST['id'])){
?>
	<script>
		window.location.href='/agungelektrindo/codes/logout.php';
	</script>
<?php
	} else {
		$row 				= $result->fetch_assoc();
		$customer_id 		= $row['customer_id'];
		$so_name 			= $row['name'];
		$taxing 			= $row['taxing'];
		$po_number 			= $row['po_number'];
		
		$sql_customer 		= "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		function GUID()
		{
			if (function_exists('com_create_guid') === true)
			{
				return trim(com_create_guid(), '{}');
			}

			return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
		}
		
		$guid = GUID();
?>
<head>
	<title>Create service delivery order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'><?= $so_name ?></h2>
	<h4 style='font-family:bebasneue'><?= $customer['name'] ?></h4>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<hr>
	<form action='delivery_order_service_input' method='POST' id='do_service_form'>
		<label>Date</label>
		<input type='date' class='form-control' style='max-width:300px' name='service_date_send' id='service_date_send'>
		<br>
		<table class='table table-hover'>
			<tr>
				<td>Description</td>
				<td>Quantity</td>
				<td>Done</td>
			</tr>
			<input type='hidden' value='<?= $id ?>' name='id' readonly>
			<input type='hidden' value='<?= $guid ?>' name='guid' readonly>
<?php
		$sql_detail 			= "SELECT id, quantity, done, description FROM service_sales_order WHERE so_id = '" . $id . "'";
		$result_detail 			= $conn->query($sql_detail);
		while($detail 			= $result_detail->fetch_assoc()){
			$sales_order_id		= $detail['id'];
			$quantity			= $detail['quantity'];
			$done_quantity		= $detail['done'];
			$item				= $detail['description'];
			
			$quantity_max[$sales_order_id] = $quantity - $done_quantity;
?>
		<tr>
			<td><?= $item ?></td>
			<td><?= $quantity ?></td>
			<td><input type='number' class='form-control' name='quantity[<?= $sales_order_id ?>]' id='quantity<?= $sales_order_id ?>'></td>
		</tr>
<?php
	}
?>
		</form>
	</table>
	<button type='button' class='button_default_dark' id='service_send_button'>Send</button>
</div>
<script>
	quantity_array = <?= json_encode($quantity_max) ?>;
	function check_quantity(){
		var check_result = true;
		$('input[id^="quantity"]').each(function(){
			var key = $(this).attr('id').substr(-1);
			if($(this).val() > quantity_array[key]){
				alert('Cannot exceed quantity ordered');
				check_result = false;
			}
		})
		return check_result;
	}
	$('#service_send_button').click(function(){
		check_result = check_quantity();
		if($('#service_date_send').val() == ''){
			alert('Please insert valid date');
			$('#service_date_send').focus();
			return false;
		} else if(check_result == true){
			$('#do_service_form').submit();
		}
	});
</script>
<?php
	}
?>