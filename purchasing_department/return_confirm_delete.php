<?php
	include('../codes/connect.php');
	$return_id					= $_POST['return_id'];
	$sql						= "SELECT SUM(sent_quantity) as sent FROM purchase_return WHERE code_id = '$return_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
				
	$sent						= $row['sent'];
				
	if($sent					== 0){
		$sql					= "DELETE FROM purchase_return WHERE code_id = '$return_id'";
		$result					= $conn->query($sql);
		if($result){	
			$sql_delete_code	= "DELETE FROM code_purchase_return WHERE id = '$return_id'";
			$conn->query($sql_delete_code);
		}
	};
?>