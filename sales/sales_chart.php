<?php
	include('../codes/connect.php');
	$date_30 = date('Y-m-d',strtotime('-30 days',strtotime($_POST['date'])));
?>
<style>
	.bar_wrapper{
		position:relative;
		display:inline-block;
	}
	.chart_bar{
		position:relative;
		display:inline-block;
	}
	.chart_bar:hover{
		background-color:rgba(50, 107, 199,1)!important;
		transition:0.3s background-color ease;
		display:inline-block;
		position:relative;
	}
	.points{
		background-color:none;
		border-radius:50%;
		border:2px solid rgba(50,107,199);
		width:5px;
		height:5px;
		position:absolute;
	}
	.day_wrap{
		position:absolute;
	}
</style>
<div class='row'>
	<div class='col-sm-12' id='width_control'>
<?php
	$maximum_scale_cumulative = 0;
	for($i = 0; $i <= 30; $i++){
		$date = date('Y-m-d',strtotime("+" . $i . " day", date(strtotime($date_30))));
		$sql_max = "SELECT SUM(value) AS maximum FROM invoices WHERE date = '" . $date . "'";
		$result_max = $conn->query($sql_max);
		$max = $result_max->fetch_assoc();
		$maximum_scale_cumulative = $max['maximum'] + $maximum_scale_cumulative;
	}
	$maximum_sales = 0;
	for($i = 0; $i <= 30; $i++){
		$date = date('Y-m-d',strtotime("+" . $i . " day", date(strtotime($date_30))));
		$sql_max = "SELECT SUM(value) AS maximum FROM invoices WHERE date = '" . $date . "'";
		$result_max = $conn->query($sql_max);
		$max = $result_max->fetch_assoc();
		if($max['maximum'] > $maximum_sales){
			$maximum_sales = $max['maximum'];
		}
	}
	$pembagi = $maximum_sales/300;
	$value_before = 0;
	$daily_sales_cumulative = 0;
	for($i = 0; $i <= 30; $i++){
		$date = date('Y-m-d',strtotime("+" . $i . " day", date(strtotime($date_30))));
		$sql_value = "SELECT SUM(value) AS daily_sales FROM invoices WHERE date = '" . $date . "'";
		$result_value = $conn->query($sql_value);
		$value = $result_value->fetch_assoc();
		$daily_sales = $value['daily_sales'];
		$daily_sales_cumulative = $daily_sales_cumulative + $value['daily_sales'];
		$day = date('d',strtotime($date));
?>
		<div id='<?= $i ?>' class='bar_wrapper'>
			<div data-html="true" class='chart_bar' style='height:<?= max(10,200 * $daily_sales / $maximum_sales) ?>px;background-color:rgba(56, 118, 217,<?= $i / 30 ?>);width:100%' data-toggle="tooltip" title='hooray'></div>
		</div>
		<div data-html="true" class='points' id='point-<?= $i ?>' style='bottom:<?= max(20,200 * $daily_sales_cumulative / $maximum_scale_cumulative) ?>px'	data-toggle="tooltip" title='daniel'></div>
		<div class='day_wrap' id='day-<?= $i ?>'>
			<?= $day ?>
		</div>
<?php
	$value_before = $daily_sales;
	}
?>
	</div>
</div>
<script>
	var chart_width = $('#width_control').innerWidth() / 40;
	var chart_position = $('#width_control').position();
	var chart_left = chart_position.left;
	$('.chart_bar').each(function(){
		$(this).parent().css('width',chart_width);
	});
	$('.chart_bar').each(function(){
		var parent = $(this).parent().attr('id');
		$('#point-' + parent).css('left',parseInt(parent * chart_width + chart_width + 4*parent));
		$('#day-' + parent).css('left',parseInt(parent * chart_width + chart_width + 4*parent));
	});
</script>