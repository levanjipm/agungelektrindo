<?php
	include("../codes/connect.php");
	$id_do = $_GET['id'];
	$sql_one = "SELECT customer_id,name,date FROM code_delivery_order WHERE id ='" . $id_do . "'";
	$result_one = $conn->query($sql_one);
	while($rows = $result_one->fetch_assoc()){
		$customer_id = $rows['customer_id'];
		$document = $rows['name'];
		$date = $rows['date'];
	}
	$x = 1;
	$sql_select = "SELECT * FROM delivery_order WHERE do_id = '" . $id_do . "'";
	$result_select = $conn->query($sql_select);
	while($row = $result_select->fetch_assoc()){
		$reference = $row['reference'];
		$quantity = $row['quantity'];
		//Check the stock first, if there is no stock, cannot confirm//
		$sql_initial = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
		$result_initial = $conn->query($sql_initial);
		while($row_i = $result_initial->fetch_assoc()){
			$stock = $row_i['stock'];
		}
		//If there is no Data, break the looping process;//
		if ($stock == NULL){
			break;
		} else if($stock < $quantity){
			$x++;
		} else {
		}
	}
	if($x > 1){
		echo ('Error on inputing data, Cannot proceed');
		header("Refresh:3; url=confirm_do_dashboard.php");
	} else {
		$sql_second = "SELECT * FROM delivery_order WHERE do_id = '" . $id_do . "'";
		$result_second = $conn->query($sql_second);
		while($row_second = $result_second->fetch_assoc()){
			$references = $row_second['reference'];
			$quantitys = $row_second['quantity'];
			$sql_in = "SELECT * FROM stock_value_in WHERE reference = '" . $references . "' AND sisa > 0 ORDER BY id ASC";
			$result_in = $conn->query($sql_in);
			while($in = $result_in ->fetch_assoc()){
				$in_id = $in['id'];
				$sisa = $in['sisa'];
				$pengurang = min($sisa,$quantitys);
				$sql_update = "UPDATE stock_value_in SET sisa = '" . ($sisa - $pengurang) . "' WHERE id = '" . $in_id . "'";
				$result_update = $conn->query($sql_update);
				$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
				VALUES ('$date','$in_id	','$pengurang','$customer_id')";
				$result_out = $conn->query($sql_out);
				$quantity = $quantity - $pengurang;
				if ($quantity == 0){
					break;
				}
			}
			$sql_stock = "SELECT stock FROM stock WHERE reference = '" . $references . "' ORDER BY id DESC LIMIT 1";
			$result_stock = $conn->query($sql_stock);
			while($row_stock = $result_stock->fetch_assoc()){
				$initial_stock = $row_stock['stock'];
				$end_stock = $initial_stock - $quantitys;
			}
			$sql_stock_out = "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,customer_id,document)
			VALUES ('$date','$references','OUT','$quantitys','$end_stock','0','$customer_id','$document')";
			$result_stock_out = $conn->query($sql_stock_out);
		}
		$sql_updated = "UPDATE code_delivery_order SET sent = '1' WHERE id = '" . $id_do . "'";
		$result_updated = $conn->query($sql_updated);
		header('location:confirm_do_dashboard.php');
	}
?>