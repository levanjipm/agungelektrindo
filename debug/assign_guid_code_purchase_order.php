<?php
	include('../codes/connect.php');
	
	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
	
	$sql		= "SELECT id FROM code_purchaseorder WHERE guid IS NULL";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$guid 	= GUID();
		$id		= $row['id'];
		$update	= "UPDATE code_purchaseorder SET guid = '$guid' WHERE id = '$id'";
		$conn->query($update);
	}
?>