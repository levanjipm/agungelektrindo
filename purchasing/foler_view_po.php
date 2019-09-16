<?php
	include('../codes/connect.php');
	$year = $_POST['year'];
	$month = $_POST['month'];
	$sql = "SELECT id,name,supplier_id FROM code_purchaseorder WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier = $conn->query($sql_supplier);
		$supplier = $result_supplier->fetch_assoc();
		
		$sql_check_closed = "SELECT id FROM closed_purchaseorder WHERE purchaseorder_id = '" . $row['id'] . "'";
		$result_check_closed = $conn->query($sql_check_closed);
		$isclosed = mysqli_num_rows($result_check_closed);
		$sql_done = "SELECT SUM(status) AS status, COUNT(id) AS parameter FROM purchaseorder WHERE purchaseorder_id = '" . $row['id'] . "'";
		$result_done = $conn->query($sql_done);
		$done = $result_done->fetch_assoc();
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer;text-align:center' ondblclick='view_archive_po(<?= $row['id'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-file-code-o" aria-hidden="true"></i>
		</h1>
<?php
	if($isclosed == 1){
?>
		<div class='closed_flag'>
			Closed
		</div>
<?php
	} else if($done['status'] == $done['parameter']){
?>
		<div class='done_flag'>
			Done
		</div>
<?php
	}
?>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
		<p style='font-family:bebasneue'><?= $supplier['name'] ?></p>
	</div>
	<form action='createpurchaseorder_print.php' method='POST' id='po_archieve_form<?= $row['id'] ?>' target='_blank'>
		<input type='hidden' value='<?= $row['id'] ?>' name='id'>
	</form>
<?php
	}
?>