<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Confirm purchase</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
	<p>Confirm purchase invoice</p>
	<hr>
<?php	
	if(empty($_POST['id'])){
?>
	<script>
		window.location.href="accounting";
	</script>
<?php
	} else {
		$invoice_id 		= $_POST['id'];
		$sql 				= "SELECT date, name,faktur,supplier_id FROM purchases WHERE id = '" . $invoice_id . "'";
		$result 			= $conn->query($sql);
		$row 				= $result->fetch_assoc();
		$invoice_name 		= $row['name'];
		
		$sql_supplier 		= "SELECT name, address, city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
		$supplier_address	= $supplier['address'];
		$supplier_city		= $supplier['city'];		
?>
		<label>Supplier</label>
		<p style='font-family:museo'><?= $supplier_name ?></p>
		<p style='font-family:museo'><?= $supplier_address ?></p>
		<p style='font-family:museo'><?= $supplier_city ?></p>
		
		<p>Invoice date: <?= date('d M Y',strtotime($row['date'])) ?></p>
		<p>Invoice name: <?= $row['name'] ?></p>
		<p>Tax document number: <?= $row['faktur'] ?></p>
		<form method="POST" action='confirm_invoice_input' id='input'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
		</form>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Price</th>
				
			</tr>
			<?php
				$total = 0;
				$sql_gr = "SELECT * FROM code_goodreceipt WHERE invoice_id = '" . $invoice_id . "'";
				$result_gr = $conn->query($sql_gr);
				while($gr = $result_gr->fetch_assoc()){
					$gr_id = $gr['id'];
					$sql = "SELECT * FROM goodreceipt WHERE gr_id = '" . $gr_id . "'";
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()){
						$received_id		= $row['received_id'];
						$quantity			= $row['quantity'];
						$billed_price		= $row['billed_price'];
						$total 				+= $quantity * $billed_price;
						
						$sql_received		= "SELECT reference FROM purchaseorder WHERE id = '$received_id'";
						$result_received	= $conn->query($sql_received);
						$received			= $result_received->fetch_assoc();
						
						$reference			= $received['reference'];
						
						$sql_item 			= "SELECT description FROM itemlist WHERE reference = '".  $received['reference'] . "'";
						$result_item 		= $conn->query($sql_item);
						$item 				= $result_item->fetch_assoc();
						
						$item_description	= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $item_description ?></td>
				<td><?= $quantity ?></td>
				<td>Rp. <?= number_format($billed_price,2) ?></td>
				<td>Rp. <?= number_format(($row['quantity'] * $row['billed_price']),2) ?></td>
			</tr>
<?php
					}
				}
?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><strong>Grand total</strong></td>
				<td>Rp. <?= number_format($total,2) ?></td>
		</table>
		<button type='button' class='button_danger_dark' id='delete_button'>Delete</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
<?php
	}
?>
<script>
	$('#confirm_button').click(function(){
		$.ajax({
			url:'confirm_purchase_input.php',
			data:{
				id: <?= $invoice_id ?>,
			},
			type: 'POST',
			success:function(response){
				window.location.href = 'confirm_purchase_dashboard';
			}
		})
	})
	$('#delete_button').click(function(){
		$.ajax({
			url:'delete_purchase_input.php',
			data:{
				id: <?= $invoice_id ?>,
			},
			type: 'POST',
			success:function(){
				window.location.href = 'confirm_purchase_dashboard';
			}
		})
	})
</script>