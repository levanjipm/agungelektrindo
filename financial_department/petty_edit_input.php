<?php
	include('../codes/connect.php');
	$petty_id			= $_POST['id'];
	$new_value			= $_POST['value'];
				
	$sql_old			= "SELECT * FROM petty_cash WHERE id = '$petty_id'";
	$result_old			= $conn->query($sql_old);
	$old				= $result_old->fetch_assoc();
	$old_value			= $old['value'];
	$old_balance		= $old['balance'];
	$difference_value	= $old_value - $new_value;
	
	$new_balance		= $old_balance + $difference_value;
	
	$sql_update			= "UPDATE petty_cash SET value = '$new_value', balance = '$new_balance' WHERE id = '$petty_id'";
	$result_update		= $conn->query($sql_update);
	
	if($result_update){
		$balance		= $new_balance;
		$sql_all		= "SELECT * FROM petty_cash WHERE id > '$petty_id' ORDER BY id ASC";
		$result_all		= $conn->query($sql_all);
		while($all		= $result_all->fetch_assoc()){
			$update_id		= $all['id'];
			$update_value	= $all['value'];
			if($all['class'] == 25){
				$update_balance	= $new_balance + $update_value;
			} else {
				$update_balance	= $new_balance - $update_value;
			}
			
			$sql		= "UPDATE petty_cash SET balance = '$update_balance' WHERE id = '$update_id'";
			$conn->query($sql);
			
			$balance	= $update_balance;
		};
	};
?>