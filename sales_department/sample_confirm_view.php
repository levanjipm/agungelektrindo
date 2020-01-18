<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	
	$sample_id				= $_POST['id'];
	
	$sql_code 				= "SELECT users.name as creator, customer.name, customer.address, customer.city 
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								JOIN users ON code_sample.created_by = users.id
								WHERE code_sample.id = '$sample_id'";
	$result_code 			= $conn->query($sql_code);
	$code 					= $result_code->fetch_assoc();
		
	$customer_name			= $code['name'];
	$customer_address		= $code['address'];
	$customer_city			= $code['city'];
	
	$creator				= $code['creator'];
?>
	<h3 style='font-family:bebasneue'>Send sample</h3>
	<hr>
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