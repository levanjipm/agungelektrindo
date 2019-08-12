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
		$date = $_POST['date'];
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
					
					$remaining = $_POST['remaining' . $i];
					$paid = $invoice['value'] + $invoice['ongkir'] - $total_receivable - $remaining;//Nominal yang dibayarkan pada invoice tersebut//

					$sql = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
					VALUES ('$date','$paid','$transaction','$opponent_id','$opponent_type','1','$bank_id')";//Input nominal tersebut ke code_bank//
					$conn->query($sql);
					
					$sql_get = "SELECT id FROM code_bank ORDER BY id DESC LIMIT 1";
					$result_get = $conn->query($sql_get);
					$get = $result_get->fetch_assoc();//Ambil hasil input terakhir//
					
					$last_id = $get['id'];
					
					$sql = "INSERT INTO receivable (invoice_id,date,value,bank_id) VALUES ('$invoice_id','$date','$paid','$last_id')";
					$result = $conn->query($sql);//Masukkan nilai tersebut ke piutang//
					
					if($remaining == 0){
						$update_invoice = "UPDATE invoices SET isdone = '1', date_done = '" . $date . "' WHERE id = '" . $invoice_id . "'";
						$conn->query($update_invoice);//Apabila sudah lunas, update invoice//
					}
				$uang = $uang - $paid;
				}
				if($uang == 0){
					$sql_update = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
					$result_update = $conn->query($sql_update);
				} else {
					$yangdiassign = $value_awal - $uang;
					$sql_delete = "UPDATE code_bank SET isdelete = '1' WHERE id = '" . $bank_id . "'";
					
					$sql_insert2 = "INSERT INTO code_bank (date,value,transaction,bank_opponent_id,label,isdone,major_id)
					VALUES ('$date','$uang','$transaction','$opponent_id','$opponent_type','0','$bank_id')";

					$result_2 = $conn->query($sql_insert2);
					$result_delete = $conn->query($sql_delete);
				}
			}
		}
		// header('location:accounting.php');
	} else if($transaction == 1){ //Debit -> keluar duit//
		print_r($_POST);
		$date = $_POST['date'];
		echo $date;
		for($i = 1; $i <= $x; $i++){
			if(array_key_exists('check'.$i, $_POST)){
				if($_POST['check' . $i] == 'on'){
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
	// header('location:accounting.php');
?>