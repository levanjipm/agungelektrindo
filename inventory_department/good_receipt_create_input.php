<?php
	include('../codes/connect.php');
	session_start();
	
	$created_by			= $_SESSION['user_id'];
	
	$date 				= $_POST['date'];
	$po_id 				= $_POST['po'];
	$document 			= mysqli_real_escape_string($conn,$_POST['document']);
	$qty_receive_array	= $_POST['qty_receive'];
	
	$sql_check			= "SELECT id FROM code_goodreceipt WHERE document = '$document' AND YEAR(date) = YEAR($date)";
	$result_check		= $conn->query($sql_check);
	$check				= mysqli_num_rows($result_check);
	
	if($check			== 0){
		$sql_supplier 		= "SELECT supplier_id FROM code_purchaseorder WHERE id = '" . $po_id . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
		$supplier_id		= $supplier['supplier_id'];
		
		//Inserting into code_goodreceipt//
		$sql_gr = "INSERT INTO code_goodreceipt (supplier_id,date,received_date,document,po_id,created_by)
					VALUES ('$supplier_id','$date',CURDATE(),'$document','$po_id','$created_by')";
		$result_gr = $conn->query($sql_gr);
		if($result_gr){
			foreach($qty_receive_array as $quantity_receive){
				$po_id		= key($qty_receive_array);
				if($quantity_receive > 0){
					$sql_receive = "SELECT id,quantity,status, received_quantity FROM purchaseorder WHERE id = '" . $po_id . "'";
					$result_receive 	= $conn->query($sql_receive);
					$row_receive 		= $result_receive->fetch_assoc();
					$status 			= $row_receive['status'];
					$quantity 			= $row_receive['quantity'];
					$received_quantity 	= $row_receive['received_quantity'];
					
					$sql_code_good_receipt 		= "SELECT id FROM code_goodreceipt ORDER BY id DESC LIMIT 1";
					$result_code_good_receipt	= $conn->query($sql_code_good_receipt);
					$row_code_good_receipt		= $result_code_good_receipt->fetch_assoc();
					$code_good_receipt 			= $row_code_good_receipt['id'];
					
					$sql_final = "INSERT INTO goodreceipt (received_id,quantity,gr_id) VALUES ('$po_id','$quantity_receive','$code_good_receipt')";
					$conn->query($sql_final);

					if ($status == 0){
						if ($quantity_receive + $received_quantity == $quantity){
							$final_quantity = $received_quantity + $quantity_receive;
							$sql = "UPDATE purchaseorder SET received_quantity = '" . $final_quantity . "', status = '1' 
							WHERE id = '" . $po_id . "'";
							$conn->query($sql);
						} else {
							$final_quantity = $received_quantity + $quantity_receive;
							$sql = "UPDATE purchaseorder SET received_quantity = '" . $final_quantity . "' WHERE id = '" . $po_id . "'";
							$conn->query($sql);
						}
						echo $sql;
					}			
				}
				
				next($qty_receive_array);
			}
		}
		header('location:../inventory');
	} else {
?>
<script>
	window.history.back();
</script>
<?php
	}
?>