<?php
	include('../codes/connect.php');
	$delivery_order_id		= $_GET['id'];
	
	$sql					= "SELECT code_delivery_order.name, code_delivery_order.date, customer.name as customer_name, customer.address, customer.city
								FROM code_delivery_order 
								JOIN customer ON code_delivery_order.customer_id = customer.id
								WHERE code_delivery_order.id = '$delivery_order_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	
	$delivery_order_name	= $row['name'];
	$delivery_order_date	= $row['date'];
	$customer_name			= $row['customer_name'];
	$customer_address		= $row['address'];
	$customer_city			= $row['city'];
?>
<label>Customer</label>
<p style='font-family:museo'><?= $customer_name ?></p>
<p style='font-family:museo'><?= $customer_address ?></p>
<p style='font-family:museo'><?= $customer_city ?></p>

<label>Delivery order</label>
<p style='font-family:museo'><?= $delivery_order_name ?></p>
<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
<?php
	$sql 				= "SELECT delivery_order.reference, delivery_order.quantity, itemlist.description
							FROM delivery_order
							JOIN itemlist ON delivery_order.reference = itemlist.reference
							WHERE delivery_order.do_id = '$delivery_order_id'";
	$result 			= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>No detail available</p>
<?php
	} else {
?>
<table class='table table-bordered' style='text-align:center'>
	<thead>
		<tr>
			<th style='text-align:center'>Referensi</th>
			<th style='text-align:center'>Deskripsi</th>
			<th style='text-align:center'>Quantity</th>
		</tr>
	</thead>
	<tbody>
<?php
	while($row 			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$description 	= $row['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
		</tr>
<?php
	}
?>
	</tbody>
</table>
<?php
	}
?>