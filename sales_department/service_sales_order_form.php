<?php
	include('../codes/connect.php');
?>
<form action='service_sales_order_validation' method='POST' id='service_sales_order_form'>
<div class='row'>
	<div class='col-sm-6'>
		<label>Customer</label>
		<select class='form-control' name='customer' id='customer'>
			<option value='0'>-- Please select a customer --</option>
<?php
	$sql_customer 		= "SELECT id,name,address FROM customer WHERE is_blacklist = '0' ORDER BY name ASC";
	$result_customer 	= $conn->query($sql_customer);
	while($customer 	= $result_customer->fetch_assoc()){
?>
			<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
	}
?>
			</select>
			<label>Purchase Order number</label>
			<input type='text' class='form-control' name='po_name'>
			<label>Seller</label>
			<select class='form-control' name='seller'>
				<option value='0'>-- Optional --</option>
<?php
	$sql_seller = "SELECT id,name FROM users ORDER BY name ASC";
	$result_seller = $conn->query($sql_seller);
	while($seller = $result_seller->fetch_assoc()){
?>
				<option value='<?= $seller['id'] ?>'><?= $seller['name'] ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-4 col-sm-offset-2'>
			<label>Date</label>
			<input type='date' class='form-control' name='date' id='date'>
			<label>Taxing option</label>
			<select class='form-control' name='tax' id='tax'>
				<option value=''>--Please select a taxing option --</option>
				<option value='1'>Tax</option>
				<option value='2'>Non-tax</option>
			</select>
		</div>
	</div>
	<div class='row'>
		<div class='col-xs-12'>
		<h4 style='font-family:bebasneue;display:inline-block'>Detail </h4>
		<button type='button' class='button_default_dark' id='add_row_button'>Add item</button>
		<table class='table table-bordered'>
			<tr>
				<th style='width:25%'>Service name</th>
				<th style='width:10%'>Quantity</th>
				<th style='width:10%'>Unit</th>
				<th style='width:15%'>Price</th>
				<th style='width:20%'></th>
				<th style='width:10%'></th>
			</tr>
			<tbody id='service_body'>
				<tr>
					<td><textarea name='service_name[1]' id='service_name1' class='form-control' style='resize:none'></textarea></td>
					<td><input type='number' class='form-control' id='service_quantity1' name='service_quantity[1]'></td>
					<td><select class='form-control' id='service_unit1' name='service_unit[1]'>
						<option value='lot'>Lot</option>
						<option value='meter'>Meter</option>
						<option value='meter2'>Meter<sup>2</sup></option>
					</select></td>
					<td><input type='number' class='form-control' id='service_price1' name='service_price[1]'></td>
					<td id='service_total1'></td>
					<td></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan='3'></td>
					<td>Total</td>
					<td id='grand_total'></td>
				</tr>
			</tfoot>
		</table>
	</form>
	<hr>
	<button type='button' class='button_default_dark' id='calculate_button'>Calculate</button>
	<button type='button' class='button_danger_dark' id='back_button'	 style='display:none'>Back</button>
	<button type='button' class='button_default_dark' id='submit_button' style='display:none'>Submit</button>
<script>
var a=2;

$('#calculate_button').click(function(){
	jumlah_lot = 0;
	var grand_total = 0;
	
	$('input[id^="service_quantity"]').each(function(){
		if($(this).val() == ''){
			quantity = 0;
		} else {
			quantity = $(this).val();
		}
		jumlah_lot = parseInt(jumlah_lot) + quantity;
	});
	if($('#customer').val() == 0){
		alert('Please insert customer!');
		$('#customer').focus();
		return false;
	} else if($('#date').val() == ''){
		alert('Please insert date');
		$('#date').focus();
		return false;
	} else if($('#tax').val() == ''){
		alert('Please insert taxing option');
		$('#tax').focus();
		return false;
	} else if(jumlah_lot == 0){
		alert('Please insert correct quantity');
		return false;
	} else {
		$('input').attr('readonly',true);
		$('select').attr('readonly',true);
		$('textarea').attr('readonly',true);
		
		$('#back_button').show();
		$('#submit_button').show();
		
		$('#calculate_button').hide();
		
		$('input[id^="service_quantity"]').each(function(){
			var input_id		= $(this).attr('id');
			var uid				= input_id.substr(16,20);
			var price_input		= $('#service_price' + uid).val();
			if(price_input == ''){
				var price		= 0;
			} else {
				var price		= price_input;
			}
			
			$('#remove_button_' + uid).hide();
			
			$('#service_price' + uid).val(price);
			var total_price		= price * quantity;
			$('#service_total' + uid).html('Rp. ' + numeral(total_price).format('0,0.00'));
			
			grand_total += total_price;
		});
		
		$('#grand_total').html('Rp. ' + numeral(grand_total).format('0,0.00'));
	}
});

function remove_row(n){
	$('#tr-' + n).remove();
}

$("#add_row_button").click(function (){
	$('#service_body').append(
		"<tr id='tr-" + a + "'>"+
		"<td><textarea name='service_name[" + a + "]' id='service_name" + a + "' class='form-control' style='resize:none'></textarea></td>"+
		"<td><input type='number' class='form-control' id='service_quantity" + a + "' name='service_quantity[" + a + "]'></td>"+
		"<td><select class='form-control' id='service_unit" + a + "' name='service_unit[" + a + "]'>"+
		"<option value='lot'>Lot</option>"+
		"<option value='meter'>Meter</option>"+
		"<option value='meter2'>Meter<sup>2</sup></option>"+
		"</select></td>"+
		"<td><input type='number' class='form-control' id='service_price" + a + "' name='service_price[" + a + "]'></td>"+
		"<td id='service_total" + a + "'></td>"+
		"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")' id='remove_button_" + a + "'>X</button></td>"+
		"</tr>"
	)
	
	a++;
})

$('#back_button').click(function(){
	$('button[id^="remove_button"]').show();
	$('input').attr('readonly',false);
	$('select').attr('readonly',false);
	$('textarea').attr('readonly',false);
	
	$('#back_button').hide();
	$('#submit_button').hide();
	
	$('#calculate_button').show();
});

$('#submit_button').click(function(){
	$('#service_sales_order_form').submit();
});
</script>