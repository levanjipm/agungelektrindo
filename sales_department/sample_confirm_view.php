<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	$sample_id				= $_POST['id'];
	$sql_code 				= "SELECT * FROM code_sample WHERE id = 'sample_id'";
	$result_code 			= $conn->query($sql_code);
	$code 					= $result_code->fetch_assoc();
	$creator_id				= $code['created_by'];
	$customer_id			= $code['customer_id'];
	$sql_created 			= "SELECT name FROM users WHERE id = '$creator_id'";
	$result_created 		= $conn->query($sql_created);
	$created 				= $result_created->fetch_assoc();
		
	$sql_customer 			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
		
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
	
	$creator				= $created['name'];
	
	
?>
	<h3 style='font-family:museo'>General Data</h3>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql_sample				= "SELECT * FROM sample WHERE code_id = '$sample_id'";
	$result_sample			= $conn->query($sql_sample);
	while($sample			= $result_sample->fetch_assoc()){
		$reference			= mysqli_real_escape_string($conn,$sample['reference']);
		$quantity			= $sample['quantity'];
		
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '$reference'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$item_description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $quantity ?></td>
			<td><?= $item_description ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_danger_dark' onclick='cancel(<?= $sample_id ?>)'>Delete</button>
	<button type='button' class='button_success_dark' onclick='confirm(<?= $sample_id ?>)'>Confirm</button>