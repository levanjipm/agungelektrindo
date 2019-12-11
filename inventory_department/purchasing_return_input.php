<?php
	include('../codes/connect.php');
	session_start();
	$creator				= $_SESSION['user_id'];
	$return_date			= $_POST['return_date'];
	$quantity_array			= $_POST['quantity'];
	$guid					= $_POST['guid'];
	$return_id				= $_POST['return_id'];
	
	$sql_check				= "SELECT id FROM code_purchase_return_sent WHERE guid = '$guid'";
	$result_check			= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql				= "SELECT COUNT(id) as returned FROM code_purchase_return_sent";
		$result				= $conn->query($sql);
		$row				= $result->fetch_assoc();
		
		$returned			= $row['returned'];
		$returned++;
		
		$document_name		= "SJ-AE-RT-" . str_pad($returned,3,'0',STR_PAD_LEFT);
		$sql				= "INSERT INTO code_purchase_return_sent (document, code_purchase_return_id, created_by, guid)
								VALUES ('$document_name', '$return_id', '$creator', '$guid')";
		$result				= $conn->query($sql);
		if($result){
			$sql_get		= "SELECT id FROM code_purchase_return_sent WHERE guid = '$guid'";
			$result_get		= $conn->query($sql_get);
			$get			= $result_get->fetch_assoc();
			
			$sent_id		= $get['id'];
			
			foreach($quantity_array as $quantity){
				$key					= key($quantity_array);
				
				$sql_check_existing		= "SELECT sent_quantity, quantity FROM purchase_return WHERE code_id = '$return_id'";
				$result_check_existing	= $conn->query($sql_check_existing);
				$check_existing			= $result_check_existing->fetch_assoc();
				
				$sent					= $check_existing['sent_quantity'];
				$final_quantity			= $sent + $quantity;
				
				$return_quantity		= $check_existing['quantity'];
				
				$sql					= "INSERT INTO purchase_return_sent (purchase_return_id, sent_id, quantity)
											VALUES ('$key', '$sent_id', '$quantity')";
				$conn->query($sql);
				
				if($final_quantity		== $return_quantity){
					$sql_update			= "UPDATE purchase_return SET sent_quantity = '$final_quantity', isdone = '1' WHERE id = '$key'";
				} else if($final_quantity	< $return_quantity){
					$sql_update			= "UPDATE purchase_return SET sent_quantity = '$final_quantity' WHERE id = '$key'";
				}
				
				$conn->query($sql_update);
				
				next($quantity_array);
			}
		}
	}
	
	header('location:../inventory');
?>