<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Confirm purchasing return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchasing Return</h2>
	<p>Confirm return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
		</tr>
<?php
	$sql_code				= "SELECT code_purchase_return.id, code_purchase_return.submission_date,  supplier.name, supplier.address, supplier.city FROM code_purchase_return 
								JOIN supplier ON code_purchase_return.supplier_id = supplier.id
								WHERE code_purchase_return.isconfirm = '0'";
	$result_code 			= $conn->query($sql_code);
	while($code 			= $result_code->fetch_assoc()){
		$supplier_name		= $code['name'];
		$supplier_address	= $code['address'];
		$supplier_city		= $code['city'];
		$return_date		= $code['submission_date'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($return_date)) ?></td>
			<td><?= $supplier_name ?></td>
			<td><button type='button' class='button_success_dark' onclick='submit(<?= $code['id'] ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button></td>
		</tr>
<?php
	}
?>
	</table>
</div>
<form action='return_confirm_validation' method='POST' id='purchasing_return_form'>
	<input type='hidden' name='id' id='return_id'>
</form>
<script>
	function submit(n){
		$('#return_id').val(n);
		$('#purchasing_return_form').submit();
	}
</script>