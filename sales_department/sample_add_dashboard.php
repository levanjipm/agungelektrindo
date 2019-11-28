<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Add sample data</title>
	<link rel='stylesheet' href='css/create_sample.css'></script>
</head>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Add sampling</p>
	<hr>
	<form action='sample_add_validate' method='POST' id='add_sample_form'>
		<label>Customer</label>
		<select class='form-control' name='customer' id='customer'>
			<option value='0'>Please pick a customer</option>
<?php	
	$sql_customer = "SELECT id,name FROM customer ORDER BY name ASC";
	$result_customer = $conn->query($sql_customer);
	while($customer = $result_customer->fetch_assoc()){
?>
			<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
	}
?>
		</select>
		<br>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_add_row' id='add_item_button' style='display:inline-block'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
			</tr>
			<tbody id='sample_detail'>
				<tr>
					<td><input type='text' class='form-control' id='reference1' name='reference[1]'></td>
					<td><input type='number' class='form-control' name='quantity[1]'></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<button type='button' class='button_default_dark' onclick='submiting()'>
			Submit
		</button>
	</form>
</div>
<script>
var a = 2;
$('#add_item_button').click(function(){
	$('#sample_detail').append(
		"<tr id='tr-" + a + "'>" +
		"<td><input type='text' class='form-control' id='reference" + a + "' name='reference[" + a + "]'></td>"+
		"<td><input type='number' class='form-control' name='quantity[" + a + "]'></td>"+
		"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")'>X</button></td>"+
		"</tr>"
	);
	$('#reference' + a).autocomplete({
		source: "../codes/search_item.php"
	 })
	a++;
});

function remove_row(n){
	$('#tr-' + n).remove();
}

function submiting(){
	if($('#customer').val() == 0){
		alert('Please insert a customer!');
		$('#customer').focus();
		return false;
	} else {
		$('#add_sample_form').submit();
	}
}
</script>