<?php
	include('codes/connect.php');
	$sql_preliminary = "SELECT DISTINCT(reference) AS reference FROM stock ORDER BY id DESC";
	$result_preliminary = $conn->query($sql_preliminary);
?>
	<table>
		<tr>
			<td>Reference</td>
			<td>Stock Inventory</td>
			<td>Stock Accounting</td>
		</tr>
<?php
	while($prem = $result_preliminary->fetch_assoc()){
		$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $prem['reference'] . "' ORDER BY id DESC LIMIT 1";
		$result_stock = $conn->query($sql_stock);
		$stock = $result_stock->fetch_assoc();
		
		$sql_value_in = "SELECT id,quantity FROM stock_value_in WHERE reference = '" . $prem['reference'] . "'";
		$result_value_in = $conn->query($sql_value_in);
		while($value_in = $result_value_in->fetch_assoc()){
			$sql_out = "SELECT SUM(quantity) AS quantity FROM stock_value_out WHERE in_id = '" . $value_in['id'] . "'";
			$result_out = $conn->query($sql_out);
			$out = $result_out->fetch_assoc();
			
		
		
?>
		<tr>
			<td><?= $value['quantity_in'] ?></td>
			<td><?= $value['quantity_out'] ?></td>
		</tr>
<?php
	}