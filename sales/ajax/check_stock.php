<?php
	include('../../codes/connect.php');
	$reference = mysqli_real_escape_string($conn,$_POST['reference']);
	$sql = "SELECT stock FROM stock WHERE reference = '" . $reference . "' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$stock = $row['stock'];
	