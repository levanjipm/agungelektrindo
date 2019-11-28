<?php
	include('../codes/connect.php');
	$user = $_POST['user'];
	$class_name = mysqli_real_escape_string($conn,$_POST['class_name']);
	
	$sql_search = "SELECT * FROM itemlist_category WHERE name = '" . $class_name . "'";
	$result_search = $conn->query($sql_search);
	if(mysqli_num_rows($result_search) > 0){
		echo ('0');
	} else {
		$sql = "INSERT INTO itemlist_category (name,date,created_by) VALUES ('$class_name',CURDATE(),'$user')";
		$result = $conn->query($sql);
		if($result){
			echo ('1');
		} else{
			echo ('2');
		}
	}
?>