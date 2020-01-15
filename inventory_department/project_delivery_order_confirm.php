<?php
	include('../codes/connect.php');
	session_start();
	
	$delivery_order_id		= $_POST['delivery_order_id'];
	$validation				= true;
	
	$sql_project			= "SELECT name, project_id, date FROM project_delivery_order WHERE id = '$delivery_order_id'";
	$result_project			= $conn->query($sql_project);
	$project				= $result_project->fetch_assoc();
	
	$date					= $project['date'];
	
	$project_id				= $project['project_id'];
	$delivery_order_name	= mysqli_real_escape_string($conn,$project['name']);
	
	$sql_code_project		= "SELECT customer_id FROM code_project WHERE id = '$project_id'";
	$result_code_project	= $conn->query($sql_code_project);
	$code_project			= $result_code_project->fetch_assoc();
	
	$customer_id			= $code_project['customer_id'];
	
	$sql_detail				= "SELECT reference, quantity FROM project WHERE project_do_id = '$delivery_order_id'";
	$result_detail			= $conn->query($sql_detail);
	while($detail			= $result_detail->fetch_assoc()){
		$reference			= $detail['reference'];
		$quantity			= $detail['quantity'];
		
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC LIMIT 1";
		$result_stock		= $conn->query($sql_stock);
		if(mysqli_num_rows($result_stock) > 0){
			$stock_row		= $result_stock->fetch_assoc();
			$stock			= $stock_row['stock'];
		} else {
			$stock			= 0;
		}
		
		if($quantity > $stock){
			$validation		= false;
		}
	}
	
	if($validation			== true){
		$sql_detail			= "SELECT reference, quantity FROM project WHERE project_do_id = '$delivery_order_id'";
		$result_detail		= $conn->query($sql_detail);
		while($detail		= $result_detail->fetch_assoc()){
			$reference		= $detail['reference'];
			$quantity		= $detail['quantity'];
			
			$sql_in 		= "SELECT * FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND sisa > 0 ORDER BY id ASC";
			$result_in 		= $conn->query($sql_in);
			while($in 		= $result_in ->fetch_assoc()){
				$in_id 		= $in['id'];
				$sisa 		= $in['sisa'];
				
				$pengurang 	= min($sisa,$quantity);
				$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$conn->query($sql_update);
				
				$sql_out 	= "INSERT INTO stock_value_out (date,in_id,quantity,customer_id, document) VALUES ('$date','$in_id','$pengurang','$customer_id', '$delivery_order_name')";
				$conn->query($sql_out);
				
				$quantity 	= $quantity - $pengurang;
				
				if ($quantity == 0){
					break;
				}
			}
			
			$quantity		= $detail['quantity'];
			
			$sql_stock 		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
			$result_stock 	= $conn->query($sql_stock);
			$row_stock 		= $result_stock->fetch_assoc();
			
			$initial_stock 	= $row_stock['stock'];
			$end_stock 		= $initial_stock - $quantity;
			
			$sql_stock_out 	= "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,customer_id,document)
							VALUES ('$date','" . mysqli_real_escape_string($conn,$reference) . "','OUT','$quantity','$end_stock','','$customer_id','$delivery_order_name')";
			$conn->query($sql_stock_out);
		}
		
		$sql_updated 		= "UPDATE project_delivery_order SET isconfirm = '1', confirmed_by = '" . $_SESSION['user_id'] . "', 
							confirmed_date = CURDATE() WHERE id = '" . $delivery_order_id . "'";
		$conn->query($sql_updated);
	}
?>