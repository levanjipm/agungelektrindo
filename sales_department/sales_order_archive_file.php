<?php
	include('../codes/connect.php');
	$year = $_POST['year'];
	$month = $_POST['month'];
	$sql = "SELECT id,name,customer_id FROM code_salesorder WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_sales_order_archive(<?= $row['id'] ?>)'>
		<h1 style='font-size:4em;text-align:center'><i class="fa fa-file-code-o" aria-hidden="true"></i></h1>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
		<p style='font-family:bebasneue'><?= $customer['name'] ?></p>
	</div>
<?php
	}
?>
<form action='sales_order_archive_print' method='POST' id='sales_order_archive_form' target='_blank'>
	<input type='hidden' id='sales_order_id' name='id'>
</form>