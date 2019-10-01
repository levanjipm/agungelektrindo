<?php
	include("../codes/connect.php");
	session_start();
	$project_delivery_order_id 		= $_GET['id'];
	
	$sql_project_delivery_order 	= "SELECT project_id,name,date FROM project_delivery_order WHERE id ='" . $project_delivery_order_id . "'";
	$result_project_delivery_order 	= $conn->query($sql_project_delivery_order);
	$project_delivery_order 		= $result_project_delivery_order->fetch_assoc();
	
	$project_id 					= $project_delivery_order['project_id'];
	$document 						= $project_delivery_order['name'];
	$date 							= $project_delivery_order['date'];
	
	$sql_project 					= "SELECT customer_id, project_name FROM code_project WHERE id = '" . $project_id . "'";
	$result_project 				= $conn->query($sql_project);
	$project 						= $result_project->fetch_assoc();
	
	$customer_id 					= $project['customer_id'];
	$project_name 					= $project['project_name'];

	$x = 1;
	$sql_project_item 				= "SELECT reference, quantity FROM project WHERE project_do_id = '" . $project_delivery_order_id . "'";
	$result_project_item 			= $conn->query($sql_project_item);
	while($project_item 			= $result_project_item->fetch_assoc()){
		$reference 					= $project_item['reference'];
		$quantity 					= $project_item['quantity'];
		
		$sql_stock 					= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_stock 				= $conn->query($sql_stock);
		$stock_row 					= $result_stock->fetch_assoc();
		$stock 						= $stock_row['stock'];
		if ($stock == NULL){ $x++;
		} else if($stock < $quantity){ $x++;
		} else { echo ('ok');}
	}
	if($x > 1){
		echo ('Error on inputing data, Cannot proceed');
	} else {
		$sql_project_item 		= "SELECT * FROM project WHERE project_do_id = '" . $project_delivery_order_id . "'";
		$result_project_item 	= $conn->query($sql_project_item);
		while($project_item 	= $result_project_item->fetch_assoc()){
			$reference 			= $project_item['reference'];
			$quantity 			= $project_item['quantity'];
			$sql_in 			= "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id ASC";
			$result_in 			= $conn->query($sql_in);
			while($in 			= $result_in ->fetch_assoc()){
				$in_id 			= $in['id'];
				$sisa 			= $in['sisa'];
				$pengurang 		= min($sisa,$quantity);
				$sql_update 	= "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$conn->query($sql_update);
				
				$sql_out 		= "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
								VALUES ('$date','$in_id	','$pengurang','$customer_id')";
				$result_out 	= $conn->query($sql_out);
				$quantity 		= $quantity - $pengurang;
				if ($quantity 	== 0){ break;}
			}
			$sql_stock 			= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
			$result_stock 		= $conn->query($sql_stock);
			$row_stock 			= $result_stock->fetch_assoc();
			$quantity 			= $project_item['quantity'];
			$initial_stock 		= $row_stock['stock'];
			$end_stock 			= $initial_stock - $quantity;

			$sql_stock_out 		= "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,customer_id,document)
								VALUES ('$date','$reference','OUT','$quantity','$end_stock','0','$customer_id','$document')";
			$conn->query($sql_stock_out);
		}
		
		$sql_updated 			= "UPDATE project_delivery_order SET isconfirm = '1', confirmed_by = '" . $_SESSION['user_id'] . "', 
								confirmed_date = CURDATE() WHERE id = '" . $project_delivery_order_id . "'";
		$conn->query($sql_updated);
	}
?>