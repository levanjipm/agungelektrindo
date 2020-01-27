<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<script>
	$('#purchase_invoice_side').click();
	$('#debt_document_dashboard').find('button').addClass('activated');
	
$( function() {
	$('#supplier').autocomplete({
		source: "ajax/search_supplier.php"
	 })
});
</script>
<head>
	<title>Input debt document</title>
</head>
<div class='main'>
	<form method='POST' action='debt_document_validation' id='debt_select_form'>
		<h2 style='font-family:bebasneue'>Debt</h3>
		<p>Input debt document</p>
		<hr>
		<label>Date</label>
		<input type="date" class='form-control' name="date" id='date'>
		<label>Vendor name</label>
		<select class='form-control' placeholder='Insert vendor name here' name='supplier' id='supplier'>
			<option value='0'>Please select a supplier</option>
<?php
			$sql_supplier 		= "SELECT name,id FROM supplier ORDER BY name";
			$result_supplier 	= $conn->query($sql_supplier);
			while($supplier 	= $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
			}
?>
		</select>
		<br>
		<button type='button' class='button_default_dark' onclick='search_document()'>Search Document</button>
		<br><br>
		<div id='inputs'></div>
	</form>
</div>
<script>
	function search_document(){
		if($('#supplier').val() == 0){
			alert('Insert correct supplier!');
			return false;
		} else {
			$.ajax({
				url: "ajax/search_debts.php",
			data: {
				date : $('#date').val(),
				supplier : $('#supplier').val()
			},
			type: "POST",
			dataType: "html",
			success: function (data) {
				$('#inputs').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
			}
			})
		}
	}
</script>