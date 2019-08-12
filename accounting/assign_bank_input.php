<?php
	include('../codes/connect.php');
	$bank_id = $_POST['bank_id'];
	
	$sql_bank = "SELECT * FROM code_bank WHERE id = '" . $bank_id . "'";
	$result_bank = $conn->query($sql_bank);
	$bank = $result_bank->fetch_assoc();
	
	$id = $bank['id'];
	$date = $bank['date'];
	$transaction = $bank['transaction'];
	$opponent_id = $bank['bank_opponent_id'];
	$opponent_type = $bank['label'];
	
	$value_awal = $bank['value'];
	$uang = $bank['value'];
	
	$x = $_POST['tt'];
	$i = 1;
	if($transaction == 2){ //Kredit ->masuk duit//
		$will_be_paid = 0;
		$date = $_POST['date'];
		for($i = 1; $i <= $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					$invoice_id = $_POST['id' . $i];
					$remaining = $_POST['remaining' . $i];
					
					$sql_invoice = "SELECT value FROM invoices WHERE id = '" . $invoice_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$sql_receivable = "SELECT SUM(value) AS paid FROM receivable WHERE invoice_id = '" . $invoice_id . "'";
					$result_receivable = $conn->query($sql_receivable);
					$receivable = $result_receivable->fetch_assoc();
					$received = ($receivable['paid'] == NULL) ? 0: $receivable['paid'];
					
					$will_be_paid =  $will_be_paid + $invoice['value']  - $received - $remaining;
					
				}
			}
		}
		if($will_be_paid == 0){
			$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_update);
		} else {
			$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_delete);
			
			$value_insert_2 = $uang - $will_be_paid;
			$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$value_insert_2','$transaction','$opponent_id','$opponent_type','0','$bank_id')";
			$conn->query($sql_insert2);
			
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$will_be_paid','$transaction','$opponent_id','$opponent_type','1','$bank_id')";
			$conn->query($sql_insert1);
			
			$sql_get_code_bank_id = "SELECT id FROM code_bank ORDER BY id DESC LIMIT 1";
			$result_get_code_bank_id = $conn->query($sql_get_code_bank_id);
			$get_code_bank_id = $result_get_code_bank_id->fetch_assoc();
			
			$bank_id = $get_code_bank_id['id'];
		}
		for($i = 1; $i < $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					$invoice_id = $_POST['id' . $i];//Invoice yang dibayarkan//
					$sql_invoice = "SELECT value,ongkir FROM invoices WHERE id = '" . $invoice_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();//Ambil nominal invoice total//
					
					$sql_receivable = "SELECT SUM(value) AS received FROM receivable WHERE invoice_id = '" . $invoice_id . "'";
					$result_receivable = $conn->query($sql_receivable);
					$receivable = $result_receivable->fetch_assoc();
					
					$total_receivable = $receivable['received'];
					
					$sql_returned = "SELECT SUM(value) AS returned FROM return_invoice_sales WHERE invoice_id = '" . $invoice_id . "'";
					$result_returned = $conn->query($sql_returned);
					$returned_row = $result_returned->fetch_assoc();
					$returned = $returned_row['returned'];
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] + $invoice['ongkir'] - $total_receivable - $returned - $remaining;
					//Nominal yang dibayarkan pada invoice tersebut//
					
					$sql = "INSERT INTO receivable (invoice_id,date,value,bank_id) VALUES ('$invoice_id','$date','$paid','$bank_id')";
					$result = $conn->query($sql);//Masukkan nilai tersebut ke piutang//
					
					if($remaining == 0){
						$update_invoice = "UPDATE invoices SET isdone = '1', date_done = '" . $date . "' WHERE id = '" . $invoice_id . "'";
						$conn->query($update_invoice);//Apabila sudah lunas, update invoice//
					}
				}
			}
		}
		header('location:accounting.php');
	} else if($transaction == 1){ //Debit -> keluar duit//
		$date = $_POST['date'];
		$will_be_paid = 0;
		for($i = 1; $i <= $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					$purchase_id = $_POST['id' . $i];
					$remaining = $_POST['remaining' . $i];
					
					$sql_invoice = "SELECT value FROM purchases WHERE id = '" . $purchase_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$sql_payable = "SELECT SUM(value) AS paid FROM payable WHERE purchase_id = '" . $purchase_id . "'";
					$result_payable = $conn->query($sql_payable);
					$payable = $result_payable->fetch_assoc();
					$paid = ($payable['paid'] == NULL) ? 0: $payable['paid'];
					
					$will_be_paid =  $will_be_paid + $invoice['value']  - $paid - $remaining;
					
				}
			}
		}
		if($will_be_paid == 0){
			$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_update);
		} else {
			$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
			$conn->query($sql_delete);
			
			$value_insert_2 = $uang - $will_be_paid;
			$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$value_insert_2','$transaction','$opponent_id','$opponent_type','0','$bank_id')";
			$conn->query($sql_insert2);
			
			$sql_insert1 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
			VALUES ('$date','$will_be_paid','$transaction','$opponent_id','$opponent_type','1','$bank_id')";
			$conn->query($sql_insert1);
			
			$sql_get_code_bank_id = "SELECT id FROM code_bank ORDER BY id DESC LIMIT 1";
			$result_get_code_bank_id = $conn->query($sql_get_code_bank_id);
			$get_code_bank_id = $result_get_code_bank_id->fetch_assoc();
			
			$bank_id = $get_code_bank_id['id'];
		}
		for($i = 1; $i <= $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
					$purchase_id = $_POST['id' . $i];
					$sql_invoice = "SELECT value FROM purchases WHERE id = '" . $purchase_id . "'";
					$result_invoice = $conn->query($sql_invoice);
					$invoice = $result_invoice->fetch_assoc();
					
					$sql_payable = "SELECT SUM(value) AS paid FROM payable WHERE purchase_id = '" . $purchase_id . "'";
					$result_payable = $conn->query($sql_payable);
					$payable = $result_payable->fetch_assoc();
					
					$paid_purchase = $payable['paid'];
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] - $paid_purchase - $remaining;
					
					$sql = "INSERT INTO payable (purchase_id,date,value,bank_id) VALUES ('$purchase_id','$date','$paid','$bank_id')";
					$result = $conn->query($sql);
					if($remaining == 0){
						$update_invoice = "UPDATE purchases SET isdone = '1' WHERE id = '" . $purchase_id . "'";
						$result_update = $conn->query($update_invoice);
					}
					$uang = $uang - $paid;
				}
			}
			
		}
	}
	header('location:accounting.php');
?>