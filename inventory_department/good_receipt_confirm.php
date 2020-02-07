<?php
	include('../codes/connect.php');
	session_start();
	$confirmed_by		= $_SESSION['user_id'];
	$good_receipt_id	= (int) mysqli_real_escape_string($conn,$_POST['id']);
	$sql_status			= "SELECT isconfirm FROM code_goodreceipt WHERE id = '$good_receipt_id'";
	$result_status		= $conn->query($sql_status);
	$status				= $result_status->fetch_assoc();
	
	if($status['status'] == 0){
		$sql_status = "UPDATE code_goodreceipt SET isconfirm = '1', confirmed_by = '$confirmed_by', confirmed_date = CURDATE()
						WHERE id = '" . $good_receipt_id . "'";
		$conn->query($sql_status);
		
		$sql_get_status 	= "SELECT date,supplier_id,document FROM code_goodreceipt WHERE id = '" . $good_receipt_id . "'";
		$result_get_status 	= $conn->query($sql_get_status);
		$row_get_status 	= $result_get_status->fetch_assoc();
		
		$date 				= $row_get_status['date'];
		$supplier_id 		= $row_get_status['supplier_id'];
		$document 			= $row_get_status['document'];

		$sql_detail 		= "SELECT id,received_id, quantity FROM goodreceipt WHERE gr_id = '$good_receipt_id'";
		$result_detail 		= $conn->query($sql_detail);
		while($row_detail 	= $result_detail->fetch_assoc()){
			$goods_id 		= $row_detail['id'];
			$received_id 	= $row_detail['received_id'];
			$quantity 		= $row_detail['quantity'];
			if ($quantity != 0){
				$sql_received 		= "SELECT reference FROM purchaseorder WHERE id = '" . $received_id . "'";
				$result_received 	= $conn->query($sql_received);
				$row_received		= $result_received->fetch_assoc();
				$reference = $row_received['reference'];

				$sql_initial 	= "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
				$result_initial = $conn->query($sql_initial);
				if(mysqli_num_rows($result_initial) == 0){
					$stock_initial = 0;
				} else{
					while($row_initial = $result_initial->fetch_assoc()){
						$stock_initial = $row_initial['stock'];
					}
				}
				//Inserting stock//
				$final_stock 	= $stock_initial + $quantity;
				$sql_stock 		= "INSERT INTO stock (date,reference,transaction,quantity,stock,supplier_id,document) 
								VALUES ('$date','$reference','IN','$quantity','$final_stock','$supplier_id','$document')";
				
				$conn->query($sql_stock);
				
				$sql_price 		= "SELECT * FROM purchaseorder WHERE id = '" . $received_id . "'";
				$result_price 	= $conn->query($sql_price);
				$row_price 		= $result_price->fetch_assoc();
				$price 			= $row_price['unitprice'];
				
				$sql_stock_value = "INSERT INTO stock_value_in (date,reference,quantity,price,sisa,supplier_id,gr_id) 
									VALUES ('$date','$reference','$quantity','$price','$quantity','$supplier_id','$goods_id')";
				$conn->query($sql_stock_value);
			}
		}
	}
?>