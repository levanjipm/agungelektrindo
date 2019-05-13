<?php
	include('inventoryheader.php');
	if(empty($_POST['item_id'])){
		header('location:inventory.php');
	}
	$sql_item = "SELECT reference,description FROM itemlist WHERE id = '" . $_POST['item_id'] . "'";
	$result_item = $conn->query($sql_item);
	$item = $result_item->fetch_assoc();
	$reference = $item['reference'];
	$description = $item['description'];
?>
	<div class='main'>
		<h3><?= $reference ?></h3>
		<p><?= $description ?></p>
		<table class='table'>
			<tr>
				<th>Date</th>
				<th>Customer/Supplier</th>
				<th>In</th>
				<th>Out</th>
				<th>Stock</th>
			</tr>
<?php
	$sql_stock = "SELECT * FROM stock WHERE reference = '" . $reference . "' ORDER BY id ASC LIMIT 20";
	$result_stock = $conn->query($sql_stock);
	while($stock = $result_stock->fetch_assoc()){
		if($stock['transaction'] == 'IN'){
?>
			<tr>
				<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
				<td><?php
					$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $stock['supplier_id'] . "'";
					$result_supplier = $conn->query($sql_supplier);
					$supplier = $result_supplier->fetch_assoc();
					echo $supplier['name']; 
				?></td>
				<td><?= $stock['quantity'] ?></td>
				<td></td>
				<td><?= $stock['stock'] ?></td>
			</tr>
<?php
		} else if($stock['transaction'] == 'OUT'){
?>
			<tr>
				<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
				<td><?php
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $stock['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo $customer['name']; 
				?></td>
				<td></td>
				<td><?= $stock['quantity'] ?></td>
				<td><?= $stock['stock'] ?></td>
			</tr>
<?php
		}
	}
?>
	</table>