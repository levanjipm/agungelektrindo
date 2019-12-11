<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Purchase return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th></th>
		</tr>
<?php
	$sql_return					= "SELECT DISTINCT(purchase_return.code_id) as id FROM purchase_return 
									JOIN code_purchase_return ON purchase_return.code_id = code_purchase_return.id
									WHERE purchase_return.isdone = '0' AND code_purchase_return.isconfirm = '1'";
	$result_return				= $conn->query($sql_return);
	while($return				= $result_return->fetch_assoc()){
		$return_id				= $return['id'];
		$sql_code 				= "SELECT code_purchase_return.id, code_purchase_return.submission_date, supplier.name 
									FROM code_purchase_return 
									JOIN supplier ON supplier.id = code_purchase_return.supplier_id
									WHERE code_purchase_return.id = '$return_id'";
		$result_code 			= $conn->query($sql_code);
		$code 					= $result_code->fetch_assoc();
		$return_id				= $code['id'];
		$submission_date		= $code['submission_date'];
		$supplier_name			= $code['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($submission_date)) ?></td>
			<td><?= $supplier_name ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='submit(<?= $return_id ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<form id='purchasing_return_form' method='POST' action='purchasing_return_validation'>
	<input type='hidden' name='id' id='return_id'>
</form>
<script>
	function submit(n){
		$('#return_id').val(n);
		$('#purchasing_return_form').submit();
	}
</script>