<?php
	include('../codes/connect.php');
?>
<script src='/agungelektrindo/universal/jquery/jquery-3.3.0.min.js'></script>
<?php
	$ongkir 				= $_POST['delivery_fee'];
	$down_payment			= $_POST['down_payment'];
	if($down_payment		== ''){
		$down_payment		= 0;
	}
	
	$invoice_total 			= $_POST['invoice_total'];
	$delivery_order_id 		= $_POST['delivery_order_id'];
	
	$sql_update 			= "UPDATE code_delivery_order SET isinvoiced = '1' WHERE id = '" . $delivery_order_id . "'";
	$result_update 			= $conn->query($sql_update);
	
	$sql_get 				= "SELECT name, date FROM code_delivery_order WHERE id = '" . $delivery_order_id . "'";
	$result_get 			= $conn->query($sql_get);
	
	$row_get 				= $result_get->fetch_assoc();
	$date 					= $row_get['date'];

	$do_name 				= $row_get['name'];
	
	$fu_name 				= 'FU-AE-' . substr($do_name,6,100);
	
	$sql_insert 			= "INSERT INTO invoices (date,do_id,name,value,ongkir, down_payment) VALUES
								('$date','$delivery_order_id','$fu_name','$invoice_total','$ongkir', '$down_payment')";
								
	$result_insert 			= $conn->query($sql_insert);
	
	$sql_get				= "SELECT id FROM invoices WHERE do_id = '$delivery_order_id' ORDER BY id DESC LIMIT 1";
	$result_get				= $conn->query($sql_get);
	$get					= $result_get->fetch_assoc();
	
	$invoice_id				= $get['id'];
?>
	<form action='build_invoice_print' method='POST' id='forms' target='_blank'>
		<input type='hidden' value='<?= $invoice_id ?>' name='id'>
	</form>
	<script>
		$(document).ready(function(){
			$('#forms').submit();
		});
		setTimeout(function(){
			window.location.href='/agungelektrindo/accounting';
		},125);
	</script>
	