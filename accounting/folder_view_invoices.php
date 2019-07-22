<?php
	include('../codes/connect.php');
	$year = $_POST['year'];
	$month = $_POST['month'];
	$sql = "SELECT invoices.id ,invoices.name, code_delivery_order.customer_id
	FROM invoices 
	JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
	WHERE MONTH(invoices.date) = '" . $month . "' AND YEAR(invoices.date) = '" . $year . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
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