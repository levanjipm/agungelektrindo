<?php
	include('../codes/connect.php');
	session_start();
	
	$creator				= $_SESSION['user_id'];
	$document				= mysqli_real_escape_string($conn,$_POST['document']);
	$date					= $_POST['return_date'];
	$received_array			= $_POST['received'];
	$return_id				= $_POST['return_id'];
	$guid					= $_POST['guid'];
	
	$sql_check				= "SELECT id FROM code_sales_return_received WHERE guid = '$guid'";
	$result_check			= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){
		$sql				= "INSERT INTO code_sales_return_received (document, code_sales_return_id, created_by, date, guid)
								VALUES ('$document', '$return_id', '$creator', '$date', '$guid')";
		$result				= $conn->query($sql);
		if($result){	
			$sql_get		= "SELECT id FROM code_sales_return_received WHERE guid = '$guid'";
			$result_get		= $conn->query($sql_get);
			$get			= $result_get->fetch_assoc();
			$id				= $get['id'];
			
			foreach($received_array as $quantity){
				$key		= key($received_array);
				$sql		= "INSERT INTO sales_return_received (sales_return_id, received_id, quantity)
								VALUES ('$key', '$id', '$quantity')";
				$conn->query($sql);
				
				$sql		= "SELECT quantity, received FROM sales_return WHERE id = '$key'";
				$result		= $conn->query($sql);
				$row		= $result->fetch_assoc();
				
				$return_quantity	= $row['quantity'];
				$received_quantity	= $row['received'];
				
				if($received_quantity + $quantity == $return_quantity){
					$sql			= "UPDATE sales_return SET received = '$return_quantity', isdone = '1' WHERE id = '$key'";
				} else if($received_quantity + $quantity < $return_quantity){
					$input_quantity	= $received_quantity + $quantity;
					$sql			= "UPDATE sales_return SET received = '$input_quantity' WHERE id = '$key'";
				}
				echo $sql;
				
				$conn->query($sql);
				
				next($received_array);
			}
		}
	}
	
	header('location:../inventory');
?>