<?php
	include('accountingheader.php');
?>
<style>
	.alert_wrapper{
		position:absolute;
		top:20px;
		left:50%;
	}
	.alert{
		position:relative;
	}
</style>
	<div class='main'>
		<div class='alert_wrapper'>
			<div class='alert alert-success' id='success_update_alert' style='display:none'>
				<strong>Success</strong> confirming invoice.
			</div>
			<div class='alert alert-warning' id='failed_update_alert' style='display:none'>
				<strong>Failed</strong> confirming invoice.
			</div>
		</div>
		<h2 style='font-family:bebasneue'>Purchase Invoice</h2>
		<p>Confirm purchase invoice</p>
		<hr>
<?php	
	if(empty($_POST['id'])){
		header('confirm_invoice_dashboard.php');
	} else {
		$invoice_id = $_POST['id'];
		$sql = "SELECT name,faktur,supplier_id FROM purchases WHERE id = '" . $invoice_id . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$invoice_name = $row['name'];
		
		$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier = $conn->query($sql_supplier);
		$supplier = $result_supplier->fetch_assoc();
		
?>
		<h3 style='font-family:bebasneue'><?= $supplier['name'] ?></h3>
		<p>Invoice name: <?= $row['name'] ?></p>
		<p>Tax document number: <?= $row['faktur'] ?></p>
		<form method="POST" action='confirm_invoice_input.php' id='input'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
		</form>
		<table class='table'>
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
						$sql_received = "SELECT purchaseorder.billed_price, purchaseorder_received.reference FROM purchaseorder_received 
						JOIN purchaseorder ON purchaseorder.id = purchaseorder_received.id
						WHERE purchaseorder_received.id = '" . $row['received_id'] . "'";
						$result_received = $conn->query($sql_received);
						$received = $result_received->fetch_assoc();
						$total = $total + $row['quantity'] * $received['billed_price'];
?>
			<tr>
				<td><?= $received['reference']; ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '".  $received['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $row['quantity'] ?></td>
				<td>Rp. <?= number_format($received['billed_price'],2) ?></td>
				<td>Rp. <?= number_format(($row['quantity'] * $received['billed_price']),2) ?></td>
			</tr>
<?php
					}
				}
?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td><h4 style='font-family:bebasneue'>Grand total</h4></td>
				<td>Rp. <?= number_format($total,2) ?></td>
		</table>
		<button type='button' class='btn btn-default' id='confirm_button'>Confirm</button>
<?php
	}
?>
<script>
	$('#confirm_button').click(function(){
		$.ajax({
			url:'confirm_purchases_input.php',
			data:{
				id: <?= $invoice_id ?>,
			},
			type: 'POST',
			success:function(response){
				if(response == 0){
					window.location.href = 'confirm_purchases_dashboard.php';
				} else if(response == 1){
					$('#failed_update_alert').fadeIn();
					setTimeout(function(){
						$('#failed_update_alert').fadeOut();
					},1000);
				}
			}
		})
	})
</script>