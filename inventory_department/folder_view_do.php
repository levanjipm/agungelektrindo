<?php
	include('../codes/connect.php');
	$year 					= $_POST['year'];
	$month 					= $_POST['month'];
	$sql 					= "SELECT id,name,customer_id FROM code_delivery_order WHERE MONTH(date) = '" . $month . "' AND YEAR(date) = '" . $year . "' AND company = 'AE' ORDER BY number";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_delivery_order(<?= $row['id'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-file-code-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['name'] ?></p>
		<p style='font-family:bebasneue'><?= $customer['name'] ?></p>
	</div>
<?php
	}
?>
<form action='delivery_order_print' method='POST' id='delivery_order_form' target='_blank'>
	<input type='hidden' name='id' id='delivery_order_id'>
</form>