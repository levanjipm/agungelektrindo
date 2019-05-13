<script src='../universal/Jquery/jquery-3.3.0.min.js'></script>
<?php
	//Getting the purchaseorder id to be closed//
	include('../codes/connect.php');
	if(empty($_POST['po_id'])){
		header('location:purchasing.php');
	}
	$po_id = $_POST['po_id'];
	$sql_code = "UPDATE code_purchaseorder SET isclosed = '1' WHERE id = '" . $po_id . "'";
	$result_code = $conn->query($sql_code);
	$sql_update = "UPDATE purchaseorder_received SET status = '1' WHERE status = '0' AND purchaseorder_id = '" . $po_id . "'";
	$result_update = $conn->query($sql_update);
	if($result_update){
		$sql_insert = "INSERT INTO closed_purchaseorder (purchaseorder_id,closed_date) VALUES ('$po_id',CURDATE())";
		echo $sql_insert;
		$result_insert = $conn->query($sql_insert);
?>
		<form method='POST' action='closing_statement.php' id='form' target='_blank'>
			<input type='hidden' value='<?= $po_id ?>' name='po_id'>
		</form>
		<script>
			$(document).ready(function(){
				$('#form').submit()
			})
		</script>
<?php
		header('location:close_purchaseorder_dashboard.php?alert=true');
	} else {
		header('location:close_purchaseorder_dashboard.php?alert=false');
	}
?>