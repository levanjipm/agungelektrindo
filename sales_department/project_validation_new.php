<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$customer_id	= $_POST['customer'];
	$start_project	= $_POST['start_project'];
	$name_project	= $_POST['name_project'];
	
	$sql_customer		= "SELECT * FROM customer WHERE id = '$customer_id'";
	$result_customer	= $conn->query($sql_customer);
	$customer			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	$customer_address	= $customer['address'];
	$customer_city		= $customer['city'];
	
	$taxing				= $_POST['taxing'];
	if($taxing == 1){
		$taxing_text	= "Taxable";
	} else {
		$taxing_text	= "Non - taxable";
	}
	
	$purchase_order		= mysqli_real_escape_string($conn,$_POST['purchase_order']);
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p style='font-family:museo'>Add new project</p>
	<hr>
	<form action='project_input_new' method='POST'>
		<h3 style='font-family:museo'>General data</h3>
		<label>Customer</label>
		<h4 style='font-family:museo'><?= $customer_name ?></h4>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		<input type='hidden' value='<?= $customer_id ?>' name='customer_id'>
		
		<label>Taxing</label>
		<p style='font-family:museo'><?= $taxing_text ?></p>
		<input type='hidden' value='<?= $taxing ?>' name='taxing'>
		
		<label>Purchase Order Number</label>
		<p><?= $purchase_order ?></p>
		<input type='hidden' value='<?= $purchase_order ?>' name='purchase_order'>
		
		<label>Project date</label>
		<p><?= date('d M Y',strtotime($start_project)) ?></p>
		<input type='hidden' value='<?= $start_project ?>' name='start_project'>
		
		<label>Project name</label>
		<p><?= $name_project ?></p>
		<input type='hidden' value='<?= mysqli_real_escape_string($conn,$name_project) ?>' name='name_project'>
		<button type='submit' class='button_success_dark'>Submit</button>
	</form>
</div>