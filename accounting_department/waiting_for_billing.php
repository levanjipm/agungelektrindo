<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Waiting for billing</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p style='font-family:museo'>Waiting for billing</p>
	<div id='naming'></div>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Supplier</th>
			<th>Documents</th>
			<th>Value</th>
			<th></th>
		</tr>
<?php
	$i						= 0;
	$uninvoiced_value 		= 0;
	$sql_supplier			= "SELECT id, name FROM supplier ORDER BY name ASC";
	$result_supplier		= $conn->query($sql_supplier);
	while($supplier			= $result_supplier->fetch_assoc()){
		$total 				= 0;
		$supplier_id		= $supplier['id'];
		$supplier_name		= $supplier['name'];
		$sql 				= "SELECT * FROM code_goodreceipt WHERE isinvoiced = '0' AND supplier_id = '$supplier_id'";
		$result 			= $conn->query($sql);
		while($row			= $result->fetch_assoc()){
			$code_gr_id			= $row['id'];
			
			$document			= mysqli_num_rows($result);
			
			$sql_initial 		= "SELECT goodreceipt.quantity, purchaseorder.unitprice
									FROM goodreceipt JOIN purchaseorder ON purchaseorder.id = goodreceipt.received_id
									WHERE goodreceipt.gr_id = '$code_gr_id'";
			$result_initial 	= $conn->query($sql_initial);
			while($row_initial 	= $result_initial->fetch_assoc()){
				$quantity 		= $row_initial['quantity'];
				$price 			= $row_initial['unitprice'];
				$total 			+= $quantity * $price;
			}
		}
		
		$uninvoiced_value 	+= $total;
		if($total			!= 0){
?>
		<tr>
			<td><?= $supplier_name ?></td>
			<td><?= number_format($document,0) . ' pending bill(s)' ?></td>
			<td>Rp. <?= number_format($total,2) ?></td>
			<td><button type='button' class='button_success_dark' onclick='view_supplier(<?= $supplier_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button></td>
		</tr>
<?php
		}
	}
?>
	</table>
</div>
<form action='waiting_for_billing_supplier' id='billing_form' method='POST'>
	<input type='hidden' name='supplier_id' id='supplier'>
</form>
<script>
	function view_supplier(n){
		$('#supplier').val(n);
		$('#billing_form').submit();
	}
	
	$('#naming').text('Rp. ' + numeral(<?= $uninvoiced_value ?>).format('0,0.00'));
</script>