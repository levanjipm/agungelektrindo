<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$date 		= $_POST['date'];
	$nilai 		= 1;
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	
	foreach($reference_array as $reference){
		$key				= key($reference_array);
		$quantity			= $quantity_array[$key];
		$sql_check 			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC LIMIT 1";
		$result_check 		= $conn->query($sql_check);
		if(mysqli_num_rows($result_check)){
			$check 			= $result_check->fetch_assoc();
			$stock 			= $check['stock'];
			if($stock < $quantity){
?>
		<script>
			window.history.back();
		</script>
<?php
			}
		} else {
?>
		<script>
			window.history.back();
		</script>
<?php
		}
		next($reference_array);
	}
	
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	
	$project_id 		= $_POST['project_id'];
	$sql 				= "SELECT * FROM code_project WHERE id = '" . $project_id . "'";
	$result 			= $conn->query($sql);
	$row 				= $result->fetch_assoc();
	
	$project_name		= $row['project_name'];
	$project_description	= $row['description'];
		
	$sql_customer 		= "SELECT name, address, city FROM customer WHERE id = '" . $row['customer_id'] . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project delivery order</h2>
	<p style='font-family:museo'>Create project delivery order</p>
	<hr>
	<label>Project</label>
	<p style='font-family:museo'><?= $project_name ?></p>
	<p style='font-family:museo'><?= $project_description ?></p>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<hr>
	<form action='project_delivery_order_create_input' method='POST' id='project_form'>
		<input type='hidden' value='<?= $project_id ?>' readonly name='projects'>
		<input type='hidden' value='<?= $date ?>' readonly name='date'>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
	foreach($reference_array as $reference){
		$key			= key($reference_array);
		$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item 	= $conn->query($sql_item);
		$item 			= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
		
		$quantity			= $quantity_array[$key];
?>
			<tr>
				<td><?= $reference ?>
					<input type='hidden' value='<?= mysqli_real_escape_string($conn,$reference) ?>' name='reference[<?= $key ?>]'>
				</td>
				<td><?= $item_description ?></td>
				<td><?= $quantity ?>
					<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $key ?>]'>
				</td>
			</tr>
<?php
		next($reference_array);
	}
?>
		</table>
		<hr>
		<button type='button' class='button_success_dark' id='submit_project'>Submit</button>
	</form>
</div>
<script>
	$('#submit_project').click(function(){
		$('#project_form').submit();
	});
</script>
