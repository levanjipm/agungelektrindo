<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql_awal = "SELECT name FROM code_salesorder WHERE id = '" . $id . "'";
	$result_awal = $conn->query($sql_awal);
	$awal = $result_awal->fetch_assoc();
?>
	<h4><?= $awal['name'] ?></h4>
	<table class='table table-hover'>
		<tr>
			<th>Reference</th>
			<th>Quantity</th>
			<th>Sent</th>
		</tr>
<?php
	$sql = "SELECT sales_order.reference, sales_order.quantity, sales_order.sent_quantity, sales_order.status 
	FROM sales_order
	WHERE sales_order.so_id = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row['status'] == 1){
?>
		<tr class='success'>
<?php
		} else {
?>
		<tr>
<?php
		}
?>
			<td><?= $row['reference']; ?></td>
			<td><?= $row['quantity']; ?></td>
			<td><?= $row['sent_quantity']; ?></td>
		</tr>
<?php
	}
?>
	</table>
	<h4>Corresponding delivery order</h4>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Name</th>
		</tr>
<?php
	$sql_do = "SELECT id,date,name FROM code_delivery_order WHERE so_id = '" . $id . "'";
	$result_do = $conn->query($sql_do);
	while($do = $result_do->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($do['date'])) ?></td>
			<td><a href='do_archive.php?id=<?= $do['id'] ?>' style='color:#333'><?= $do['name']; ?></a></td>
		</tr>
<?php
	}
?>