<?php
	include('../codes/connect.php');
	$year			= (int)$_POST['year'];
	$sql_month 		= "SELECT DISTINCT(MONTH(invoices.date)) AS month FROM invoices 
						JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
						WHERE YEAR(invoices.date) = '$year' AND code_delivery_order.company = 'AE' AND invoices.isconfirm = '1' ORDER BY invoices.date ASC";
	$result_month 	= $conn->query($sql_month);
	while($month 	= $result_month->fetch_assoc()){
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_po(<?= $month['month'] ?>,<?= $_POST['year'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-folder-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= date('F',mktime(0,0,0,$month['month'])) . "-" . $_POST['year'] ?></p>
	</div>
<?php
	}
?>
