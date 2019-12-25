<?php
	include('../codes/connect.php');
	if(empty($_POST['id']) || empty($_POST['date'])){
		header('location:/agungelektrindo/accounting');
	} else {
		$customer_id		= $_POST['customer_id'];
		$invoice_id			= (int)$_POST['id'];
		$date 				= $_POST['date'];
		$sql_update 		= "UPDATE invoices SET isdone = '1', date_done = '$date' WHERE id = '$invoice_id'";
		$result_update 		= $conn->query($sql_update);
			
		$sql 				= "SELECT invoices.value, invoices.ongkir, code_delivery_order.customer_id
								FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
								WHERE invoices.id = '$invoice_id'";
		$result 			= $conn->query($sql);
		$row 				= $result->fetch_assoc();
			
		$value 				= $row['value'];
		$delivery_fee		= $row['ongkir'];
		
		$sql_receive 		= "SELECT SUM(value) AS jumlah_bayar FROM receivable WHERE invoice_id = '$invoice_id'";
		$result_receive 	= $conn->query($sql_receive);
		$receive 			= $result_receive->fetch_assoc();
		
		$paid 				= $receive['jumlah_bayar'];
		$dilunaskan 		= $value + $delivery_fee - $paid;
		
		$sql_insert = "INSERT INTO receivable (invoice_id,date,value) VALUES ('$invoice_id','$date','$dilunaskan')";
		$result_insert = $conn->query($sql_insert);
?>
	<script>
		window.location.href='/agungelektrindo/accounting_department/customer_view.php?id=<?= $customer_id ?>';
	</script>
<?php
	}
?>