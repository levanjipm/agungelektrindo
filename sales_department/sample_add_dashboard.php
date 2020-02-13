<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Add sample data</title>
</head>
<script>
$('#sample_side').click();
$('#sample_add_dashboard').find('button').addClass('activated');

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
		<label>Customer</label><br>
		<select class='form-control' name='customer' id='customer' required style='display:inline-block;width:45%'>
			<option value=''>Please pick a customer</option>
<?php	
	$sql_customer 		= "SELECT id,name FROM customer ORDER BY name ASC";
	$result_customer 	= $conn->query($sql_customer);
	while($customer 	= $result_customer->fetch_assoc()){
?>
			<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
	}
?>
		</select>
		<br><br>
		<button type='button' class='button_default_dark' id='add_item_button'>Add item</button>
		
		<br><br>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
			</tr>
			<tbody id='sample_detail'>
				<tr>
					<td><input type='text' class='form-control' id='reference1' name='reference[1]' required></td>
					<td><input type='number' class='form-control' name='quantity[1]' min='0' required></td>
					<td><button type='button' class='button_success_dark' style='visibility:hidden'><i class='fa fa-trash'></i></button></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<button type='submit' class='button_default_dark'>Submit</button>
	</form>
</div>
<script>
var a = 2;
$('#add_item_button').click(function(){
	$('#sample_detail').append(
		"<tr id='tr-" + a + "'>" +
		"<td><input type='text' class='form-control' id='reference" + a + "' name='reference[" + a + "]' required></td>"+
		"<td><input type='number' class='form-control' name='quantity[" + a + "]' required min='0'></td>"+
		"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")'><i class='fa fa-trash'></i></button></td>"+
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