<?php
	include('salesheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<div class='row'>
		<div class='col-sm-10'>
			<h2 style='font-family:bebasneue'>Sales order</h2>
			<p>Create <strong>Service</strong> sales order</p>
			<hr>
			<form action='service_sales_order_validation.php' method='POST' id='service_sales_order_form'>
			<div class='row'>
				<div class='col-sm-6'>
					<label>Customer</label>
					<select class='form-control' name='customer' id='customer'>
						<option value='0'>-- Please select a customer --</option>
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
			<hr>
			<div class='row' style='text-align:center'>
				<div class='col-sm-1'>
					No.
				</div>
				<div class='col-sm-4'>
					Service name
				</div>
				<div class='col-sm-2'>
					Quantity
				</div>
				<div class='col-sm-3'>
					Price
				</div>
			</div>
			<div class='row' style='text-align:center'>
				<div class='col-sm-1'>
					1
				</div>
				<div class='col-sm-4'>
					<textarea class='form-control' rows='2' name='descriptions[1]' form='service_sales_order_form'></textarea>
				</div>
				<div class='col-sm-2'>
					<input type='number' class='form-control' name='quantities[1]' id='quantity1'>
				</div>
				<div class='col-sm-3'>
					<input type='number' class='form-control' name='prices[1]'>
				</div>
			</div>
			<div id='input_list'></div>
			</form>
			<hr>
			<div class='row'>
				<div class='col-sm-2 col-sm-offset-7'>
					Total
				</div>
				<div class='col-sm-3' id='total'></div>
			</div>
			<button type='button' class='btn btn-default' id='calculate_button'>Calculate</button>
		</div>
	</div>
<script>
var i;
var a=2;
var jumlah_lot;
var quantity;

$('#calculate_button').click(function(){
	jumlah_lot = 0;
	$('input[id^="quantity"]').each(function(){
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
		$('#service_sales_order_form').submit();
	}
});
$("#close").click(function () {
	if(a>2){
	a--;
	x = 'barisan' + a;
	$("#"+x).remove();
	} else {
		return false;
	}
});
$("#folder").click(function (){
	$("#input_list").append(
	'<div class="row" style="padding-top:10px;text-align:center" id="barisan'+a+'">'+
	'<div class="col-sm-1">'+a+'</div>'+
	'<div class="col-sm-4"><textarea name="descriptions['+a+']" class="form-control" rows="2" form="service_sales_order_form"></textarea></div>'+
	'<div class="col-sm-2"><input class="form-control" name="quantities['+a+']"></div>'+
	'<div class="col-sm-3"><input type="number" class="form-control" name="prices[' + a + ']"></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "search_item.php"
	 });
	a++;
});
</script>