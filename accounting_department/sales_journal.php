<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Sales journal</title>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-4'>
			<h2 style='font-family:bebasneue'>Sales Journal</h2>
			<p>View sales journal monthly</p>
		</div>
		<div class='col-sm-3'>
			<select class='form-control' id='month'>
				<option value='0'>Select month</option>
<?php
	for($i = 1; $i <= 12; $i++){
?>
				<option value='<?= $i ?>'><?= date('F',mktime(0,0,0,$i,1)) ?></option>
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
?>
				<option value='<?= $row_select_year['year']; ?>'><?= $row_select_year['year'] ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-2'>
			<button type='button' class='button_default_dark' onclick='search_invoice()'>Seach</button>
		</div>
	</div>
	<hr>
	<div id='printable'>
		<div class='container' id='head_print' style='display:none'>
			<h2>Sales Journal</h2>
			<p id='masa'></p>
		<hr>
		</div>
		<table class='table table-bordered'>
			<tr>
				<th>Date</th>
				<th>Tax document</th>
				<th>Invoice number</th>
				<th>Customer</th>
				<th>Value</th>
			</tr>
			<tbody id='list'>
			</tbody>
			<tfoot>
				<td></td>
				<td></td>
				<td></td>
				<td>Total</td>
				<td id='totals'></td>
			</tfoot>
		</table>
	</div>
	<div class='row'>
		<div class='col-sm-2 col-sm-offset-5'>
			<button type='button' class='button_success_dark hidden-print' onclick='printing()'><i class="fa fa-print" aria-hidden="true"></i></button>
		</div>
	</div>
	<script>
	function search_invoice(){
		var total = 0;
		if($('#month').val() == 0){
			alert('Please insert valid month');
		} else if($('#year').val() == 0){
			alert('Please insert valid year');
		} else {
			$.ajax({
				url:"ajax/search_sales_journal.php",
				method: "POST",
				data: {
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'html',
				success: function(response) {
					$('#list').html(response);
					$('input[id^="value"]').each(function(){
						total = total + parseInt($(this).val());
					});
					$('#totals').html('Rp. ' + numeral(total).format('0,0.00'));
				}
			})
		}
	}
	function printing(){
		var months = [ "January", "February", "March", "April", "May", "June", 
           "July", "August", "September", "October", "November", "December" ];
		var selectedMonthName = months[document.getElementById('month').value - 1];
		var selectedyear = document.getElementById('year').value;
		document.getElementById('masa').innerHTML = selectedMonthName + ' ' + selectedyear;
		document.getElementById('head_print').style.display = 'block';
		var printContents = document.getElementById('printable').innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
	</script>