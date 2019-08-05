<?php
	include('../codes/connect.php');
	if(empty($_POST['return_id'])){
		header('location:sales.php');
	}
	$x = $_POST['x'];
	$date = $_POST['dating'];
	$document = $_POST['document'];
	$return_id = $_POST['return_id'];
	$sql_return = "SELECT do_id,customer_id FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_return = $conn->query($sql_return);
	$return = $result_return->fetch_assoc();
	$do_id = $return['do_id'];
	$customer_id = $return['customer_id'];	
	$sql_do = "SELECT date FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_do = $conn->query($sql_do);
	$do = $result_do->fetch_assoc();	
	$date_out = $do['date'];
	$finished = 0;
	for($i = 1; $i < $x; $i++){
		$reference = $_POST['reference' . $i];
		$quantity = $_POST['received' . $i];
		$sql_check = "SELECT quantity, received FROM sales_return WHERE return_code = '" . $return_id . "' AND reference = '" . $reference . "'";
		$result_check = $conn->query($sql_check);
		$check = $result_check->fetch_assoc();
		$control = $check['quantity'] - $check['received'];
		if($quantity == $control){
			$sql_update = "UPDATE sales_return SET isreceive = '1',received = '" . $quantity . "' WHERE return_code = '" . $return_id . "' AND reference = '" . $reference . "'";
			$result_update = $conn->query($sql_update);
			$finished++;
		}		
		$sql_initial = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_initial = $conn->query($sql_initial);
		$initial = $result_initial->fetch_assoc();
		$awal = $initial['stock'];
		$stock_input = $awal + $quantity;
		
		$sql_stock = "INSERT INTO stock (date,reference,transaction,quantity,stock,customer_id,document) VALUES
		('$date','$reference','IN','$quantity','$stock_input','$customer_id','$document')";
		echo $sql_stock;
		
		$result_stock = $conn->query($sql_stock);
		$sql_out = "SELECT stock_value_out.in_id, stock_value_in.id, stock_value_in.price, stock_value_in.quantity AS in_quantity, stock_value_in.reference, stock_value_out.quantity AS out_quantity FROM stock_value_out
		INNER JOIN stock_value_in
		ON stock_value_out.in_id = stock_value_in.id
		WHERE stock_value_out.date = '" . $date_out . "' AND stock_value_in.reference = '" . $reference . "'
		GROUP BY stock_value_in.id ORDER BY in_id DESC";
		$result_out = $conn->query($sql_out);
		while($out = $result_out->fetch_assoc()){
			$price = $out['price'];
			$yang_ok = min($quantity,$out['out_quantity']);
			$sql = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,customer_id)
			VALUES ('$date','$reference','$yang_ok','$price','$yang_ok','$customer_id')";
			$result = $conn->query($sql);
			$quantity = $quantity - $yang_ok;
			if($quantity == 0){
				break;
			}
		}
	}
	if($finished == ($x - 1)){
		$sql_update_finish = "UPDATE code_sales_return SET isfinished = '1' WHERE id = '" . $return_id . "'";
		$result_update_finish = $conn->query($sql_update_finish);
	}
	header('location:inventory.php');
?>
