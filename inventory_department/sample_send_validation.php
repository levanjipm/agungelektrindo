<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id						= $_POST['id'];
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
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
<?php
	$sql					= "SELECT refe FROM sample WHERE code_id = '$id'":
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
?>
		
</div>