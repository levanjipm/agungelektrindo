<?php
	include('../codes/connect.php');
	$nilai = 1;
	$id_so = $_POST['id_so'];
	for($tt = 1; $tt< $_POST['tt']; $tt++){
		//Ambil id so nya//
		$so_id = $_POST['id_' . $tt];
		$quantity = $_POST['existingqty' . $tt];
		$price = $_POST['existingprice' . $tt];
		$price_list = $_POST['existingpl' . $tt];
		//Cek dulu kalau udah terkirim beberapa//
		$sql_so = "SELECT id FROM sales_order WHERE id = '" . $so_id . "'";
		//Ambil data sent sales order dari tabel sent sales order//
		$result_so = $conn->query($sql_so);
		while($so = $result_so->fetch_assoc()){
			$sql_sent = "SELECT quantity FROM sales_order_sent WHERE id = '" . $so['id'] . "'";
			$result_sent = $conn->query($sql_sent);
			$row_sent = $result_sent->fetch_assoc();
			$quantity_sent = $row_sent['quantity'];	
		}
		if($quantity < $quantity_sent){
			$nilai++;
		} else {
		}
	};
	
	if($nilai == 1){
	for($tt = 1; $tt < $_POST['tt']; $tt++){
		$so_id = $_POST['id_' . $tt];
		$quantity = $_POST['existingqty' . $tt];
		$price = $_POST['existingprice' . $tt];
		$price_list = $_POST['existingpl' . $tt];
		//Update langsung ke sales ordernya//
		$sql_update = "UPDATE sales_order SET quantity = '" . $quantity . "', price = '" . $price . "', price_list = '" . $price_list . "' WHERE id = '" . $so_id . "'";
		if($quantity == $quantity_sent){		
			$sql_update_sent = "UPDATE sales_order_sent SET status = '1' WHERE id = '" . $so_id . "'";
			$result_update_sent = $conn->query($sql_update_sent);			
		} else {
		}
		$result_update = $conn->query($sql_update);
		$i = 1;
		for($i = 1; $i <= 5; $i++){
			if($_POST['reference' . $i] == ''){
			} else if($_POST['price' . $i] == '' || $_POST['price' . $i] == 0 || $_POST['pl' . $i] == '' || $_POST['pl' . $i] == 0){
			} else {
				$reference = $_POST['reference' . $i];
				$quantity = $_POST['quantity' . $i];
				$price = $_POST['price' . $i];
				$price_list = $_POST['pl' . $i];
				$discount = ($price_list - $price) * 100 / $price_list;	
				$sql_insert = "INSERT INTO sales_order (reference,price,discount,price_list,quantity,so_id,status)
				VALUES ('$reference','$price','$discount','$price_list','$quantity','$id_so','0')";
				$sql_insert_sent = "INSERT INTO sales_order_sent (reference,so_id) VALUES ('$reference','$id_so')";
				$result_insert_sent = $conn->query($sql_insert_sent);
				$result_insert = $conn->query($sql_insert);
			}
		}
	}
	}
	header('location:sales.php');
?>