<?php
	include('../codes/connect.php');
	$series_array_raw	= array();
	$label_array_raw	= array();
	$customer_id		= $_GET['customer_id'];
	
	for($i = 1; $i <= 6; $i ++){
		$month		= (int) date('m',strtotime('-' . $i . 'month'));
		$year		= date('Y',strtotime('-' . $i . 'month'));
	
		$sql		= "SELECT SUM(invoices.value / 1000000) as value FROM invoices 
						JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
						WHERE code_delivery_order.customer_id = '$customer_id' AND month(invoices.date) = '$month' AND year(invoices.date) = '$year'";
		$result		= $conn->query($sql);
		$row		= $result->fetch_assoc();
		
		if($row['value'] == ''){
			$value	= 0;
		} else {
			$value		= $row['value'];
		}
		
		$label		= date('M Y', mktime(0,0,0,$month, 10, $year));
		
		array_push($label_array_raw, $label);
		array_push($series_array_raw, $value);
	};
	$label_array	= array_reverse($label_array_raw);
	$series_array	= array_reverse($series_array_raw);
	
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
<script src='/agungelektrindo/universal/chartist/dist/chartist.min.js'></script>
<link rel='stylesheet' href='/agungelektrindo/universal/chartist/dist/chartist.min.css'>
<style>
.ct-label{
	color:#333;
	font-size:0.8em;
}

.ct-series-a .ct-line {
	stroke: #326d96;
	stroke-width: 5px;
}

.ct-series-a .ct-area {
	fill: #326d96;
}

.ct-series-a .ct-bar {
	stroke: #326d96;
	stroke-width: 20px;
}
</style>
<div class='ct-chart'></div>
<script>
var chart = new Chartist.Line('.ct-chart', {
  labels: <?= $label_array ?>,
  series: [
	<?= $series_array ?>
  ]
}, {
  low: 0,
  showArea: true,
  showPoint: false,
  fullWidth: true
});

chart.on('draw', function(data) {
  if(data.type === 'line' || data.type === 'area') {
    data.element.animate({
      d: {
        begin: 2000 * data.index,
        dur: 2000,
        from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
        to: data.path.clone().stringify(),
        easing: Chartist.Svg.Easing.easeOutQuint
      }
    });
  }
});
</script>