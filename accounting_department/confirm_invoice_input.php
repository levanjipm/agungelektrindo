<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<?php
include('../codes/connect.php');
if(empty($_POST['invoice_id'])){
	header('location:/agungelektrindo/accounting');
} else {
	$id 			= $_POST['invoice_id'];
	if(!empty($_POST['faktur'])){
		$faktur 	= $_POST['faktur'];
		$sql_update = "UPDATE invoices SET isconfirm = '1', faktur = '" . $faktur . "' WHERE id = '" . $id . "'";
	} else {
		$sql_update = "UPDATE invoices SET isconfirm = '1' WHERE id = '" . $id . "'";
	}
	
	$conn->query($sql_update);
?>
<form action='build_invoice_print' method='POST' id='forms' target='_blank'>
	<input type='hidden' value='<?= $id ?>' name='id'>
</form>
<script>
	$(document).ready(function(){
		$('#forms').submit();
	});
	setTimeout(function(){
		window.location.href='/agungelektrindo/accounting';
	},125);
</script>
<?php
	}
?>
	