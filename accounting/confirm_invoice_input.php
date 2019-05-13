<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<?php
include('../codes/connect.php');
if(empty($_POST['invoice_id'])){
	header('location:accounting.php');
} else {
	$id = $_POST['invoice_id'];
	$taxing = $_POST['taxing'];
	if($taxing == 1){
		$faktur = $_POST['faktur'];
		$sql_update = "UPDATE invoices SET isconfirm = '1', faktur = '" . $faktur . "' WHERE id = '" . $id . "'";
	} else {
		$sql_update = "UPDATE invoices SET isconfirm = '1' WHERE id = '" . $id . "'";
	}
	$result_update = $conn->query($sql_update);
?>
<form action='build_invoice_print.php' method='POST' id='forms' target='_blank'>
	<input type='hidden' value='<?= $id ?>' name='id'>
</form>
<script>
	$(document).ready(function(){
		$('#forms').submit();
	});
	setTimeout(function(){
		window.location.replace("accounting.php");
	},125);
</script>
<?php
	}
?>
	