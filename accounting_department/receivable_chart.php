<?php
	include('../codes/connect.php');
	
	$series_array	= array();
	$label_array	= array();
	
	$sql_invoice 				= "SELECT SUM(invoices.value + invoices.ongkir) AS jumlah, code_delivery_order.customer_id, invoices.id, customer.name 
									FROM invoices 
									JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									JOIN customer ON code_delivery_order.customer_id = customer.id
									WHERE invoices.isdone = '0'
									GROUP BY code_delivery_order.customer_id ORDER BY jumlah DESC LIMIT 5";
	$result_invoice 			= $conn->query($sql_invoice);
	while($invoice 				= $result_invoice->fetch_assoc()){
		$customer_name			= $invoice['name'];
		$customer_id			= $invoice['customer_id'];
		$invoice_value			= $invoice['jumlah'];
		$sql_receive 			= "SELECT SUM(receivable.value) AS bayar_total FROM receivable 
									JOIN invoices ON receivable.invoice_id = invoices.id 
									JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
									WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.isdone = '0'";
		$result_receive 		= $conn->query($sql_receive);
		$receive		 		= $result_receive->fetch_assoc();
		$payment_received		= $receive['bayar_total'];
		
		$invoice_payment		= ($invoice_value - $payment_received) / 1000000;
		
		array_push($label_array, $customer_name);
		array_push($series_array, $invoice_payment);
	};
	
	$label_array_script	= '[';
	$series_array_script	= '[';
	
	foreach($label_array as $label){
		$label_array_script .= "'" . $label . "',";	
		next($label_array);
	}
	
	$label_array	= substr($label_array_script,0,-1) . ']';
	
	foreach($series_array as $series){
		$series_array_script	.= $series . ",";
		
		next($series_array);
	}
	
	$series_array	= substr($series_array_script,0,-1) . ']';
?>
<style>
.ct-series-a .ct-line {
	stroke: #2B3940;
	stroke-width: 5px;
}

.ct-series-a .ct-bar {
	stroke: #2B3940;
	stroke-width: 20px;
}
</style>
<h2 style='font-family:bebasneue'>Top 5 receivable</h2>
<div class='ct-chart' id='receivable'></div>
<script>
new Chartist.Bar('#receivable', {
  labels: <?= $label_array ?>,
  series: [
    <?= $series_array ?>
  ]
}, {
  seriesBarDistance: 10,
  reverseData: true,
  horizontalBars: true,
  axisY: {
    offset: 70
  }
});

</script>