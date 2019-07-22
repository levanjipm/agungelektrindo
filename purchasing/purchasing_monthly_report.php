<?php
	include('../codes/connect.php');
	$supplier_id = $_POST['supplier'];
	$year = $_POST['year'];
	
	$sql_supplier = "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier = $conn->query($sql_supplier);
	$supplier = $result_supplier->fetch_assoc();	
?>
	<input type='hidden' value='<?= $supplier_id ?>' id='supplier_hidden'>
	<input type='hidden' value='<?= $year ?>' id='year_hidden'>
	<h2 style='font-family:bebasneue'><?= $supplier['name'] ?></h2>
	<p><?= $supplier['address'] ?></p>
	<p><?= $supplier['city'] ?></p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<td>Month</td>
			<td>Year</td>
			<td>Value</td>
		</tr>
<?php
	for($i = 1; $i <= 12; $i++){	
		$sql_purchase = "SELECT SUM(value) AS monthly_purchase FROM purchases WHERE supplier_id = '$supplier_id' AND YEAR(date) = '$year' AND MONTH(date) = '$i'";
		$result_purchase = $conn->query($sql_purchase);
		$purchase = $result_purchase->fetch_assoc();
?>
		<tr>
			<td><?= date('F', mktime(0,0,0,$i+1,0,$year)) ?></td>
			<td><?= $year ?></td>
			<td>Rp. <?= number_format($purchase['monthly_purchase'],2) ?></td>
		</tr>
<?php
	}
?>
	</table>