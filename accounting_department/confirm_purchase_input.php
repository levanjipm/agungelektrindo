<?php
	include('../codes/connect.php');
	$id = $_POST['id'];
	$sql = "UPDATE purchases SET isconfirm = '1' WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	if($result){
		echo ('0');
	} else {
		echo ('1');
	}
?>