<?php
	include('../../codes/connect.php');
	$reference = $_POST['reference'];
	$quantity = $_POST['quantity'];
	if($quantity == '' || $quantity == 0){
		echo ("Error");
	} else {
		$sql_item = "SELECT COUNT(id) AS jumlah FROM itemlist WHERE reference = '" . $reference . "'";
		$result_item = $conn->query($sql_item);
		$item = $result_item->fetch_assoc();
		if($item['jumlah'] == 0){
			echo ('Item not found!');
			return false;
		} else {
			$sql_check_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
			$result_check_stock = $conn->query($sql_check_stock);
			$stock = $result_check_stock->fetch_assoc();
			if($stock['stock'] == 0){
				echo ("Stock is insufficient");
				return false;
			} else {
				echo ("OK");
			}
		}
	}
?>	