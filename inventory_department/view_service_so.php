<?php
	include('../codes/connect.php');
	$id				= $_POST['id'];
	$sql_initial 	= "SELECT name,note,customer_id FROM code_salesorder WHERE id = '" . $id . "'";
	$result_initial	= $conn->query($sql_initial);
	$initial		= $result_initial->fetch_assoc();
	
	$note			= $initial['note'];
	
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
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<table class='table table-bordered'>
		<tr>
			<th>Service name</th>
			<th>Quantity</th>
			<th>Unit</th>
			<th>Done</th>
		</tr>
<?php
	$sql 		= "SELECT isdone, description, quantity, unit, done FROM service_sales_order WHERE so_id = '" . $id . "'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
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
			<td><?= $row['unit']; ?></td>
			<td><?= $row['done']; ?></td>
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
	$sql 			= "SELECT id FROM service_sales_order WHERE so_id = '" . $id . "'";
	$result 		= $conn->query($sql);
	while($row 		= $result->fetch_assoc()){
		$sql_do 	= "SELECT service_delivery_order.do_id, code_delivery_order.name, code_delivery_order.date
						FROM service_delivery_order
						JOIN code_delivery_order ON code_delivery_order.id = service_delivery_order.do_id
						WHERE service_delivery_order.service_sales_order_id = '" . $row['id'] . "'";
		$result_do 	= $conn->query($sql_do);
		while($do 	= $result_do->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($do['date'])) ?></td>
			<td><a href='do_archive.php?id=<?= $do['do_id'] ?>' style='color:#333'><?= $do['name']; ?></a></td>
		</tr>
<?php
		}
	}
?>
	</table>	
	<form method='POST' action='delivery_order_service_validation'>
		<input type='hidden' value='<?= $id ?>' name='id'>
		<button type='submit' class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button>		
	</form>
	