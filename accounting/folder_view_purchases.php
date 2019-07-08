<?php
	include('../codes/connect.php');
	$year = $_POST['year'];
	$month = $_POST['month'];
	$sql = "SELECT id,name,supplier_id FROM purchases WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_supplier = "SELECT name FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_archive_po(<?= $row['id'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-file-code-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
		<p style='font-family:bebasneue'><?= $customer['name'] ?></p>
	</div>
	<form action='build_invoice_print.php' method='POST' id='invoice_archieve_form<?= $row['id'] ?>' target='_blank'>
		<input type='hidden' value='<?= $row['id'] ?>' name='id'>
	</form>
<?php
	}
?>