<?php
	include('../codes/connect.php');
	
	$item_id		= $_POST['item_id'];
	$offset			= $_POST['offset'];
	
	$sql_item		= "SELECT reference FROM itemlist WHERE id = '$item_id'";
	$result_item	= $conn->query($sql_item);
	$item			= $result_item->fetch_assoc();
	
	$reference	 	= $item['reference'];
	
	$sql_stock 		= "SELECT * FROM stock WHERE reference = '" . $reference . "' ORDER BY id ASC LIMIT " . $offset;
	$result_stock 	= $conn->query($sql_stock);
	while($stock 	= $result_stock->fetch_assoc()){
		if($stock['transaction'] == 'IN'){
			if($stock['supplier_id'] == 0 && $stock['customer_id'] != 0){
				$sql_name = "SELECT name FROM customer WHERE id = '" . $stock['customer_id'] . "'";
			} else if($stock['supplier_id'] != 0 && $stock['customer_id'] == 0){
				$sql_name = "SELECT name FROM supplier WHERE id = '" . $stock['supplier_id'] . "'";
			} else {
				$sql_name = "";
			}
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td><?php
						if($sql_name == ""){
							echo ('Internal transaction');
						} else {
							$result_name = $conn->query($sql_name);
							$name = $result_name->fetch_assoc();
							echo $name['name'];
						}
					?></td>
					<td><?= $stock['document']; ?></td>
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
					<td><?= $stock['document']; ?></td>
					<td></td>
					<td><?= $stock['quantity'] ?></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		} else if($stock['transaction'] == 'FOU'){
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td></td>
					<td>Found Goods</td>
					<td><?= $stock['quantity'] ?></td>
					<td></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		} else if($stock['transaction'] == 'LOS'){
?>
				<tr>
					<td><?= date('d M Y',strtotime($stock['date'])) ?></td>
					<td></td>
					<td>Lost Goods</td>
					<td></td>
					<td><?= $stock['quantity'] ?></td>
					<td><?= $stock['stock'] ?></td>
				</tr>
<?php
		}		
	}
?>