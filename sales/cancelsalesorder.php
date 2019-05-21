<?php
	include('../codes/connect.php');
	if(empty($_POST['id'])){
		header('location:sales.php');
	} else {
		$id = $_POST['id'];
		$sql = "DELETE code_salesorder SET isconfirm = '1' WHERE id= '" . $id . "'";
		$result = $conn->query($sql);
		$sql_detail = "DELETE salesorder WHERE so_id = '" . $id . "'";
		$result_detail = $conn->query($sql_detail);
		$sql_detail_sent = "DELETE sales_order_sent WHERE so_id = '" . $id . "'";
		$result_detail_sent = $conn->query($sql_detail_sent);
	}
	if($result){
		header('location:confirmsalesorder_dashboard.php?alert=true');
	} else {
		header('location:confirmsalesorder_dashboard.php?alert=true');
	}