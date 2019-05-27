<?php
	include('purchasingheader.php');
?>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
	<form action='purchasing_return_validation.php' method='POST' id='return_form'>
		<label>Supplier</label>
		<select class='form-control' name='supplier' id='supplier' onchange='search_date()'>
			<option value='0'>Please select a supplier</option>
<?php
	$sql_supplier = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result_supplier = $conn->query($sql_supplier);
	while($supplier = $result_supplier->fetch_assoc()){
?>
			<option value='<?= $supplier['id'] ?>'><?= $supplier['name'] ?></option>
<?php
	}
?>
		</select>
		<label>Purchase Order</label>
		<select class='form-control' id='po'>
		</select>
	<button type='button' class='btn btn-default' onclick='validation()'>Submit</button>
</div>
<script>
$(document).ready(function() {
	$("#supplier").change(function(){
		var options = {
			url: "Ajax/search_po.php",
			type: "POST",
			data: {supplier:$('#supplier').val()},
			success: function(result){
				$("#po").html(result);
			}};
		$.ajax(options);
	});
});
function validation(){
	if($('#supplier').val() == 0){
		alert('Please insert a supplier!');
		$('#supplier').focus();
		return false;
	}
	var nilai = true;
	$('input[id^=reference]').each(function(){
		if($(this).val() == ''){
			alert('Please insert a reference!');
			nilai = false;
			$(this).focus();
			return false;
		} else {
		var parent = $(this).parent();
			var quantity = parent.siblings().find("input");
			var value = quantity.val();
			if(value = 0 || value == ''){
				alert('Insert valid data!');
				nilai = false;
				quantity.focus();
				return false;
			}
		}
		if(nilai == true){
			$('#return_form').submit();
		}
	})
};
</script>