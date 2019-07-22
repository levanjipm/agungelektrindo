<?php
	include('../codes/connect.php');
	$supplier_id = $_POST['supplier'];
	$year = $_POST['year'];
	
	$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();	
?>
	<h2 style='font-family:bebasneue'><?= $supplier['name'] ?></h2>
	<p><?= $supplier['address'] ?></p>
	<p><?= $supplier['city'] ?></p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<td>Date</td>
			<td>Invoice name</td>
			<td>Value</td>
		</tr>
<?php
	$sql_purchase = "SELECT * FROM purchases WHERE supplier_id = '$supplier_id' AND YEAR(date) = '$year'";
	$result_purchase = $conn->query($sql_purchase);
	while($purchase = $result_purchase->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($purchase['date'])); ?></td>
			<td><?= $purchase['name']; ?></td>
			<td>Rp. <?= number_format($purchase['value'],2) ?></td>
		</tr>
<?php
	}
?>
	</table>