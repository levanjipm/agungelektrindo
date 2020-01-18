<?php	
	include("../codes/connect.php");
	$sql	= "SELECT * FROM code_delivery_order WHERE created_by = '0'";
	$result	= $conn->query($sql);
	while($row	= $result->fetch_assoc()){	
		$id		= $row['id'];
		
		$sql_update		= "UPDATE code_delivery_order SET created_by = '1' WHERE id = '$id'";
		$conn->query($sql_update);
	}
?>