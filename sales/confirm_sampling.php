<?php
	include('../codes/connect.php');
	$sample_id = $_POST['id'];
	$type = $_POST['type'];
	
	if($type == 1){
		$sql = "UPDATE code_sample SET isconfirm = '1' WHERE id = '" . $sample_id . "'";
	}
?>