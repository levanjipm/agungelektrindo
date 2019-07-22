<?php
	include('../codes/connect.php');
	$bank_id = $_POST['bank_id'];
	
	$sql_bank = "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	
	$date = $bank['date'];
	$value_awal = $bank['value'];
	$transaction = $bank['transaction'];
	$opponent_id = $bank['bank_opponent_id'];
	$opponent_type = $bank['label'];
	$uang = $bank['value'];
	
	$x = $_POST['tt'];
	$i = 1;
	if($transaction == 2){ //Kredit ->masuk duit//
		$date = $_POST['date'];
		for($i = 1; $i < $x; $i++){{
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on')
					$invoice_id = $_POST['id' . $i];
					$sql_invoice = "SELECT value,ongkir FROM invoices WHERE id = '" . $invoice_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] + $invoice['ongkir'] - $remaining;
					$sql = "INSERT INTO receivable (invoice_id,date,value,bank_id) VALUES ('$invoice_id','$date','$paid','$bank_id')";
					$result = $conn->query($sql);
					if($remaining == 0){
						$update_invoice = "UPDATE invoices SET isdone = '1' WHERE id = '" . $invoice_id . "'";
						$result_update = $conn->query($update_invoice);
					}
				$uang = $uang - $paid;
				}
			}
			
		}
		if($uang == 0){
			$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$result_update = $conn->query($sql_update);
		} else {
			$yangdiassign = $value_awal - $uang;
			$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,name,isdone,major_id)
			VALUES ('$date','$yangdiassign','$transaction','$name','1','$bank_id')";
			
			$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,name,isdone,major_id)
			VALUES ('$date','$uang','$transaction','$name','0','$bank_id')";
			
			$result_1 = $conn->query($sql_insert1);
			$result_2 = $conn->query($sql_insert2);
			$result_delete = $conn->query($sql_delete);
		}
		// header('location:accounting.php');
	} else if($transaction == 1){ //Debit -> keluar duit//
		print_r($_POST);
		$date = $_POST['date'];
		echo $date;
		for($i = 1; $i <= $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					echo "Masuk paeko";
					$purchase_id = $_POST['id' . $i];
					$sql_invoice = "SELECT value FROM purchases WHERE id = '" . $purchase_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$sql_udah_dibayar = "SELECT SUM(value) AS udah_dibayar FROM payable WHERE purchase_id = '" . $purchase_id . "'";
					$result_udah_dibayar = $conn->query($sql_udah_dibayar);
					$udah_dibayar = $result_udah_dibayar->fetch_assoc();
					
					$paid = $udah_dibayar['udah_dibayar'];
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] - $remaining - $paid;
					$sql = "INSERT INTO payable (purchase_id,date,value,bank_id) VALUES ('$purchase_id','$date','$paid','$bank_id')";
					$result = $conn->query($sql);
					if($remaining == 0){
						$update_invoice = "UPDATE purchases SET isdone = '1' WHERE id = '" . $purchase_id . "'";
						$result_update = $conn->query($update_invoice);
					}
					$uang = $uang - $paid;
					echo $uang;
				}
			}
			
		}
		
		if($uang == 0){
			$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$result_update = $conn->query($sql_update);
		} else {
			$yangdiassign = $value_awal - $uang;
			$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,name,isdone,major_id)
			VALUES ('$date','$yangdiassign','$transaction','$name','1','$bank_id')";
			
			$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,name,isdone,major_id)
			VALUES ('$date','$uang','$transaction','$name','0','$bank_id')";
			
			$result_1 = $conn->query($sql_insert1);
			$result_2 = $conn->query($sql_insert2);
			$result_delete = $conn->query($sql_delete);
		}
	}
	header('location:accounting.php');
?>