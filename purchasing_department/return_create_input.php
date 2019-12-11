<?php
	include('../codes/connect.php');
	session_start();
	$creator				= $_SESSION['user_id'];
	$supplier 				= $_POST['supplier'];
	$date					= $_POST['date'];
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$manual_price_array		= $_POST['manual_price'];
	$guid					= $_POST['guid'];
	
	$sql_check				= "SELECT id FROM code_purchase_return WHERE guid = '$guid'";
	$result_check			= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql_insert 			= "INSERT INTO code_purchase_return (submission_date, created_by, supplier_id, guid) VALUES ('$date', '$creator', '$supplier','$guid')";
		$result_insert 			= $conn->query($sql_insert);
			
		if($result_insert){	
			$sql_last 			= "SELECT id FROM code_purchase_return WHERE guid = '$guid'";
			$result_last 		= $conn->query($sql_last);
			$last				= $result_last->fetch_assoc();
			$last_id 			= $last['id'];
			
			$total_price = 0;
		
			foreach($reference_array as $reference){
				$key					= key($reference_array);
				$quantity				= $quantity_array[$key];
				$manual_price			= $manual_price_array[$key];
				$sql 					= "INSERT INTO purchase_return (reference,quantity,price,code_id) VALUES ('" . mysqli_real_escape_string($conn,$reference) . "','$quantity','$manual_price','$last_id')";
				$result 				= $conn->query($sql);
				$total_price 			+= $manual_price * $quantity;
				
				next($reference_array);
			}
			
			echo $sql_last;
		}
	}
	
	
	header('location:../purchasing');
?>