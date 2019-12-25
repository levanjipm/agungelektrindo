<?php
	include('../codes/connect.php');
	$invoice_id			= $_POST['invoice_id'];
	$sql				= "SELECT * FROM purchases WHERE id = '$invoice_id'";
	$result				= $conn->query($sql);
	$invoice			= $result->fetch_assoc();
	
	$invoice_name		= $invoice['name'];
	$invoice_date		= $invoice['date'];
	$invoice_tax		= $invoice['faktur'];
	$invoice_value		= $invoice['value'];
	$invoice_status		= $invoice['isdone'];
?>
<label>Invoice data</label>
<p style='font-family:museo'><?= $invoice_name ?></p>
<p style='font-family:museo'><?= date('d M Y',strtotime($invoice_date)) ?></p>
<?php
	if($invoice_tax		!= ''){
?>
<p style='font-family:museo'><?= $invoice_tax ?></p>
<?php
	}
?>
<label>Invoice detail</label>
<?php
	$sql				= "SELECT * FROM code_goodreceipt WHERE invoice_id = '$invoice_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();	
	if(empty($row['project_id']) && empty($row['so_id'])){
?>
	<p style='font-family:museo'>Invoice detail is not available</p>
<?php
	} else if(!empty($row['project_id'])){
		$project_id					= $row['project_id'];
		$sql						= "SELECT * FROM code_project WHERE id = '$project_id'";
		$result						= $conn->query($sql);
		$project					= $result->fetch_assoc();
		$project_name				= $project['project_name'];
		$project_description		= $project['description'];
		$po_number					= $project['po_number'];
?>
	<label>Project name</label>
	<p style='font-family:museo'><?= $project_name ?></p>
	
	<label>Project description</label>
	<p style='font-family:museo'><?= $project_description ?></p>
	
	<label>Purchase order number</label>
	<p style='font-family:museo'><?= $po_number ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<td>Value</td>
			<td>Rp. <?= number_format($invoice_value,2) ?></td>
		</tr>
		<tr>
			<td>Delivery fee</td>
			<td>Rp. <?= number_format($invoice_delivery,2) ?></td>
		</tr>
	</table>
<?php
	} else {
		$sales_order_id			= $row['so_id'];
		$sql_sales_order		= "SELECT type FROM code_salesorder WHERE id = '$sales_order_id'";
		$result_sales_order		= $conn->query($sql_sales_order);
		$sales_order			= $result_sales_order->fetch_assoc();
		
		$type					= $sales_order['type'];
		if($type				== 'GOOD'){
			$sql_do				= "SELECT name, date FROM code_delivery_order WHERE id = '$delivery_order_id'";
			$result_do			= $conn->query($sql_do);
			$do					= $result_do->fetch_assoc();
			
			$do_name			= $do['name'];
			$do_date			= $do['date'];
?>
	<label>Delivery order</label>
	<p style='font-family:museo'><?= $do_name ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($do_date)) ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total price</th>
		</tr>
<?php
			$delivery_order_value	= 0;
			$sql_detail				= "SELECT delivery_order.reference, delivery_order.quantity, itemlist.description, delivery_order.billed_price
										FROM delivery_order 
										JOIN itemlist ON delivery_order.reference = itemlist.reference
										WHERE delivery_order.do_id = '$delivery_order_id'";
			$result_detail			= $conn->query($sql_detail);
			while($detail			= $result_detail->fetch_assoc()){
				$reference			= $detail['reference'];
				$description		= $detail['description'];
				$quantity			= $detail['quantity'];
				$price				= $detail['billed_price'];
				$item_price			= $price * $quantity;
				$delivery_order_value	+= $item_price;
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
			<td>Rp. <?= number_format($price,2) ?></td>
			<td>Rp. <?= number_format($item_price,2) ?></td>
		</tr>
<?php
			}
?>
		<tr>
			<td colspan='2'></td>
			<td colspan='2'>Total</td>
			<td>Rp. <?= number_format($delivery_order_value,2) ?></td>
		</tr>
	</table>
<?php
		} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Service description</th>
			<th>Quantity</th>
			<th>Unit price</th>
			<th>Total price</th>
		</tr>
<?php
			$service_value			= 0;
			$sql_service			= "SELECT service_delivery_order.quantity, service_sales_order.description, service_sales_order.unit, service_sales_order.unitprice
										FROM service_delivery_order
										JOIN service_sales_order ON service_delivery_order.service_sales_order_id = service_sales_order.id
										WHERE service_delivery_order.do_id = '$delivery_order_id'";
			$result_service			= $conn->query($sql_service);
			while($service			= $result_service->fetch_assoc()){
				$service_name		= $service['description'];
				$service_quantity	= $service['quantity'];
				$service_unit		= $service['unit'];
				$service_price		= $service['unitprice'];
				$price				= $service_price * $service_quantity;
				$service_value		+= $price;
?>
		<tr>
			<td><?= $service_name ?></td>
			<td><?= number_format($service_quantity,2) . ' ' . $service_unit ?></td>
			<td>Rp. <?= number_format($service_price,2) ?></td>
			<td>Rp. <?= number_format($price,2) ?></td>
		</tr>
<?php
			}
?>
		<tr>
			<td colspan='2'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($service_value,2) ?></td>
		</tr>
	</table>
<?php
		}
	}
	
	if($invoice_status			!= 1){
?>
	<form action='invoice_set_done_dashboard' method='POST'>
		<input type='hidden' value='<?= $invoice_id ?>' name='id'>
		<button type='submit' class='button_default_dark'>Set as done</button>
	</form>
<?php
	}
?>