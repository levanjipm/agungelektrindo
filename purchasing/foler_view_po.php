<?php
	include('../codes/connect.php');
	$year = $_POST['year'];
	$month = $_POST['month'];
	$sql = "SELECT id,name FROM code_purchaseorder WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_archive_po(<?= $row['id'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-file-code-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
	</div>
	<form action='createpurchaseorder_print.php' method='POST' id='po_archieve_form<?= $row['id'] ?>' target='_blank'>
		<input type='hidden' value='<?= $row['id'] ?>' name='id'>
	</form>
<?php
	}
?>