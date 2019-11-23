<?php
	include('salesheader.php');
	ob_start();
	$do_name 	= $_POST['delivery_order_name'];
	$sql 		= "SELECT id,customer_id FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result 	= $conn->query($sql);
	$row 		= $result->fetch_assoc();
	
	if (mysqli_num_rows($result) > 0){
		$do_id 		= $row['id'];
		$customer_id	= $row['customer_id'];
		if($customer_id	== 0){
			$sql_so		= "SELECT retail_name FROM code_salesorder WHERE id = '" . $row['so_id'] . "'";
			$result_so	= $conn->query($sql_so);
			$so			= $result_so->fetch_assoc();
			
			$customer_name	= $so['retail_name'];
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
<div class="main">
	<h2 style='font-family:bebasneue'>Sales Return</h2>
	<p>Validate return</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer_name ?></h3>
	<label>Delivery Order</label>
	<p><?= $do_name ?></p>
	<label>Unique GUID</label>
	<p><?= $guid ?></p>
	<form method="POST" action="return_input.php" id="return_form">
		<input type='hidden' value='<?= $guid ?>' readonly name='guid'>
		<input type='hidden' value='<?= $do_id ?>' readonly name='delivery_order_id'>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Reference</th>
					<th>Sent quantity</th>
					<th>Return quantity</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql_item = "SELECT id,reference,quantity FROM delivery_order WHERE do_id = '" . $do_id . "'";
	$result_item = $conn->query($sql_item);
	if (mysqli_num_rows($result_item) > 0){
		while($row = $result_item->fetch_assoc()) {
			$item 				= $row['reference'];
			$sql_code_return 	= "SELECT id FROM code_sales_return WHERE do_id = '" . $do_id . "'";
			$result_code_return = $conn->query($sql_code_return);
			$code_return 		= $result_code_return->fetch_assoc();
			
			$sql_return 		= "SELECT quantity FROM sales_return WHERE delivery_order_id = '" . $row['id'] . "'";
			$result_return 		= $conn->query($sql_return);
			$return 			= $result_return->fetch_assoc();
			$quantity 			= $row['quantity'];
			
			$delivery_order		= $row['id'];
?>
					<tr>
						<td>
							<?= $item ?>
						</td>
						<td><?= $quantity - $return['quantity'] ?></td>
						<td>
							<input type="number" class="form-control" id='return_quantity-<?= $delivery_order ?>' name="return_quantity[<?= $delivery_order ?>]" max="<?= $quantity - $return['quantity'] ?>" min='0'>
						</td>
					</tr>
<?php
		};
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
			<option value='0'>Other reason (Please contact your administrator to tell the reason)</option>
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
			quantity	= $('#' + input_id).val();
			
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