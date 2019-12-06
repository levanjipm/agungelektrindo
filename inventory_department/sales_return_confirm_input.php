<?php
	include('../codes/connect.php');
	
	if(!empty($_POST['return_id'])){
		$return_id 					= $_POST['return_id'];
			
		$sql						= "SELECT code_sales_return_received.date as return_date, code_sales_return_received.document, code_delivery_order.name, 
										code_delivery_order.date, code_delivery_order.id as delivery_order_id, code_delivery_order.customer_id
										FROM code_sales_return_received 
										JOIN code_sales_return ON code_sales_return.id = code_sales_return_received.code_sales_return_id
										JOIN code_delivery_order ON code_sales_return.do_id = code_delivery_order.id
										WHERE code_sales_return_received.id = '$return_id'";
		$result						= $conn->query($sql);
		$row						= $result->fetch_assoc();
			
		$return_document			= mysqli_real_escape_string($conn,$row['document']);
		$return_date				= $row['return_date'];
		$customer_id				= $row['customer_id'];
			
		$delivery_order_id			= $row['delivery_order_id'];
		$delivery_order_date		= $row['date'];
			
		$sql_return					= "SELECT sales_return_received.quantity, delivery_order.reference FROM sales_return
										JOIN sales_return_received ON sales_return_received.sales_return_id = sales_return.id
										JOIN delivery_order ON sales_return.delivery_order_id = delivery_order.id
										WHERE received_id = '$return_id'";
		$result_return				= $conn->query($sql_return);
		while($return				= $result_return->fetch_assoc()){
			$reference				= mysqli_real_escape_string($conn,$return['reference']);
			$quantity				= $return['quantity'];
				
			$sql_stock	 			= "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC LIMIT 1";
			$result_stock			= $conn->query($sql_stock);
			$stock	 				= $result_stock->fetch_assoc();
			$init_stock				= $stock['stock'];
			$final_stock 			= $init_stock + $quantity;
				
			$sql_insert_stock 		= "INSERT INTO stock (date,reference,transaction,quantity,stock,customer_id,document) VALUES
										('$return_date','$reference','IN','$quantity','$final_stock','$customer_id','$return_document')";
			$conn->query($sql_insert_stock);
			
			$sql_stock_value_out	= "SELECT stock_value_out.in_id, stock_value_in.id, stock_value_in.price, stock_value_in.quantity AS in_quantity, 
										stock_value_in.reference, stock_value_out.quantity AS out_quantity FROM stock_value_out
										INNER JOIN stock_value_in
										ON stock_value_out.in_id = stock_value_in.id
										WHERE stock_value_out.date = '$delivery_order_date' AND stock_value_in.reference = '$reference'
										GROUP BY stock_value_in.id ORDER BY in_id DESC";
			$result_stock_value_out 	= $conn->query($sql_stock_value_out);
			while($stock_value_out 		= $result_stock_value_out->fetch_assoc()){
				$price 					= $stock_value_out['price'];
				$minimum_quantity 		= min($quantity,$stock_value_out['out_quantity']);
				$sql 					= "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,customer_id)
										VALUES ('$return_date','$reference','$minimum_quantity','$price','$minimum_quantity','$customer_id')";
				$result 				= $conn->query($sql);
				$quantity -= $minimum_quantity;
				
				if($quantity == 0){
					break;
				}
			}
		}
		
		$sql			= "UPDATE code_sales_return_received SET isconfirm = '1' WHERE id = '$return_id'";
		$conn->query($sql);
	}
?>
