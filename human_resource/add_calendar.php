<?php
	//Adding event to calendar//
	include('../codes/connect.php');	
	$date = $_POST['event_date'];
	$tags = $_POST['tags'];
	$x = $_POST['x'];
	$tags_arr = preg_split ("/\,/", $tags);
	$event_name = $_POST['event_name'];
	$event_desc = $_POST['description'];;
	$maker = $_POST['maker'];	
	$sql = "INSERT INTO calendar (date, maker, event, description)
	VALUES ('$date','$maker', '$event_name', '$event_desc')";
	$result = $conn->query($sql);
	$sql_detail = "SELECT id FROM calendar ORDER BY id DESC LIMIT 1";
	$result_detail = $conn->query($sql_detail);
	$row_detail = $result_detail->fetch_assoc();
	$calendar_id = $row_detail['id'];
	for ($i = 0; $i < $x; $i++){
		$sql_user = "SELECT id FROM users WHERE name = '" . $tags_arr[$i] . "'";
		$result_user = $conn->query($sql_user);
		$user = $result_user->fetch_assoc();
		$user_id = $user['id'];
		$sql_add = "INSERT INTO calendar_tag (calendar_id,user_id) VALUES ('$calendar_id','$user_id')";
		$result_add = $conn->query($sql_add);
	}		
	header('location:user_dashboard.php?style=skip');
?>
	