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
			<th>Done</th>
		</tr>
<?php
	$sql = "SELECT isdone, description, quantity, done FROM service_sales_order
	WHERE so_id = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row['isdone'] == 1){
?>
		<tr class='success'>
<?php
		} else {
?>
		<tr>
<?php
		}
?>
			<td><?= $row['description']; ?></td>
			<td><?= $row['quantity']; ?></td>
			<td><?= $row['done']; ?></td>
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
	$sql = "SELECT id FROM service_sales_order WHERE so_id = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_do = "SELECT service_delivery_order.do_id, code_delivery_order.name, code_delivery_order.date
		FROM service_delivery_order
		JOIN code_delivery_order ON code_delivery_order.id = service_delivery_order.do_id
		WHERE service_delivery_order.service_sales_order_id = '" . $row['id'] . "'";
		$result_do = $conn->query($sql_do);
		while($do = $result_do->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($do['date'])) ?></td>
			<td><a href='do_archive.php?id=<?= $do['do_id'] ?>' style='color:#333'><?= $do['name']; ?></a></td>
		</tr>
<?php
		}
	}
?>