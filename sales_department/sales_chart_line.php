<?php
	include('../codes/connect.php');
	
	$series_array_1_raw	= array();
	$series_array_2_raw	= array();
	$label_array_raw	= array();
	
	$sql			= "SELECT MONTH(invoices.date) as month, YEAR(invoices.date) as year FROM invoices 
						JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
						GROUP BY YEAR(invoices.date) DESC, MONTH(invoices.date) DESC LIMIT 10 OFFSET 1";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		
		$month		= $row['month'];
		$year		= $row['year'];	
		
		$sql_value_ae		= "SELECT SUM(invoices.value / 1000000) as value FROM invoices 
								JOIN code_delivery_order ON code_delivery_order.id = invoices.do_id
								WHERE MONTH(invoices.date) = '$month' AND YEAR(invoices.date) = '$year' AND code_delivery_order.company = 'AE'";
		$result_value_ae	= $conn->query($sql_value_ae);
		$row_value_ae		= $result_value_ae->fetch_assoc();
		
		$value_ae			= $row_value_ae['value'];
		
		$label				= date('M Y', mktime(0,0,0,$month, 10, $year));
		
		array_push($label_array_raw, $label);
		array_push($series_array_1_raw, $value_ae);
		
		$label_array	= array_reverse($label_array_raw);
		$series_array_1	= array_reverse($series_array_1_raw);
	};
	
	$label_array_script	= '[';
	$series_array_script_1	= '[';
	
	foreach($label_array as $label){
		$label_array_script .= "'" . $label . "',";
		
		next($label_array);
	}
	
	$label_array	= substr($label_array_script,0,-1) . ']';
	
	foreach($series_array_1 as $series_1){
		$series_array_script_1	.= $series_1 . ",";
		
		next($series_array_1);
	}
	
	$series_array_1	= substr($series_array_script_1,0,-1) . ']';
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
<div class='ct-chart' id='chart_line'></div>
<script>
var chart = new Chartist.Line('#chart_line', {
	labels: <?= $label_array ?>,
	series: [
	<?= $series_array_1 ?>
	],
}, {
  low: 0,
  showArea: false,
  showPoint: false,
  fullWidth: true
});


chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 3000 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});
</script>