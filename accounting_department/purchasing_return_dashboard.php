<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Supplier name</th>
			<th>Document</th>
			<th></th>
		</tr>
<?php
	$sql_return 			= "SELECT code_purchase_return_sent.document, code_purchase_return.supplier_id, code_purchase_return_sent.id
								FROM code_purchase_return_sent 
								JOIN code_purchase_return ON code_purchase_return_sent.code_purchase_return_id = code_purchase_return.id
								WHERE code_purchase_return_sent.isconfirm = '1'";
	$result_return 			= $conn->query($sql_return);
	while($return 			= $result_return->fetch_assoc()){
		$return_id			= $return['id'];
		$document			= $return['document'];
		$supplier_id		= $return['supplier_id'];
		$sql_supplier		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
		$result_supplier	= $conn->query($sql_supplier);
		$supplier			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
?>
		<tr>
			<td><?= $supplier_name ?></td>
			<td><?= $document ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='submit(<?= $return_id ?>)'><i class='fa fa-long-arrow-right'></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<form action='purchasing_return_validation' id='purchase_return_form' method='POST'>
	<input type='hidden' name='id' id='return_id'>
</form>
<script>
	function submit(n){
		$('#return_id').val(n);
		$('#purchase_return_form').submit();
	}
</script>
</div>