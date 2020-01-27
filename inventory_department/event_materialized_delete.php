<?php
	include('../codes/connect.php');
	
	$event_id		= $_POST['event_id'];
	$sql			= "DELETE FROM adjustment_event WHERE code_adjustment_event = '$event_id'";
	$result			= $conn->query($sql);
	if($result){
		$sql_delete	= "UPDATE code_adjustment_event SET isdelete = '1' WHERE id = '$event_id'";
		$conn->query($sql_delete);
	}
?>