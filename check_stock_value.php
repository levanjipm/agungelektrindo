<?php
	include('codes/connect.php');
	$sql = "SELECT * FROM stock_value_in ORDER BY reference ASC, date ASC";
?>
	<table border="1" style='text-align:center'>
		<tr>
			<td>ID</td>
			<td>Date</td>
			<td>Reference</td>
			<td>Supplier</td>
			<td>Customer</td>
			<td>In</td>
			<td>Sisa</td>
			<td>Out</td>
			<td>Price</td>
		</tr>
<?php
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['id'] ?> - IN</td>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['reference'] ?></td>
<?php
	if($row['customer_id'] == 0 && $row['supplier_id'] == 0){
?>
			<td colspan='2'>Stock Awal</td>
<?php
	} else if($row['customer_id'] != 0){
		$sql_customer = "SELECT name FROM customer WHERE id = '29'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
?>
			<td></td>
			<td><?= $customer['name'] ?></td>
<?php
	} else if($row['supplier_id'] != 0){
		$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier = $conn->query($sql_supplier);
		$supplier = $result_supplier->fetch_assoc();
?>
			<td><?= $supplier['name'] ?></td>
			<td></td>
<?php
	}
?>
			<td><?= $row['quantity'] ?></td>
			<td><?= $row['sisa'] ?></td>
			<td></td>
			<td><?= number_format($row['price'],2) ?></td>
		</tr>
<?php
		$sql_out = "SELECT * FROM stock_value_out WHERE in_id = '" . $row['id'] . "'";
		$result_out = $conn->query($sql_out);
		while($out = $result_out->fetch_assoc()){
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $out['customer_id'] . "'";
			$result_customer = $conn->query($sql_customer);
			$customer = $result_customer->fetch_assoc();
?>
		<tr>
			<td><?= $out['id'] ?> - OUT</td>
			<td><?= $out['date'] ?></td>
			<td></td>
			<td></td>
			<td><?= $customer['name'] ?></td>
			<td></td>
			<td></td>
			<td><?= $out['quantity']; ?></td>
			<td></td>
		</tr>
<?php
		}
	}
?>