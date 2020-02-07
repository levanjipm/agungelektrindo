<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Sales journal</title>
</head>
<style>
	@media print {
		body * {
		visibility: hidden;
		}
		
		#printable, #printable * {
			visibility: visible;
		}
		#printable {
			position: absolute;
			left: 0;
			top: 0;
			width:100%;
		}
	}
</style>
<div class='main'>
	<div class='row'>
		<div class='col-sm-3'>
			<h2 style='font-family:bebasneue'>Sales Journal</h2>
			<p>View sales journal monthly</p>
		</div>
		<div class='col-sm-3'>
			<select class='form-control' id='month'>
				<option value='0'>Select month</option>
<?php
	for($i = 1; $i <= 12; $i++){
?>
				<option value='<?= $i ?>' <?php if($i == date('m')){ echo 'selected'; } ?>><?= date('F',mktime(0,0,0,$i,1)) ?></option>
<?php 
	}
?>
			</select>
		</div>
		<div class='col-sm-3'>
			<select class='form-control' id='year'>
				<option value='0'>Select year</option>
<?php
	$sql_select_year 		= "SELECT DISTINCT(YEAR(date)) AS year FROM invoices";
	$result_select_year 	= $conn->query($sql_select_year);
	while($row_select_year 	= $result_select_year->fetch_assoc()){
		$year				= $row_select_year['year'];
?>
				<option value='<?= $year ?>' <?php if($year == date('Y')){ echo 'selected'; } ?>><?= $row_select_year['year'] ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-2'>
			<select class='form-control' id='company'>
				<option value=''>Show all</option>
				<option value='AE'>Agung Elektrindo</option>
				<option value='DSE'>Duta Sapta Energi</option>
			</select>
		</div>
		<div class='col-sm-1'>
			<button type='button' class='button_default_dark' onclick='search_invoice()'><i class='fa fa-search'></i></button>
		</div>
	</div>
	<hr>
	<div id='printable'>
	</div>
	<script>
	$(document).ready(function(){
		search_invoice()
	});
	
	function search_invoice(){
		var total = 0;
		if($('#month').val() == 0){
			alert('Please insert valid month');
			return false;
		} else if($('#year').val() == 0){
			alert('Please insert valid year');
			return false;
		} else {
			$.ajax({
				url:"sales_journal_view.php",
				method: "POST",
				data: {
					month: $('#month').val(),
					year: $('#year').val(),
					company:$('#company').val(),
				},
				beforeSend:function(){
					$('.loading_wrapper_initial').fadeIn();
				},
				success: function(response) {
					$('.loading_wrapper_initial').fadeOut();
					$('#printable').html(response);
				}
			})
		}
	}
	</script>