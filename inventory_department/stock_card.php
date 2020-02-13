<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$sql_item 			= "SELECT reference,description FROM itemlist WHERE id = '" . $_GET['id'] . "'";
	$result_item 		= $conn->query($sql_item);
	$item 				= $result_item->fetch_assoc();
	$reference 			= $item['reference'];
	$description 		= $item['description'];
	
	$stock_id_array	= array();
	$sql_stock 		= "SELECT id FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 20";
	$result_stock 	= $conn->query($sql_stock);
	while($stock	= $result_stock->fetch_assoc()){
		array_push($stock_id_array, $stock['id']);
	};
	
	asort($stock_id_array);
?>
<head>
	<title><?= $description ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'><?= $reference ?></h2>
	<p><?= $description ?></p>
	<a href='check_stock' style='text-decoration:none'>
		<button type='button' class='button_danger_dark' title='Back'><i class='fa fa-long-arrow-left'></i></button>
	</a>
	<a href='stock_card_complete.php?id=<?= $_GET['id'] ?>'>
		<button type='button' class='button_default_dark' title='View complete stock card data'><i class="fa fa-list-alt" aria-hidden="true"></i></button>
	</a>
	<br>
	<br>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Customer/Supplier</th>
			<th>Document</th>
			<th>In</th>
			<th>Out</th>
			<th>Stock</th>
		</tr>
		<tbody id='stock_table_body'>
<?php	
	foreach($stock_id_array as $stock_id){
		$sql			= "SELECT * FROM stock WHERE id = '$stock_id'";
		$result			= $conn->query($sql);
		$stock			= $result->fetch_assoc();
		if($stock['transaction'] == 'IN'){
			if($stock['supplier_id'] == 0 && $stock['customer_id'] != 0){
				$sql_name 		= "SELECT name FROM customer WHERE id = '" . $stock['customer_id'] . "'";
			} else if($stock['supplier_id'] != 0 && $stock['customer_id'] == 0){
				$sql_name 		= "SELECT name FROM supplier WHERE id = '" . $stock['supplier_id'] . "'";
			} else {
				$sql_name 		= "";
			}
?>
			<tr>
				<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
				<td><?php
					if($sql_name == ""){
						echo ('Internal transaction');
					} else {
						$result_name 	= $conn->query($sql_name);
						$name 			= $result_name->fetch_assoc();
						echo $name['name'];
					}
				?></td>
				<td><?= $stock['document']; ?></td>
				<td><?= number_format($stock['quantity']) ?></td>
				<td></td>
				<td><?= number_format($stock['stock']) ?></td>
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
				<td><?= $stock['document']; ?></td>
				<td></td>
				<td><?= number_format($stock['quantity']) ?></td>
				<td><?= number_format($stock['stock']) ?></td>
			</tr>
<?php
		} else if($stock['transaction'] == 'FOU'){
?>
			<tr>
				<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
				<td></td>
				<td>Found Goods</td>
				<td><?= number_format($stock['quantity']) ?></td>
				<td></td>
				<td><?= number_format($stock['stock']) ?></td>
			</tr>
<?php
		} else if($stock['transaction'] == 'LOS'){
?>
			<tr>
				<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
				<td></td>
				<td>Lost Goods</td>
				<td></td>
				<td><?= number_format($stock['quantity']) ?></td>
				<td><?= number_format($stock['stock']) ?></td>
			</tr>
<?php
		}
		
		next($stock_id_array);
	}
?>
		</tbody>
	</table>
</div>