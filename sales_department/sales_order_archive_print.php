<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$sales_order_id			= $_POST['id'];
	
	$sql					= "SELECT * FROM code_salesorder WHERE id = '$sales_order_id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$type					= $row['type'];
	$sales_order_name		= $row['name'];
	$po_number				= $row['po_number'];
	$taxing					= $row['taxing'];
	$creator				= $row['created_by'];
	
	$sql_create				= "SELECT name FROM users WHERE id = '$creator'";
	$result_create			= $conn->query($sql_create);
	$create					= $result_create->fetch_assoc();
	
	$creator_name			= $create['name'];
	
	if($taxing				== 1){
		$taxing_text		= 'Taxable';
	} else {
		$taxing_text		= 'Non-taxable';
	}
	
	$customer_id			= $row['customer_id'];
	if($customer_id			== NULL){
		$customer_name		= $row['retail_name'];
		$customer_address	= $row['retail_address'];
		$customer_city		= $row['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
?>
<head>
	<title><?= $sales_order_name . ' ' . $customer_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales order archive</h2>
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name	?></p>
	<p style='font-family:museo'><?= $customer_address	?></p>	
	<p style='font-family:museo'><?= $customer_city	?></p>

	<label>Sales order name</label>
	<p style='font-family:museo'><?= $sales_order_name ?></p>
	
	<label>Purchase order name</label>
	<p style='font-family:museo'><?= $po_number ?></p>
	
	<label>Taxing</label>
	<p style='font-family:museo'><?= $taxing_text ?></p>
	
	<label>Created by</label>
	<p style='font-family:museo'><?= $creator_name ?></p>
<?php
	switch($type){
		case 'GOOD':
?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Price list</th>
				<th>Discount</th>
				<th>Price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
<?php
			$total_sales_order		= 0;
			$sql					= "SELECT * FROM sales_order WHERE so_id = '$sales_order_id'";
			$result					= $conn->query($sql);
			while($row				= $result->fetch_assoc()){
				$reference			= $row['reference'];
				$quantity			= $row['quantity'];
				$price_list			= $row['price_list'];
				$discount			= $row['discount'];
				$price				= $row['price'];
				$total_price		= $price * $quantity;
				
				$total_sales_order	+= $total_price;
				
				$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
				$result_item		= $conn->query($sql_item);
				$item				= $result_item->fetch_assoc();
					
				$description		= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $quantity ?></td>
				<td>Rp. <?= number_format($price_list,2) ?></td>
				<td><?= $discount ?></td>
				<td>Rp. <?= number_format($price,2) ?></td>
				<td>Rp. <?= number_format($total_price,2) ?></td>
			</tr>
<?php
			}
?>
		<tbody>
		<tfoot>
			<tr>
				<td colspan='4'></td>
				<td colspan='2'>Total</td>
				<td>Rp. <?= number_format($total_sales_order,2) ?></td>
			</tr>
		</tfoot>
	</table>
	
	<label>Delivery history</label>
<?php
	$sql = "SELECT * FROM code_delivery_order WHERE so_id = '$sales_order_id'";
	$result	 = $conn->query($sql);
	$count	 = mysqli_num_rows($result);
	
		if($count > 0){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
		</tr>
<?php
			while($row = $result->fetch_assoc()){
				$date	= $row['date'];
				$name	= $row['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $name ?></td>
		</tr>
<?php
			}
?>
	</table>
<?php
		} else {
?>	
	<p style='font-family:museo'>There is no delivery nistory data available</p>
<?php
		}
	}
?>