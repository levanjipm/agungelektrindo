<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$id						= $_POST['id'];
	$sql_check	= "SELECT id FROM code_sample_delivery_order WHERE id = '$id'";
	$result_check	= $conn->query($sql_check);
	$check			= mysqli_num_rows($result_check);
	
	if(empty($_POST['id']) || $check == 0){
?>
<script>
	window.location.href='/agungelektrindo/inventory_department/sample_dashboard';
</script>
<?php
	}
	
	$sql					= "SELECT code_sample.id, customer.name, customer.address, customer.city
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample.id = '$id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$sample_id				= $row['id'];
	$customer_name			= $row['name'];
	$customer_address		= $row['address'];
	$customer_city			= $row['city'];
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	$guid 			= GUID();
?>
<head>
	<title>Validate sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Validate sample</p>
	<hr>
	<label>Customer data</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Send date</label>
	<form action='sample_send_input.php' method='POST' id='sample_form'>
	<input type='date' class='form-control' id='date' name='send_sample_date' required>
	<input type='hidden' class='form-control' name='code_sample_id' value='<?= $id ?>'>
	<input type='hidden' class='form-control' name='guid' value='<?= $guid ?>'>
	<br>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Send</th>
			</tr>
		</thead>
		<tbody>
<?php
	$validation				= TRUE;
	$sql					= "SELECT sample.id, sample.reference, itemlist.description, sample.quantity, sample.sent
								FROM sample 
								JOIN itemlist ON sample.reference = itemlist.reference
								WHERE sample.code_id = '$id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		
		$sample_id			= $row['id'];
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sent				= $row['sent'];
		
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '$reference'";
		$result_stock		= $conn->query($sql_stock);
		$stock				= $result_stock->fetch_assoc();
		
		$stock_level		= $stock['stock'];
		
		if($quantity < $stock_level){
			$vaildation		= FALSE;
		}
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity - $sent,0) ?></td>
				<td><input type='number' class='form-control' name='quantity[<?= $sample_id ?>]' id='quantity-<?= $sample_id ?>' max='<?= $quantity - $sent ?>' min='0'></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
	
<?php if($validation			== TRUE){ ?>
	<button type='submit' class='button_success_dark' id='submit_button'>Submit</button>
<?php } ?>
	</form>
</div>