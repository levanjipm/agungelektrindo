<?php
	//inputing debt document//
	include('accountingheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#supplier').autocomplete({
		source: "ajax/search_supplier.php"
	 })
});
</script>
<div class='main' style='padding-top:0'>
	<div class='row'>
		<div class='col-sm-1' style='background-color:#333'>
		</div>
		<div class='col-sm-10'>
			<form method='POST' action='debt_document_validation.php' id='debt_select_form'>
				<h2 style='font-family:bebasneue'>Debt</h3>
				<p>Input debt document</p>
				<hr>
				<label>Date</label>
				<input type="date" class='form-control' name="date" id='date'>
				<label>Vendor name</label>
				<select class='form-control' placeholder='Insert vendor name here' name='supplier' id='supplier'>
					<option value='0'>Please select a supplier</option>
<?php
			$sql_supplier 		= "SELECT name,id FROM supplier";
			$result_supplier 	= $conn->query($sql_supplier);
			while($supplier 	= $result_supplier->fetch_assoc()){
?>
					<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
			}
?>
				</select>
				<br>
				<button type='button' class='btn btn-default' onclick='search_document()'>Search Document</button>
				<br><br>
				<button type='button' class='btn btn-primary' style='display:none'>Proceed</button>
				<div id='inputs'></div>
			</form>
		</div>
		<div id='inputs'></div>
		<div class='col-sm-1' style='background-color:#333'>
		</div>
	</div>
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