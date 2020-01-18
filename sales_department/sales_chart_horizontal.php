<?php
	include('../codes/connect.php');
	$year			= date('Y');
	$month			= (int)date('m');
	
	$series_array	= array();
	$label_array	= array();
	
	$sql			= "SELECT customer.name, code_delivery_order.customer_id, SUM(invoices.value / 1000000) as value FROM invoices 
						JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
						JOIN customer ON customer.id = code_delivery_order.customer_id
						WHERE MONTH(invoices.date) = '$month' AND YEAR(invoices.date) = '$year' AND code_delivery_order.company = 'AE'
						GROUP BY code_delivery_order.customer_id ORDER BY value DESC LIMIT 5";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$customer_name	= $row['name'];
		$value			= $row['value'];
		
		array_push($series_array, $value);
		array_push($label_array, $customer_name);
	};
	
	$label_array_script		= '[';
	$series_array_script	= '[';
	
	foreach($label_array as $label){
		$label_array_script .= "'" . $label . "',";
		
		next($label_array);
	}
	
	$label_array	= substr($label_array_script,0,-1) . ']';
	
	foreach($series_array as $series){
		$series_array_script .= $series . ",";
		
		next($series_array);
	}
	
	$series_array	= substr($series_array_script,0,-1) . ']';
	
?>
<div class='ct-chart' id='horizontal_chart'></div>
<script>
new Chartist.Bar('#horizontal_chart', {
	labels: <?= $label_array ?>,
	series: [<?= $series_array ?>]
}, {
	seriesBarDistance: 50,
	reverseData: true,
	horizontalBars: true,
	axisY: {
		offset: 100
	}
});
</script>