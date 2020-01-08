<?php
	include('../codes/connect.php');
	$bank_id			= $_POST['bank_id'];
	$type				= $_POST['type'];
	if($type			== 1){
		$sql				= "UPDATE code_bank SET isdelete = '0' WHERE id = '$bank_id'";
		$result				= $conn->query($sql);
		$child_array		= [];
		
		if($result){
			$sql_child			= "SELECT * FROM code_bank WHERE major_id = '$bank_id'";
			$result_child		= $conn->query($sql_child);
			$number_of_child	= mysqli_num_rows($result_child);
			while($child		= $result_child->fetch_assoc()){
				array_push($child_array, $child['id']);
			}
			$where				= implode(',', $child_array);
			
			$sql_receivable		= "SELECT invoices.id, receivable.value, invoices.name
									FROM receivable 
									JOIN invoices ON receivable.invoice_id = invoices.id
									WHERE receivable.bank_id IN ($where) OR receivable.bank_id = '$bank_id'";
			$result_receivable	= $conn->query($sql_receivable);
			while($receivable	= $result_receivable->fetch_assoc()){
				$invoice_id		= $receivable['id'];
				$sql_update		= "UPDATE invoices SET isdone = '0', date_done = NULL WHERE id = '$invoice_id'";
				$conn->query($sql_update);
			}
			
			$sql			= "DELETE FROM receivable WHERE bank_id IN ($where)";
			$conn->query($sql);
			
			$sql			= "DELETE FROM code_bank_other WHERE bank_id = '$bank_id'";
			$conn->query($sql);
			
			$sql			= "DELETE FROM code_bank WHERE major_id = '$bank_id'";
			$conn->query($sql);
		}
	} else if($type			== 2){
		$sql				= "UPDATE code_bank SET isdelete = '0' WHERE id = '$bank_id'";
		$result				= $conn->query($sql);
		$child_array		= [];
		
		if($result){
			$sql_child			= "SELECT * FROM code_bank WHERE major_id = '$bank_id'";
			$result_child		= $conn->query($sql_child);
			$number_of_child	= mysqli_num_rows($result_child);
			while($child		= $result_child->fetch_assoc()){
				array_push($child_array, $child['id']);
			}
			$where				= implode(',', $child_array);
			
			$sql_receivable		= "SELECT purchases.id, payable.value, purchases.name
									FROM payable 
									JOIN purchases ON payable.purchase_id = purchases.id
									WHERE payable.bank_id IN ($where) OR payable.bank_id = '$bank_id'";
			$result_receivable	= $conn->query($sql_receivable);
			while($receivable	= $result_receivable->fetch_assoc()){
				$invoice_id		= $receivable['id'];
				$sql_update		= "UPDATE purchases SET isdone = '0' WHERE id = '$invoice_id'";
				$conn->query($sql_update);
			}
			
			$sql			= "DELETE FROM payable WHERE bank_id IN ($where)";
			$conn->query($sql);
			
			$sql			= "DELETE FROM code_bank_other WHERE bank_id = '$bank_id'";
			$conn->query($sql);
			
			$sql			= "DELETE FROM code_bank WHERE major_id = '$bank_id'";
			$conn->query($sql);
		}
	}
?>