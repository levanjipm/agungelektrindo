<?php
	include('../codes/connect.php');
	$year 					= $_POST['year'];
	$month					= $_POST['month'];
	$sql 					= "SELECT id,name,supplier_id FROM purchases WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_archive_purchase(<?= $row['id'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-file-code-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
		<p style='font-family:bebasneue'><?= $supplier['name'] ?></p>
	</div>
<?php
	}
?>
<form action='view_purchases' method='GET' id='purchase_archieve_form' target='_blank'>
	<input type='hidden' name='id' id='purchase_id'>
</form>