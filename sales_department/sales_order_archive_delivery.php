<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_GET['delivery_order_id'];
	$sql					= "SELECT code_delivery_order.name, code_delivery_order.date, code_salesorder.type
								FROM code_delivery_order 
								JOIN code_salesorder ON code_delivery_order.so_id = code_salesorder.id
								WHERE code_delivery_order.id = '$delivery_order_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$delivery_order_date	= $row['date'];
	$delivery_order_name	= $row['name'];
	$type					= $row['type'];
	
?>
	<label>Delivery order</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
	<p style='font-family:museo'><?= $delivery_order_name ?></p>
<?php
	if($type == 'GOOD'){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	
	$sql					= "SELECT delivery_order.reference, delivery_order.quantity, itemlist.description
								FROM delivery_order
								JOIN itemlist ON delivery_order.reference = itemlist.reference
								WHERE delivery_order.do_id = '$delivery_order_id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		$reference				= $row['reference'];
		$quantity				= $row['quantity'];	
		$description			= $row['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
		</tr>
<?php
	}
?>
	</table>
<?php
	} else {
?>
		<tr>
			<th>Service name</th>
			<th>Quantity</th>
		</tr>
<?php
		$sql				= "SELECT service_delivery_order.quantity, service_sales_order.description, service_sales_order.unit
								FROM service_delivery_order JOIN service_sales_order ON service_delivery_order.service_sales_order_id = service_sales_order.id
								WHERE service_delivery_order.do_id = '$delivery_order_id'";
		$result				= $conn->query($sql);
		while($row			= $result->fetch_assoc()){
			$service		= $row['description'];
			$quantity		= $row['quantity'];
			$unit			= $row['unit'];
?>
		<tr>
			<td><?= $service ?></td>
			<td><?= number_format($quantity,2) . ' ' . $unit ?></td>
		</tr>
<?php
		}
?>
	</table>
<?php
	}
?>