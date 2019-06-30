<html>
<?php
	$i = 1;
	include('codes/connect.php');
	$sql_in = "SELECT * FROM stock_value_in ORDER BY date ASC";
	$result_in = $conn->query($sql_in);
?>
	<table>
		<tr>
			<td>No</td>
			<td>Date</td>
			<td>Reference</td>
			<td>Quantity</td>
			<td>Price</td>
		</tr>
<?php
	while($in = $result_in->fetch_assoc()){
?>
		<tr>
			<td><?= $i ?></td>
			<td><?= date('d M Y',strtotime($in['date'])) ?></td>
			<td><?= $in['reference'] ?></td>
			<td><?= $in['quantity'] ?></td>
			<td><?= $in['price'] ?></td>
			<td><?= number_format(($in['price'] * $in['quantity']),2) ?></td>
		</tr>
<?php
	$i++;
	}
?>
	</table>