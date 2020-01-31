<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Create good receipt</title>
</head>
<div class='main'>
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style=';font-family:bebasneue'>Good receipt</h2>
			<p style='font-family:museo'>Create new good receipt</p>
			<hr>
			<form id='good_receipt_form' method='POST' action='good_receipt_create_validate'>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>Supplier</label>
						<select class="form-control" name="supplier" id="supplier" onclick="disable()" required>
							<option id="kosong">--Please Select a supplier--</option>
<?php
	$sql_incomplete_supplier	= "SELECT DISTINCT(code_purchaseorder.supplier_id) as id, supplier.name FROM code_purchaseorder JOIN
								purchaseorder ON purchaseorder.purchaseorder_id = code_purchaseorder.id JOIN
								supplier ON code_purchaseorder.supplier_id = supplier.id
								WHERE purchaseorder.status = '0'";
	$result_supplier	= $conn->query($sql_incomplete_supplier);
	while($supplier		= $result_supplier->fetch_assoc()){
		$supplier_id	= $supplier['id'];
		$supplier_name	= $supplier['name'];
?>
		<option value='<?= $supplier_id ?>'><?= $supplier_name ?></option>
<?php } ?>
						</select>
						<label for="name">Purchase Order number</label>
						<select class="form-control" name="po" id="po">
							<option id="kosong">--Pelase select a purchase order to receive--</option>
						</select>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-2 col-sm-offset-0 col-xs-offset-0">
						<label for="date">Delivery order date</label>
						<input type="date" class="form-control" required name="date"></input>
					</div>
				</div>
				<br>
				<button type="submit" class="button_default_dark">View Uncompleted Items</button>
			</form>
		</div>
	</div>
</div>
<script>
function disable(){
	document.getElementById("kosong").disabled = true;
}

$(document).ready(function() {
	$("#supplier").change(function(){
		var options = {
			url: "Ajax/search_incomplete_po.php",
			type: "POST",
			data: {id:$('#supplier').val()},
			success: function(result){
				$("#po").html(result);
			}};
		$.ajax(options);
	});
});
</script>
</body>
</html>