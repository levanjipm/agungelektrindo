<?php
	include('connect.php');
	$reference_before_escape = $_POST['reference'];
	$reference = mysqli_real_escape_string($conn,$reference_before_escape);
	
	$sql = "SELECT id FROM itemlist WHERE reference = '" . $reference . "'";
	$result = $conn->query($sql);
	echo (mysqli_num_rows($result));
?>