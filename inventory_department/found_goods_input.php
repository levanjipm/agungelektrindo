<?php
	include('../codes/connect.php');
	session_start();
	
	$user_id = $_SESSION['user_id'];
	$date = $_POST['date'];
	$reference = mysqli_real_escape_string($conn,$_POST['reference']);
	$quantity = (int)$_POST['quantity'];
	$sql_stock = "SELECT stock FROM stock WHERE reference = '$reference' ORDER BY id DESC LIMIT 1";
	$result_stock = $conn->query($sql_stock);
	$row_stock = $result_stock->fetch_assoc();
	if(mysqli_num_rows($result_stock) == 0){
		$stock = 0;
	} else {
		$stock = $row_stock['stock'];
	}
	$quantity = $_POST['quantity'];
	$sql = "SELECT id FROM code_adjustment_event WHERE event_id = '2'";
	$result = $conn->query($sql);
	$jumlah = mysqli_num_rows($result);
	$jumlah++;
	$event_name = 'FOU' . $jumlah;
	
	$sql = "INSERT INTO code_adjustment_event (date,event_id,event_name,created_by)
	VALUES ('$date','2','$event_name','$user_id')";
	$result = $conn->query($sql);
	if($result){
		$sql_get_id = "SELECT id FROM code_adjustment_event ORDER BY id DESC LIMIT 1";
		$result_get_id = $conn->query($sql_get_id);
		$get_id = $result_get_id->fetch_assoc();
		$id = $get_id['id'];
	
		$sql = "INSERT INTO adjustment_event (reference,quantity,transaction,code_adjustment_event)
		VALUES ('$reference','$quantity','IN','$id')";
		$result = $conn->query($sql);
	}
	header('location:add_event_dashboard.php');
?>