<?php
	include('../codes/connect.php');
	session_start();
	$created_by = $_SESSION['user_id'];
	
	$date = $_POST['date'];
	$quantity	= $_POST['quantity'];
	
	//Reference yang harusnya ada stock dan akan ditukarkan//
	$reference1 = mysqli_real_escape_string($conn,$_POST['reference1']);
	$reference2 = mysqli_real_escape_string($conn,$_POST['reference2']);
	
	$reference3 = mysqli_real_escape_string($conn,$_POST['reference3']);
	$reference4 = mysqli_real_escape_string($conn,$_POST['reference4']);
	
	$price_list1 = $_POST['price_list1'];
	$price_list2 = $_POST['price_list2'];
	
	$sql = "SELECT COUNT(id) AS swap_done FROM code_adjustment_event WHERE event_id = '5'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$event_number = $row['swap_done'];
	$event_number++;
	
	$event_name = "SWP" . $event_number;
	$sql 		= "INSERT INTO code_adjustment_event (date,event_id,event_name,created_by) VALUES ('$date','5','$event_name','$created_by')";
	$result 	= $conn->query($sql);
	
	$sql_get 	= "SELECT * FROM code_adjustment_event WHERE event_name = '$event_name'";
	$result_get = $conn->query($sql_get);
	$get 		= $result_get->fetch_assoc();
	
	$id = $get['id'];
	
	$sql 		= "INSERT INTO adjustment_event (reference,quantity,transaction,price_input,code_adjustment_event) VALUES ('$reference1','$quantity','OUT','0','$id')";
	$result 	= $conn->query($sql);
	
	$sql 		= "INSERT INTO adjustment_event (reference,quantity,transaction,price_input,code_adjustment_event) VALUES ('$reference2','$quantity','OUT','0','$id')";
	$result 	= $conn->query($sql);
	
	$sql 		= "INSERT INTO adjustment_event (reference,quantity,transaction,price_input,code_adjustment_event) VALUES ('$reference3','$quantity','IN','$price_list1','$id')";
	$result 	= $conn->query($sql);
	
	$sql 		= "INSERT INTO adjustment_event (reference,quantity,transaction,price_input,code_adjustment_event) VALUES ('$reference4','$quantity','IN','$price_list2','$id')";
	$result		= $conn->query($sql);
	
	header('location:inventory.php');
?>