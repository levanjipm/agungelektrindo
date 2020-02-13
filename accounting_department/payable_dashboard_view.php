<?php
	include('../codes/connect.php');
	$supplier_id			= (int) $_GET['id'];
	
	$sql_supplier 			= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier 		= $conn->query($sql_supplier);
	$supplier 				= $result_supplier->fetch_assoc();

	$supplier_name			= $supplier['name'];
	$supplier_address		= $supplier['address'];
	$supplier_city			= $supplier['city'];
	
	$sql_invoice 			= "SELECT SUM(value) AS total FROM purchases WHERE supplier_id = '$supplier_id'";
	$result_invoice 		= $conn->query($sql_invoice);
	$invoice 				= $result_invoice->fetch_assoc();
	
	$total_purchase			= $invoice['total'];
?>
	<h2 style='font-family:bebasneue'><?= $supplier_name ?></h2>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<br>
	
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Invoice number</th>
			<th>Remaining value</th>
		</tr>
<?php
	$total_debt				= 0;
	$sql_invoice_detail 	= "SELECT id, date, name, value FROM purchases
								WHERE supplier_id = '$supplier_id' AND isdone = '0' ORDER BY date ASC";
	$result_invoice_detail 	= $conn->query($sql_invoice_detail);
	while($invoice_detail 	= $result_invoice_detail->fetch_assoc()){
		$purchase_id		= $invoice_detail['id'];
		$purchase_value		= $invoice_detail['value'];
		$purchase_name		= $invoice_detail['name'];
		
		$sql_payable		= "SELECT SUM(payable.value) as paid FROM payable WHERE purchase_id = '$purchase_id'";
		$result_payable		= $conn->query($sql_payable);
		$payable			= $result_payable->fetch_assoc();
		
		$paid				= $payable['paid'];
		
		$unpaid				= $purchase_value - $paid;
		$total_debt			+= $unpaid;
?>
			<tr>
				<td><?= date('d M Y',strtotime($invoice_detail['date'])) ?></td>
				<td><?= $invoice_detail['name'] ?></td>
				<td>Rp. <?= number_format($unpaid,2) ?></td>
			</tr>
<?php
	}
?>
	</table>
	<a href='supplier_view.php?id=<?= $supplier_id ?>' style='text-decoration:none'>
		<button type='button' class='button_success_dark'><i class='fa fa-eye'></i></button>
	</a>
</div>