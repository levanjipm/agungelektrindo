<?php
	include('../codes/connect.php');
?>
	<table border='1'>
		<tr>
			<th></th>
			<th>Stock value</th>
			<th>Stock value sisa</th>
			<th>Opponent</th>
		</tr>
<?php
	$sql			= "SELECT * FROM stock_value_in WHERE reference = 'LC1D18Q7'";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$date		= $row['date'];
		$in_id		= $row['id'];
		$quantity	= $row['quantity'];
		$sisa		= $row['sisa'];
?>
		<tr>
			<td><?= $in_id ?></td>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $quantity ?></td>
			<td><?= $sisa ?></td>
			<td>Cv Agung</td>
		</tr>
<?php
		$sql_out	= "SELECT * FROM stock_value_out WHERE in_id = '$in_id'";
		$result_out	= $conn->query($sql_out);
		while($out	= $result_out->fetch_assoc()){
			$date_out		= $out['date'];
			$out_quantity	= $out['quantity'];
			$customer_id	= $out['customer_id'];
			
			$sql_customer		= "SELECT * FROM customer WHERE id = '$customer_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];
?>
		<tr>
			<td><?= $out['id'] ?></td>
			<td><?= date('d M Y',strtotime($date_out)) ?></td>
			<td></td>
			<td><?= $out_quantity ?></td>
			<td><?= $customer_name . ' - ' . $customer_id ?></td>
		</tr>
<?php
		}
	}
?>