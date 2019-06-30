<?php	
	include('../codes/connect.php');
	session_start();
	
	$invoice_array = ($_POST['invoice']);
	$document = mysqli_real_escape_string($conn,$_POST['document']);
	$customer_id = mysqli_real_escape_string($conn,$_POST['customer']);
	
	$sql_insert = "INSERT INTO counter_bill (date,name,customer_id,created_by)
	VALUES (CURDATE(),'$document','$customer_id','" . $_SESSION['user_id'] . "')";
	$result_insert = $conn->query($sql_insert);
	
	$sql_get = "SELECT id FROM counter_bill ORDER BY id DESC LIMIT 1";
	$result_get = $conn->query($sql_get);
	$get = $result_get->fetch_assoc();
	
	foreach ($invoice_array as &$value){
		$sql_update = "UPDATE invoices SET counter_id = '" . $get['id'] . "' WHERE id = '" . $value . "'";
		$result_update = $conn->query($sql_update);
	}
	header('location:counter_bill_dashboard.php');
?>