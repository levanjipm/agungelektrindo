<?php	
	include('financialheader.php');
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-3'>
			<label>Month</label>
			<select class='form-control' id='month_start'>
<?php
	for($month = 1; $month <= 12; $month++){
?>
				<option value='<?= $month ?>'><?= date('F',mktime(0,0,0,$month)) ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-3'>
			<label>Year</label>
			<select class='form-control' id='year_start'>
<?php
	for($year = 2019; $year <= date('Y'); $year++){
?>
				<option value='<?= $year ?>'><?= $year ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-4'>
			<label>Action</label>
			<br>
			<button type='button' class='btn btn-default' id='month_button'>View monthly</button>
			<button type='button' class='btn btn-default' id='year_button'>View Yearly</button>
		</div>
	</div>
	<br><br>
	<div id='input_chart' style='padding-top:20px'>
	</div>
</div>
<script>
	$('#month_button').click(function(){
		$.ajax({
			url:"search_chart.php",
			data:{
				month: $('#month_start').val(),
				year: $('#year_start').val(),
			},
			type:"POST",
			success:function(result){
				$('#input_chart').html(result);
			}
		});
	});
	$('#year_button').click(function(){
		$.ajax({
			url:"search_chart.php",
			data:{
				month : '0',
				year: $('#year_start').val(),
			},
			type:"POST",
			success:function(result){
				$('#input_chart').html(result);
			}
		});
	});
</script>