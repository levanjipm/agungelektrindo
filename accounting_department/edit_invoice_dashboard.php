<?php
	//Editing invoices//
	include('accountingheader.php');
	if($role != 'superadmin'){
		header('location:accounting.php');
	}
?>
<div class='main'>
<h2 style='font-family:bebasneue'>Edit invoice</h2>
	<div class='row'>
		<div class='col-sm-3'>
			<select class='form-control' id='month'>
				<option value='0'>Select month</option>
				<?php
				$sql_select_month = "SELECT DISTINCT(MONTH(date)) AS month FROM invoices";
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
				$sql_select_year = "SELECT DISTINCT(YEAR(date)) AS year FROM invoices";
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
			<button type='button' class='button_default_dark' onclick='search_invoice()'>Search for invoices</button>
		</div>
	<hr>
		<div class='col-sm-12'>
			<table class='table'>
				<tr>
					<th>Invoice date</th>
					<th>Tax document</th>
					<th>Invoice number</th>
					<th>Customer</th>
					<th>Value</th>
				</tr>
				<tbody id='list'>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	function search_invoice(){
		if($('#month').val() == 0){
			alert('Please insert valid month');
		} else if($('#year').val() == 0){
			alert('Please insert valid year');
		} else {
			$.ajax({
				url:"ajax/search_edit_invoice.php",
				method: "POST",
				data: {
					month: $('#month').val(),
					year: $('#year').val()
				},
				dataType: 'html',
				success: function(response) {
                    $(list).html(response);
				}
			})
		}
	}
	function submit_form_edit(n){
		$('#form' + n).submit();
	}
</script>
	