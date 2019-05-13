<?php
	include('../codes/connect.php');
	if(empty($_POST['nama'])){
		header('location:add_client.php');
	}
	$sql_check = "SELECT COUNT(name) AS jumlah FROM bank_accounts WHERE name = '" . $_POST['nama'] . "'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	if($check['jumlah'] != 0){
		header('location:add_client.php');
	} else {
		$name = $_POST['nama'];
		$sql_input = "INSERT INTO bank_accounts (name) VALUES ('$name')";
		$result_input = $conn->query($sql_input);
	}
	header('location:add_client.php');
?>