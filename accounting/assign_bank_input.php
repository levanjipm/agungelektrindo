<?php
	include('../codes/connect.php');
	$bank_id = $_POST['bank_id'];
	$sql_bank = "SELECT value,date,transaction,name FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	$date = $bank['date'];
	$value_awal = $bank['value'];
	$transaction = $bank['transaction'];
	$name = $bank['name'];
	print_r($_POST);
	$uang = $bank['value'];
	$tt = $_POST['tt'];
	$i = 1;
	if($transaction == 2){
		$date = $_POST['date'];
		for($i = 1; $i < $tt; $i++){{
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on')
					$invoice_id = $_POST['id' . $i];
					$sql_invoice = "SELECT value,ongkir FROM invoices WHERE id = '" . $invoice_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] + $invoice['ongkir'] - $remaining;
					$sql = "INSERT INTO receivable (invoice_id,date,value) VALUES ('$invoice_id','$date','$paid')";
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
	} else if($transaction == 1){
		$date = $_POST['date'];
		echo $date;
		echo $tt;
		for($i = 1; $i <= $tt; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					echo "Masuk paeko";
					$purchase_id = $_POST['id' . $i];
					$sql_invoice = "SELECT value FROM purchases WHERE id = '" . $purchase_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] - $remaining;
					$sql = "INSERT INTO payable (purchase_id,date,value) VALUES ('$purchase_id','$date','$paid')";
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
			echo $bank_id;
			$result_update = $conn->query($sql_update);
		} else {
			echo "Ga masuk sini harusnya anjink";
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
	}
?>