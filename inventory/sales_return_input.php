<?php
	include('../codes/connect.php');
	
	if(empty($_POST['return_id'])){
		header('location:sales.php');
	}
	
	$date 				= $_POST['return_date'];
	$document 			= mysqli_real_escape_string($conn,$_POST['document']);
	$return_id 			= $_POST['return_id'];
	
	$sql_return 		= "SELECT do_id,customer_id FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_return 		= $conn->query($sql_return);
	$return 			= $result_return->fetch_assoc();
	
	$do_id 				= $return['do_id'];
	$customer_id 		= $return['customer_id'];
	
	$sql_do				= "SELECT date FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_do 			= $conn->query($sql_do);
	$do 				= $result_do->fetch_assoc();
	
	$date_out 			= $do['date'];
	$finished 			= 0;
	$received_array		= $_POST['received'];
	foreach($received_array as $received){
		$key		= key($received_array);
		
		$sql_return			= "SELECT sales_return.return_code, sales_return.delivery_order_id, sales_return.received, sales_return.quantity, delivery_order.reference FROM sales_return
							JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id
							WHERE sales_return.id = '$key'";
		$result_return		= $conn->query($sql_return);
		$return				= $result_return->fetch_assoc();
		
		$delivery_order_id	= $return['delivery_order_id'];
		$return_code		= $return['return_code'];
		
		$reference			= mysqli_real_escape_string($conn,$return['reference']);
		$quantity			= $return['quantity'];
		
		if($quantity 		== $received){
			$sql_update 	= "UPDATE sales_return SET isreceive = '1',received = '$received', document = '$document' WHERE id = '$key'";
		} else {
			$new_quantity	= $quantity - $received;
			$sql			= "INSERT INTO sales_return (quantity, received, isreceive, return_code, delivery_order_id)
							VALUES ('$new_quantity','0','0','$return_code','$delivery_order_id')";
			$conn->query($sql);
			
			$sql_update	= "UPDATE sales_return SET received = '$received', quantity = '$received', isreceive = '1', document = '$$document' WHERE id = '$key'";
		}
		$conn->query($sql_update);
		
		$sql_stock	 		= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_stock		= $conn->query($sql_stock);
		$stock	 			= $result_stock->fetch_assoc();
		$init_stock			= $stock['stock'];
		$final_stock 		= $init_stock + $quantity;
		
		$sql_stock 			= "INSERT INTO stock (date,reference,transaction,quantity,stock,customer_id,document) VALUES
							('$date','$reference','IN','$quantity','$final_stock','$customer_id','$document')";
		$conn->query($sql_stock);
		
		$sql_stock_value_out = "SELECT stock_value_out.in_id, stock_value_in.id, stock_value_in.price, stock_value_in.quantity AS in_quantity, stock_value_in.reference, stock_value_out.quantity AS out_quantity FROM stock_value_out
							INNER JOIN stock_value_in
							ON stock_value_out.in_id = stock_value_in.id
							WHERE stock_value_out.date = '" . $date_out . "' AND stock_value_in.reference = '" . $reference . "'
							GROUP BY stock_value_in.id ORDER BY in_id DESC";
		
		$result_stock_value_out 	= $conn->query($sql_stock_value_out);
		while($stock_value_out 		= $result_stock_value_out->fetch_assoc()){
			$price 					= $stock_value_out['price'];
			$minimum_quantity 		= min($quantity,$stock_value_out['out_quantity']);
			$sql 					= "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,customer_id)
									VALUES ('$date','$reference','$minimum_quantity','$price','$minimum_quantity','$customer_id')";
			$result = $conn->query($sql);
			$quantity -= $minimum_quantity;
			
			if($quantity == 0){
				break;
			}
		}
		
		next($received_array);
	}
	
	// header('location:inventory.php');
?>
