<?php
	include('../codes/connect.php');
	$bank_id = $_POST['bank_id'];
	
	$sql_bank = "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	
	$id = $bank['id'];
	$date = $bank['date'];
	$transaction 	= $bank['transaction'];
	$opponent_id 	= $bank['bank_opponent_id'];
	$opponent_type 	= $bank['label'];
	
	$value_awal 		= $bank['value'];
	$uang 				= $bank['value'];
	$date 				= $_POST['date'];
	$remaining_array	= $_POST['remaining'];
	
	if($transaction == 2){ //Kredit ->masuk duit//
		$will_be_paid 	= 0;
		$check_array	= $_POST['check'];
		
		foreach($check_array as $check){
			if($check == 'on'){
				$key			= key($check_array);
				$remaining		= $remaining_array[$key];
					
				$sql_invoice 	= "SELECT value, ongkir FROM invoices WHERE id = '" . $key . "'";
				$result_invoice	= $conn->query($sql_invoice);
				$invoice 		= $result_invoice->fetch_assoc();
					
				$sql_receivable 	= "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $key . "'";
				$result_receivable 	= $conn->query($sql_receivable);
				$receivable 		= $result_receivable->fetch_assoc();
				
				$received 			= ($receivable['paid'] == NULL) ? 0: $receivable['paid'];
					
				$will_be_paid 		+= ($invoice['value'] + $invoice['ongkir']  - $received - $remaining);
			}
			
			next($check_array);
		}
		if($will_be_paid == 0){
			
			$sql_update 	= "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_update);
			
		} else {
			$sql_delete 	= "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_delete);
			
			$remainder = $bank['value'] - $will_be_paid;
			
			if($remainder != 0){
				$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
				VALUES ('$date','$remainder','$transaction','$opponent_id','$opponent_type','0','$bank_id')";
				$conn->query($sql_insert2);
			}
			
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$will_be_paid','$transaction','$opponent_id','$opponent_type','1','$bank_id')";
			$conn->query($sql_insert1);
			
			$sql_get_code_bank_id 		= "SELECT id FROM code_bank ORDER BY id DESC LIMIT 1";
			$result_get_code_bank_id 	= $conn->query($sql_get_code_bank_id);
			$get_code_bank_id 			= $result_get_code_bank_id->fetch_assoc();
			
			$bank_id = $get_code_bank_id['id'];
		}
		
		$check_array	= $_POST['check'];
		foreach($check_array as $check){
			if($check == 'on'){
				$key				= key($check_array);
				$sql_invoice 		= "SELECT value,ongkir FROM invoices WHERE id = '" . $key . "'";
				$result_invoice 	= $conn->query($sql_invoice);
				$invoice 			= $result_invoice->fetch_assoc();//Ambil nominal invoice total//
					
				$sql_receivable 	= "SELECT SUM(value) AS received FROM receivable WHERE invoice_id = '" . $key . "'";
				$result_receivable 	= $conn->query($sql_receivable);
				$receivable 		= $result_receivable->fetch_assoc();
					
				$total_receivable 	= $receivable['received'];
				$remaining 			= $remaining_array[$key];
				$paid 				= $invoice['value'] + $invoice['ongkir'] - $total_receivable - $remaining;
				
				$sql 				= "INSERT INTO receivable (invoice_id,date,value,bank_id) VALUES ('$key','$date','$paid','$bank_id')";
				$conn->query($sql);
				
				if($remaining == 0){
					$update_invoice = "UPDATE invoices SET isdone = '1', date_done = '" . $date . "' WHERE id = '" . $key . "'";
					$conn->query($update_invoice);
				}
			}
			
			next($check_array);
		}
		header('location:accounting');
		
	} else if($transaction == 1){
		$will_be_paid 	= 0;
		$check_array	= $_POST['check'];
		
		foreach($check_array as $check){
			if($check == 'on'){
				$key				= key($check_array);
				$remaining			= $remaining_array[$key];
						
				$sql_invoice 		= "SELECT value FROM purchases WHERE id = '" . $key . "'";
				$result_invoice 	= $conn->query($sql_invoice);
				$invoice 			= $result_invoice->fetch_assoc();
					
				$sql_payable 		= "SELECT SUM(value) AS paid FROM payable WHERE purchase_id = '" . $key . "'";
				$result_payable		= $conn->query($sql_payable);
				$payable 			= $result_payable->fetch_assoc();
				$paid 				= ($payable['paid'] == NULL) ? 0: $payable['paid'];
					
				$will_be_paid =  $will_be_paid + $invoice['value']  - $paid - $remaining;
					
				}
			next($check_array);
		}
		if($will_be_paid == 0){
			
			$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_update);
			
		} else {
			$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_delete);
			
			$remainder = $uang - $will_be_paid;
			
			if($remainder != 0){
				$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
				VALUES ('$date','$remainder','$transaction','$opponent_id','$opponent_type','0','$bank_id')";
				$conn->query($sql_insert2);
			}
			
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$will_be_paid','$transaction','$opponent_id','$opponent_type','1','$bank_id')";
			$conn->query($sql_insert1);
			
			$sql_get_code_bank_id 		= "SELECT id FROM code_bank ORDER BY id DESC LIMIT 1";
			$result_get_code_bank_id 	= $conn->query($sql_get_code_bank_id);
			$get_code_bank_id 			= $result_get_code_bank_id->fetch_assoc();
			
			$bank_id = $get_code_bank_id['id'];
		}
		
		$check_array	= $_POST['check'];
		
		foreach($check_array as $check){
			if($check == 'on'){
				$key			= key($check_array);
				$remaining		= $remaining_array[$key];
				
				$sql_invoice 	= "SELECT value FROM purchases WHERE id = '" . $key . "'";
				$result_invoice	= $conn->query($sql_invoice);
				$invoice 		= $result_invoice->fetch_assoc();
					
				$sql_payable = "SELECT SUM(value) AS paid FROM payable WHERE purchase_id = '" . $key . "'";
				$result_payable = $conn->query($sql_payable);
				$payable = $result_payable->fetch_assoc();
				
				$paid_purchase 	= $payable['paid'];

				$paid		 	= $invoice['value'] - $paid_purchase - $remaining;
				
				$sql = "INSERT INTO payable (purchase_id,date,value,bank_id) VALUES ('$key','$date','$paid','$bank_id')";
				$conn->query($sql);
				if($remaining == 0){
					$update_invoice = "UPDATE purchases SET isdone = '1' WHERE id = '" . $key . "'";
					$conn->query($update_invoice);
				}
				
				$uang = $uang - $paid;
			}
			
			next($check_array);
			
		}
		
		header('location:accounting');
	}
	
?>