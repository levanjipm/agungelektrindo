<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/administrator_header.php');
	if($role != 'superadmin'){
?>
<script>
	window.location.href='/agungelektrindo/accounting';
</script>
<?php
	}
?>
<head>
	<title>Edit purchase order dashoard</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Edit purchase invoice</h2>
	<div class='row'>
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
		<div class='col-sm-3'>
			<button type='button' class='button_default_dark' onclick='search_invoice()'>Search for invoices</button>
		</div>
	</div>
	<br>
	<table class='table table-bordered'>
		<tr>
			<th>Invoice date</th>
			<th>Tax document</th>
			<th>Invoice number</th>
			<th>Customer</th>
			<th>Value</th>
		</tr>
		<tbody id='list'></tbody>
	</table>
</div>
<form method='POST' action='purchase_edit_validate' id='edit_invoice_form'>
	<input type='hidden' id='invoice_id' name='invoice_id'>
</form>
<script>
	function search_invoice(){
		if($('#month').val() == 0){
			alert('Please insert valid month');
		} else if($('#year').val() == 0){
			alert('Please insert valid year');
		} else {
			$.ajax({
				url:"purchase_edit_search.php",
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
		$('#invoice_id').val(n);
		$('#edit_invoice_form').submit();
	}
</script>
</div>