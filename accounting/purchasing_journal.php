<?php
	//Purchasing journal//
	include('accountingheader.php');
?>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchasing Journal</h2>
	<p>View purchasing journal monthly</p>
	<hr>
	<div class='row'>
		<div class='col-sm-3'>
			<select class='form-control' id='month'>
				<option value='0'>Select month</option>
				<?php
				$sql_select_month = "SELECT DISTINCT(MONTH(date)) AS month FROM purchases";
				$result_select_month = $conn->query($sql_select_month);
				while($row_select_month = $result_select_month->fetch_assoc()){
				?>
				<option value='<?= $row_select_month['month']; ?>'><?= date('F',mktime(0,0,0,$row_select_month['month'],10)); ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class='col-sm-3'>
			<select class='form-control' id='year'>
				<option value='0'>Select year</option>
				<?php
				$sql_select_year = "SELECT DISTINCT(YEAR(date)) AS year FROM purchases";
				$result_select_year = $conn->query($sql_select_year);
				while($row_select_year = $result_select_year->fetch_assoc()){
				?>
				<option value='<?= $row_select_year['year']; ?>'><?= $row_select_year['year'] ?></option>
				<?php
				}
				?>
			</select>
		</div>
		<div class='col-sm-3'>
			<button type='button' class='btn btn-primary' onclick='search_invoice()'>Show Purchase Journal</button>
		</div>
		<hr>
	</div>
	<div id='printable'>
		<div class='container' id='head_print' style='display:none'>
			<h2>Purchase Journal</h2>
			<p id='masa'></p>
		<hr>
		</div>
		<table class='table'>
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
			<button type='button' class='btn btn-default hidden-print' onclick='printing()'>Print</button>
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
				url:"ajax/search_purchase_journal.php",
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