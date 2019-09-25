<?php
	include('purchasingheader.php');
?>
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #print_page, #print_page * {
    visibility: visible;
  }
  #print_page {
    position: absolute;
    left: 0;
    top: 0;
	width:100%;
  }
}
</style>
<div class='main'>
<?php
	$supplier_id 		= $_POST['report_supplier'];
	$year 				= $_POST['report_year'];
	
	$sql_supplier 		= "SELECT name,address,city FROM supplier WHERE id = '" . $supplier_id . "'";
	$result_supplier 	= $conn->query($sql_supplier);
	$supplier 			= $result_supplier->fetch_assoc();	
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
?>
	<div id='print_page'>
		<h2 style='font-family:bebasneue'>Purchase Report</h2>
		<p>Create purchasing report</p>
		<hr>
		<h3 style='font-family:bebasneue'><?= $supplier_name?></h2>
		<p><?= $supplier_address ?></p>
		<p><?= $supplier_city ?></p>
		<p><?= $year ?></p>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<th>Date</th>
				<th>Invoice name</th>
				<th>Value</th>
			</tr>
<?php
	$total_value		= 0;
	$sql_purchase 		= "SELECT * FROM purchases WHERE supplier_id = '$supplier_id' AND YEAR(date) = '$year'";
	$result_purchase 	= $conn->query($sql_purchase);
	while($purchase 	= $result_purchase->fetch_assoc()){
		$invoice_date	= $purchase['date'];
		$invoice_name	= $purchase['name'];
		$invoice_value	= $purchase['value'];
		
		$total_value	+= $invoice_value;
?>
			<tr>
				<td><?= date('d M Y',strtotime($invoice_date)); ?></td>
				<td><?= $invoice_name ?></td>
				<td>Rp. <?= number_format($invoice_value,2) ?></td>
			</tr>
<?php
	}
?>
			<tfoot>
				<tr>
					<td></td>
					<td><strong>Total</strong></td>
					<td>Rp. <?= number_format($total_value,2) ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class='row'>
		<div class='col-xs-12' style='text-align:center'>
			<button type='button' class='button_default_dark' id='print_button'>Print</button>
		</div>
	</div>
</div>
<script>
	$('#print_button').click(function(){
		window.print();
	});
</script>