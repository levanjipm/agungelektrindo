<?php
	include('../codes/connect.php');
	$x							= 1;
	$month 						= (int) $_POST['month'];
	$year 						= (int) $_POST['year'];
	$sql_search 				= "SELECT purchases.*, supplier.name as supplier_name
									FROM purchases 
									JOIN supplier ON purchases.supplier_id = supplier.id
									WHERE MONTH(date) = '$month' AND YEAR(date) = '$year' AND isconfirm = '1' ORDER BY date ASC, name ASC";
	$result_search 				= $conn->query($sql_search);
	if(mysqli_num_rows($result_search) == 0){
?>
	<p style='font-family:museo'>There is no data found</p>
<?php
	} else {
		$journal_value			= 0;
?>
	<h2 style='font-family:bebasneue'>Purchase Report</h2>
	<p style='font-family:museo'><?= date('F Y',mktime(0,0,0,$month,1,$year)) ?></p>
	
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Date</th>
				<th>Tax document</th>
				<th>Invoice document</th>
				<th>Supplier</th>
				<th>Value</th>
			</tr>
		</thead>
<?php				
	while($row_search 			= $result_search->fetch_assoc()){
		$faktur					= $row_search['faktur'];
		$name					= $row_search['name'];
		$supplier_name			= $row_search['supplier_name'];
		$value					= $row_search['value'];

		$document_name			= $row_search['name'];
		if($row_search['faktur'] == ''){
			$tax_document		= 'Non taxable';
		} else {
			$tax_document		= $row_search['faktur'];
		}
		
		$journal_value			+= $value;
?>
		<tr>
			<td><?= date('d M Y',strtotime($row_search['date'])); ?></td>
			<td><?= $tax_document ?></td>
			<td><?= $document_name ?></td>
			<td><?= $supplier_name ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan='3'></td>
			<td><strong>Total</strong></td>
			<td>Rp. <?= number_format($journal_value,2) ?></td>
		</tr>
	</table>
	<button type='button' class='button_success_dark hidden-print' onclick='window.print()'><i class='fa fa-print'></i></button>
<?php
	}
?>