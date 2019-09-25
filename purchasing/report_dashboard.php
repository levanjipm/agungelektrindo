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
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
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
	$('#report').contextmenu(function() {
		var currentMousePos = { x: -1, y: -1 };
		currentMousePos.x = event.pageX;
		currentMousePos.y = event.pageY;
		$('.context_box').css('left',currentMousePos.x);
		$('.context_box').css('top',currentMousePos.y);
		$('.context_box').fadeIn();
		
		event.preventDefault();
	});
	$('#view_monthly_span').click(function(){
		$.ajax({
			url:'purchasing_monthly_report.php',
			data:{
				supplier: $('#supplier_hidden').val(),
				year: $('#year_hidden').val(),
			},
			type:'POST',
			success:function(response){
				$('#report').html(response);
			},
		})
	});		
	$('#view_all_span').click(function(){
		$.ajax({
			url:'purchasing_report.php',
			data:{
				supplier: $('#supplier_hidden').val(),
				year: $('#year_hidden').val(),
			},
			type:'POST',
			success:function(response){
				$('#report').html(response);
				$('#supplier_hidden').val($('#supplier').val());
				$('#year_hidden').val($('#year').val());
			},
		})
	});
</script>