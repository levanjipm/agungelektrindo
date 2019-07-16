<?php
	include('connect.php');
	$sender = $_GET['sender'];
	$receiver = $_GET['receiver'];
	$sql_get_chat = "SELECT * FROM live_chat_message WHERE user_send = '" . $sender . "'";
	$result_get_chat = $conn->query($sql_get_chat);
	$get_chat = $result_get_chat->fetch_assoc();
	echo $get_chat['message'];
?>