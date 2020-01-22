<?php
	include('../codes/connect.php');
	$sql			= "SELECT * FROM stock WHERE reference = 'LC1D32M7' ORDER BY id ASC";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$id				= $row['id'];
		$quantity		= $row['quantity'];
		$transaction	= $row['transaction'];
		
		$sql_before		= "SELECT SUM(quantity) AS input FROM stock WHERE reference = 'LC1D32M7' AND transaction = 'IN' AND id < '$id'";
		$result_before	= $conn->query($sql_before);
		$before			= $result_before->fetch_assoc();
		
		$in				= $before['input'];
		
		$sql_before		= "SELECT SUM(quantity) as output FROM stock WHERE reference = 'LC1D32M7' AND transaction = 'OUT' AND id < '$id'";
		$result_before	= $conn->query($sql_before);
		$before			= $result_before->fetch_assoc();
		
		$out				= $before['output'];
		
		$stock_before	= $in - $out;
		
		if($transaction == 'IN'){
			$stock_now		= $stock_before + $quantity;
		} else {
			$stock_now		= $stock_before - $quantity;
		}
		
		$sql			= "UPDATE stock SET stock = '$stock_now' WHERE id = '$id'";
		$conn->query($sql);
	}
?>