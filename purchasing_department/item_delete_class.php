<?php
	include('../codes/connect.php');
	$class_id		= mysqli_real_escape_string($conn,$_POST['class_id']);
	
	$sql_item 		= "SELECT COUNT(*) AS group_member_quantity FROM itemlist WHERE type = '$class_id'";
	$result_item 	=  $conn->query($sql_item);
	$item 			= $result_item->fetch_assoc();
	$member			= $item['group_member_quantity'];
	
	if($member == 0){
		$sql_delete	= "DELETE FROM itemlist_category WHERE id = '$class_id'";
		$conn->query($sql_delete);
	};
?>