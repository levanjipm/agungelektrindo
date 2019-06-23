<?php
	include('../codes/connect.php');
	if(empty($_POST)){
		header('location:inventory.php');
	}
	
	$sql_awal = "SELECT * FROM code_purchase_return WHERE id = '" . $_POST['id'] . "'";
	$result_awal = $conn->query($sql_awal);
	$awal = $result_awal->fetch_assoc();
	$supplier_id = $awal['supplier_id'];
	
	$date = date('Y-m-d');
	$do_name= $_POST['name'];
	
	$sql = "INSERT INTO return_delivery_order (date,name,type,supplier_customer)
	VALUES ('$date','$do_name','BELI','$supplier_id')";
	$result = $conn->query($sql);
	
	$sql_update = "UPDATE code_purchase_return SET send_date = '" . $date . "' WHERE id = '" . $_POST['id'] . "'";
	$result_update = $conn->query($sql_update);
	$nilai = true;
	
	//Check stocknya//
	$sql_detail = "SELECT * FROM purchase_return WHERE code_id = '" . $_POST['id'] . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
		$reference = $detail['reference'];
		$quantity = $detail['quantity'];
		
		$sql_check_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY ID DESC LIMIT 1";
		$result_check_stock = $conn->query($sql_check_stock);
		$check_stock = $result_check_stock->fetch_assoc();
		if($check_stock['stock'] < $quantity){
			$nilai = false;
		}
	}
	if($nilai == true){
		$sql_detail = "SELECT * FROM purchase_return WHERE code_id = '" . $_POST['id'] . "'";
		$result_detail = $conn->query($sql_detail);
		while($detail = $result_detail->fetch_assoc()){
			$reference = $detail['reference'];
			$quantity = $detail['quantity'];
			$price = $detail['price'];
		
			$sql_check_stock = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY ID DESC LIMIT 1";
			$result_check_stock = $conn->query($sql_check_stock);
			$check_stock = $result_check_stock->fetch_assoc();
			$stock = $check_stock['stock'];
			$stock_akhir = $stock - $quantity;
			
			$sql_stock = "INSERT INTO stock (reference,transaction,quantity,stock,supplier_id,document)
			VALUES ('$reference','OUT','$quantity','$stock_akhir','$supplier_id','$do_name')";
			$result_stock = $conn->query($sql_stock);
			
			$sql_in = "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id DESC";
			$result_in = $conn->query($sql_in);
			while($in = $result_in->fetch_assoc()){
				$in_id = $in['id'];
				$in_date = $in['date'];
				$quantity_awal = $in['quantity'];
				// $quantity_harga_baru = $quantity - $in['sisa'];
				if($in['sisa'] >= $quantity){
					
					$quantity_akhir = $quantity_awal - $quantity;
					$sql_update_in = "UPDATE stock_value_in SET quantity = '" . $quantity_akhir . "', sisa = '0' WHERE id = '" . $in['id'] . "'";
					$sql_update_other = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id,customer_id)
					VALUES ('$in_date','$reference','$quantity','$price','$quantity','$supplier_id','0')";
					
					$result_update_other = $conn->query($sql_update_other);
					
					$sql_terakhir = "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id DESC";
					$result_terakhir = $conn->query($sql_terakhir);
					$terakhir = $result_terakhir->fetch_assoc();
					$id_terakhir = $terakhir['id'];
					
					$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
					VALUES ('$date','$id_terakhir','$quantity','0')";
					$result_out = $conn->query($sql_out);
					
					break;
				} else {
					$sql_update_in = "UPDATE stock_value_in SET quantity = '" . $quantity_awal - $in['sisa'] . "', sisa = '0' WHERE id = '" . $in['id'] . "'";
					
					$sisa_akhir = $in['sisa'];
					
					$sql_update_other = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id,customer_id)
					VALUES ('$in_date','$reference','$sisa_akhir','$price','$sisa_akhir','$supplier_id','0')";
					$result_update_other = $conn->query($sql_update_other);
					
					$sql_terakhir = "SELECT * FROM stock_value_in WHERE reference = '" . $reference . "' AND sisa > 0 ORDER BY id DESC";
					$result_terakhir = $conn->query($sql_terakhir);
					$terakhir = $result_terakhir->fetch_assoc();
					$id_terakhir = $terakhir['id'];
					
					$sql_out = "INSERT INTO stock_value_out (date,in_id,quantity,customer_id)
					VALUES ('$date','$id_terakhir','$quantity','0')";
					$result_out = $conn->query($sql_out);
					
					$quantity = $quantity - $sisa_akhir;
				}
			}
		}
	}
	header('location:inventory.php');
?>