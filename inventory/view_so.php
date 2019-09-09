<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql_initial 		= "SELECT customer_id,name,note FROM code_salesorder WHERE id = '" . $id . "'";
	$result_initial 	= $conn->query($sql_initial);
	$initial 			= $result_initial->fetch_assoc();
	
	$note				= $initial['note'];
	
	if($initial['customer_id'] == 0){
		$sql_customer 		= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '" . $id . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['retail_name'];
		$customer_address	= $customer['retail_address'];
		$customer_city		= $customer['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '" . $initial['customer_id'] . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
		
?>
	<h3 style='font-family:bebasneue'><?= $initial['name'] ?></h4>
	<h4 style='font-family:bebasneue'><strong><?= $customer_name ?></strong></h4>
	<p><?= $customer_address ?></p>
	<p><?= $customer_city ?></p>
	<table class='table table-bordered'>
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
	<h4 style='font-family:bebasneue'>Note</h4>
	<p><?= $note ?></p>
	<h4 style='font-family:bebasneue'>Corresponding delivery order</h4>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
		</tr>
<?php
	$sql_do 		= "SELECT id,date,name FROM code_delivery_order WHERE so_id = '" . $id . "'";
	$result_do 		= $conn->query($sql_do);
	while($do 		= $result_do->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($do['date'])) ?></td>
			<td><a href='do_archive.php?id=<?= $do['id'] ?>' style='color:#333'><?= $do['name']; ?></a></td>
		</tr>
<?php
	}
?>