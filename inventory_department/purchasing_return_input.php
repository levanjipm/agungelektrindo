<?php
	include('../codes/connect.php');
	if(!empty($_POST)){
	
		$return_id			= $_POST['return_id'];
		
		$sql_awal 			= "SELECT * FROM code_purchase_return WHERE id = '$return_id'";
		$result_awal 		= $conn->query($sql_awal);
		$awal 				= $result_awal->fetch_assoc();
		$supplier_id 		= $awal['supplier_id'];
			
		$date 				= $_POST['send_date'];
		
		$year				= substr(date('Y',strtotime($date)),-2);
		$month				= str_pad(date('m',strtotime($date)),2,"0",STR_PAD_LEFT);
		
		$document			= '';
		$document			.= $year . $month;
		$document			.= '/PR-AE/' . str_pad($return_id,3,'0',STR_PAD_LEFT);
			
		$sql_update 		= "UPDATE code_purchase_return SET send_date = '" . $date . "', issent = '1', name = '$document' WHERE id = '$return_id";
		$result_update 		= $conn->query($sql_update);
		$nilai 				= true;
		
		$sql_detail 			= "SELECT * FROM purchase_return WHERE code_id = '$return_id'";
		$result_detail		= $conn->query($sql_detail);
		while($detail 		= $result_detail->fetch_assoc()){
			$reference 		= $detail['reference'];
			$quantity 		= $detail['quantity'];
			
			$sql_check_stock 			= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY ID DESC LIMIT 1";
			$result_check_stock 		= $conn->query($sql_check_stock);
			$check_stock 				= $result_check_stock->fetch_assoc();
			if($check_stock['stock'] 	< $quantity){
				$nilai 					= false;
			}
		}
		
		if($nilai == true){
			$sql_detail 		= "SELECT * FROM purchase_return WHERE code_id = '$return_id'";
			$result_detail		= $conn->query($sql_detail);
			while($detail 		= $result_detail->fetch_assoc()){
				$reference 		= $detail['reference'];
				$quantity 		= $detail['quantity'];
				$price 			= $detail['price'];
			
				$sql_check_stock 		= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY ID DESC LIMIT 1";
				$result_check_stock 	= $conn->query($sql_check_stock);
				$check_stock 			= $result_check_stock->fetch_assoc();
				$stock 					= $check_stock['stock'];
				$stock_akhir 			= $stock - $quantity;
				
				$sql_stock 				= "INSERT INTO stock (reference,transaction,quantity,stock,supplier_id,document)
										VALUES ('$reference','OUT','$quantity','$stock_akhir','$supplier_id','$document')";
				$conn->query($sql_stock);
				
				$sql_in 				= "SELECT * FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND sisa > 0 ORDER BY id DESC";
				$result_in 				= $conn->query($sql_in);
				while($in 				= $result_in->fetch_assoc()){
					$in_id 				= $in['id'];
					$in_date 			= $in['date'];
					$quantity_awal		= $in['quantity'];
					$sisa 				= $in['sisa'] - $quantity;
					if($in['sisa'] >= $quantity){
						$quantity_akhir 	= $quantity_awal - $quantity;
						$sql_update_in 		= "UPDATE stock_value_in SET quantity = '$quantity_akhir', sisa = '$sisa' WHERE id = '$in_id'";
						$conn->query($sql_update_in);
						
						$sql_update_other 	= "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id)
											VALUES ('$in_date','$reference','$quantity','$price','0','$supplier_id')";
						$conn->query($sql_update_other);
						
						$sql_select			= "SELECT id FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND sisa = 0 ORDER BY id DESC";
						$result_select		= $conn->query($sql_select);
						$select_last		= $result_select->fetch_assoc();
						
						$last_id			= $select_last['id'];
						
						$sql_out			= "INSERT INTO stock_value_out (date,in_id,quantity)
											VALUES ('$date','$last_id','$quantity')";
						$conn->query($sql_out);
						
						break;
					} else {
						$sisa				= $quantity_awal - $in['sisa'];
						$sql_update_in 		= "UPDATE stock_value_in SET quantity = '" . $in['sisa'] . "', sisa = '0' WHERE id = '" . $in['id'] . "'";
						$conn->query($sql_update_in);
						
						$sql_update_other 	= "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id)
											VALUES ('$in_date','$reference','$sisa','$price','0','$supplier_id')";
						$conn->query($sql_update_other);
						
						$sql_terakhir 		= "SELECT id FROM stock_value_in WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' AND sisa > 0 ORDER BY id DESC";
						$result_terakhir 	= $conn->query($sql_terakhir);
						$terakhir 			= $result_terakhir->fetch_assoc();
						$id_terakhir 		= $terakhir['id'];
						
						$sql_out 			= "INSERT INTO stock_value_out (date,in_id,quantity)
											VALUES ('$date','$id_terakhir','$quantity')";
						$conn->query($sql_out);
						
						$quantity 			-= $sisa;
					}
				}
			}
		}
	}
?>