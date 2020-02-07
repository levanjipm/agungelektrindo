<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include ($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	ob_start();
	$do_name 			= $_POST['delivery_order_name'];
	$sql 				= "SELECT id,customer_id FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result 			= $conn->query($sql);
	$row 				= $result->fetch_assoc();
	
	if (mysqli_num_rows($result) > 0){
		$do_id 			= $row['id'];
		$customer_id	= $row['customer_id'];
		if($customer_id	== 0){
			$sql_so		= "SELECT retail_name FROM code_salesorder WHERE id = '" . $row['so_id'] . "'";
			$result_so	= $conn->query($sql_so);
			$so			= $result_so->fetch_assoc();
			
			$customer_name		= $so['retail_name'];
		} else {
			$sql_customer		= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];
		}
		
		function GUID()
		{
			if (function_exists('com_create_guid') === true)
			{
				return trim(com_create_guid(), '{}');
			}

			return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
		}
		
		$guid	= GUID();
?>
<head>
	<title>Validate sales return</title>
</head>
<script>
	$('#return_side').click();
	$('#return_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Return</h2>
	<p style='font-family:museo'>Validate return</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer_name ?></h3>
	<label>Delivery Order</label>
	<p style='font-family:museo'><?= $do_name ?></p>
	
	<label>GUID</label>
	<p style='font-family:museo'><?= $guid ?></p>
	<form action='return_input' method="POST" id="return_form">
		<input type='hidden' value='<?= $guid ?>' readonly name='guid'>
		<input type='hidden' value='<?= $do_id ?>' readonly name='delivery_order_id'>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Reference</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Return quantity</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql	 				= "SELECT id,reference,quantity FROM delivery_order WHERE do_id = '$do_id'";
	$result		 			= $conn->query($sql);
	while($row 				= $result->fetch_assoc()) {
		$reference			= $row['reference'];
		$quantity			= $row['quantity'];
		
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
		
		$delivery_order		= $row['id'];
?>
				<tr>
					<td><?= $reference ?></td>
					<td><?= $item_description ?></td>
					<td><?= $quantity ?></td>
					<td><input type="number" class="form-control" id='return_quantity-<?= $delivery_order ?>' name="return_quantity[<?= $delivery_order ?>]" max="<?= $quantity ?>" min='0'></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
		<br>
		<label>Reason of return</label>
		<select class='form-control' name="reason" onchange='other()' id='reason'>
		<?php
			$sql_reason = "SELECT * FROM reason";
			$result_reason = $conn->query($sql_reason);
			while($row_reason = $result_reason->fetch_assoc()){
		?>
				<option value='<?= $row_reason['id'] ?>'><?= $row_reason['name'] ?></option>
		<?php
			}
		?>
			<option value='0'>Other reason</option>
		</select>
		<br>
		<button type='button' class="button_default_dark" id='button_submit'>Proceed</button>
	</form>
</div>
<script>
	$('#button_submit').click(function(){
		var check_blank_input 	= 0;
		var exceed				= false;
		var quantity;
		
		$('input[id^="return_quantity"]').each(function(){
			var input_id	= $(this).attr('id');
			var maximum		= $('#' + input_id).attr('max');
			var quantity	= $('#' + input_id).val();
			
			if(quantity > maximum){
				exceed = true;
			}
			
			if($(this).val() == ''){
				$(this).val(0);
			}
			
			check_blank_input += parseInt(quantity);
		})
		
		if(check_blank_input == 0){
			alert('Please insert correct value!');
			return false;
		} else if(exceed == true){
			alert('Exceed maximum value');
			return false;
		} else {
			$('#return_form').submit();
		}
	})
</script>
<?php
	}
?>