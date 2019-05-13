<?php
	include('../codes/connect.php');
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	$user_id = $_POST['id'];
	$new_name = $_POST['name'];
	$email = test_input($_POST["mail"]);
	$sql_user = "SELECT * FROM users WHERE id = '" . $user_id . "'";
	$result_user = $conn->query($sql_user);
	$user = $result_user->fetch_assoc();
	if($user['name'] == $_POST['name'] && $user['mail'] == $_POST['mail'] && $user['bank'] == $_POST['bank']){
		header('location:user_dashboard.php?alert=changefalse');
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('location:edit_user_dashboard.php?email=false');
    } else if(strlen($_POST['pwd']) <= 4 && strlen($_POST['pwd']) > 0){
		header('location:edit_user_dashboard.php?password=false');
	} else if(strlen($_POST['bank']) < 10 || strlen($_POST['bank']) > 15){
		header('location:edit_user_dashboard.php?bank=false');
	} else {
		if($_POST['pwd'] == ''){
			$sql = "UPDATE users SET name = '" . $new_name . "', mail = '" . $email . "' WHERE id = '" . $user_id . "'";
		} else if($_POST['address'] == ''){
			$sql = "UPDATE users SET name = '" . $new_name . "', mail = '" . $email . "', password = '" . md5($_POST['mail']) . "' WHERE id = '" . $user_id . "'";
		} else {
			$sql = "UPDATE users SET name = '" . $new_name . "', mail = '" . $email . "', password = '" . md5($_POST['mail']) . "', address = '" . $_POST['address'] . "'
			WHERE id = '" . $user_id . "'";
		}
	$result = $conn->query($sql);
	header('location:user_dashboard.php?alert=changetrue');
	}
?>