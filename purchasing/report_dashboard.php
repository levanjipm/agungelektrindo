<?php
	include('purchasingheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Report</h2>
	<p>Create purchasing report</p>
	<hr>
	<label>Supplier</label>
	<form action='report' method='POST' id='report_form'>
		<select class='form-control' name='report_supplier' id='report_supplier'>
			<option value='0'>--Please select a supplier</option>
<?php
	$sql_supplier 		= "SELECT id,name FROM supplier ORDER BY name";
	$result_supplier 	= $conn->query($sql_supplier);
	while($supplier 	= $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
		</select>
		<label>Month</label>
		<select class='form-control' name='report_month'>
			<option value='0'>Show all</option>
<?php
	for($month	= 1; $month <= 12; $month++){
?>
			<option value='<?= $month ?>'><?= date('F',mktime(0,0,0,$month,1,date('Y'))) ?></option>
<?php
	}
?>
		</select>
		<label>Year</label>
		<select class='form-control' id='report_year' name='report_year'>
<?php
	$sql 		= "SELECT DISTINCT(YEAR(date)) AS year FROM purchases";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
?>
			<option value='<?= $row['year'] ?>'><?= $row['year'] ?></option>
<?php
	}
?>
		</select>
	</form>
	<button type='button' class='button_default_dark' id='submit_report_button'>Submit</button>
</div>
<script>
	$('#submit_report_button').click(function(){
		if($('#report_supplier').val() == 0){
			alert('Please select a supplier');
			$('#report_supplier').focus();
			return false;
		} else {
			$('#report_form').submit();
		}
	});
	
	$('div').not('.context_box').click(function(){
		$('.context_box').fadeOut();
	});
</script>