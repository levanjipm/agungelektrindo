<?php
	include('../codes/connect.php');
	$sql 			= "SELECT DISTINCT(YEAR(invoices.date)) AS year FROM invoices 
						JOIN code_delivery_order ON invoices.do_id = delivery_order.id
						WHERE code_delivery_order.company = 'AE'
						ORDER BY invoices.date DESC";
	$result 		= $conn->query($sql);
	while($row 		= $result->fetch_assoc()){
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_month(<?= $row['year'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-folder-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['year'] ?></p>
	</div>
<?php
	}
?>