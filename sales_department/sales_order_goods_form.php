<?php
	include('../codes/connect.php');
?>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<form method='POST' id='sales_order_create_form' action='sales_order_create_validation'>
	<div class='row'>
		<div class='col-sm-6'>
			<label for="name">Customer</label>
			<select class="form-control" id="select_customer" name="select_customer"  onclick="disable_option('customer_select_default')" onchange='show_retail()'>
				<option value='0' id='customer_select_default'>-- Please select a customer --</option>
				<option value=''>Retail</option>
<?php
	$sql_customer 		= "SELECT id,name FROM customer WHERE is_blacklist = '0' ORDER BY name ASC";
	$result_customer 	= $conn->query($sql_customer);
	while($customer 	= mysqli_fetch_array($result_customer)) {
		$customer_id	= $customer['id'];
		$customer_name	= $customer['name'];
?>
				<option value='<?= $customer_id ?>'><?= $customer_name ?></option>
<?php
	}
?>
			</select>
			<label>Purchase Order number</label>
			<input class='form-control' name='purchase_order_name'>
			
			<label>Label</label>
			<select class='form-control' name='label'>
				<option value='0'>-- Label (optional) --</option>
				<option value='BLAPAK'>Bukalapak</option>
			</select>
			
			<label>Seller</label>
			<select class='form-control' name='seller'>
				<option value=''>-- Optional --</option>
<?php
	$sql_seller 		= "SELECT id,name FROM users WHERE isactive = '1'";
	$result_seller 		= $conn->query($sql_seller);
	while($seller 		= $result_seller->fetch_assoc()){
?>
				<option value='<?= $seller['id'] ?>'><?= $seller['name'] ?></option>
<?php
	}
?>
			</select>
		</div>
		<div class='col-sm-6'>
			<label>Date</label>
			<input id='sales_order_date' name='sales_order_date' type="date" class='form-control' value="<?php echo date('Y-m-d');?>">
			
			<label>Taxing option</label>
			<select name='taxing' id='taxing' class='form-control' onclick="disable_option('taxing_option_default')">
				<option id='taxing_option_default' value="">-- Please choose taxing option --</option>
				<option value="1">Tax</option>
				<option value="0">Non-Tax</option>
			</select>
			
			<label>Term of payment</label>
			<input type='number' class='form-control' id='customer_top' name='customer_top' readonly>
			<br>
		</div>
	</div>
	<br>
	<button type='button' class='button_default_dark' id='add_item_button' style='display:inline-block'>Add item</button>
	<br><br>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Quantity</th>
				<th>Price after tax</th>
				<th>Price list</th>
				<th>Discount</th>
				<th>Total Price</th>
			</tr>
		</thead>
		<tbody id='sales_order_table'>
			<tr id='tr-1'>
				<td><input id='reference1' 	name='reference[1]'	class='form-control' ></td>
				<td><input id='qty1' 		name='quantity[1]' 	class='form-control'></td>
				<td><input id='vat1' 		name='vat[1]' 		class='form-control'></td>
				<td><input id='pl1' 		name='pl[1]' 		class='form-control'></td>
				<td id='disc1'></td>
				<td id='total1'></td>
				<td><button type='button' class='button_danger_dark' style='visibility:hidden'><i class='fa fa-trash'></i></button></td>
			</tr>
		</tbody>
		<tfoot>	
			<tr>
				<td style='border:none;' colspan='4'></td>
				<td>Total</td>
				<td id='grand_total'></td>
				<input type='hidden' id='total_number'/>
			</tr>
		</tfoot>
	</table>
	<div id='retails' style='display:none'>
		<label>Name (Not required)</label>
		<input type='text' class='form-control' name='retail_name'>
		<div class="form-group">
			<label>Delivery Address (Not required)</label>
			<textarea class="form-control" rows="3" id="comment" name='retail_address' form='sales_order' style='resize:none'></textarea>
		</div>
		
		<label>City (Not required)</label>
		<input type='text' class='form-control' name='retail_city'>
		
		<label>Phone (Not required)</label>
		<input type='text' class='form-control' name='retail_phone'>
	</div>
	<button type='button' class="button_default_dark" 	onclick="confirm_sales_order()" id="calculate">Calculate</button>
	<button type='button' class="button_danger_dark" 	style="display:none" id="back_button">Back</button>
	<button type='button' class="button_success_dark" 	style="display:none" id="submitbtn" onclick="validate_sales_order()">Submit</button>	
	<input type='hidden' id='check_available_input' value='true'>
	<input type='hidden' id='check_duplicate_input' value='true'>
	<input type='hidden' id='check_quantity_input' value='true'>
	<input type='hidden' id='check_price_input' value='true'>
</form>
<script>
$(document).ready(function() {
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});
var a = 2;

$("#add_item_button").click(function (){	
	$("#sales_order_table").append(
	"<tr id='tr-" + a + "'>"+
	"<td><input type='text' id='reference" + a + "' class='form-control' name='reference[" + a + "]''></td>"+
	"<td><input type='number' id='qty" + a + "' name='quantity[" + a + "]' class='form-control'></td>"+
	"<td><input type='text' id='vat" + a + "' name='vat[" + a + "]'' class='form-control'></td>"+
	"<td><input type='text' id='pl" + a + "' name='pl[" + a + "]'' class='form-control'></td>"+
	"<td id='disc" + a + "'></td>"+
	"<td id='total" + a + "'></td>"+
	"<td><button type='button' class='button_danger_dark delete_button' onclick='delete_row(" + a + ")'><i class='fa fa-trash'></i></button></td>"+
	"</tr>").find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "../codes/search_item.php"
	 });
	a++;
});

function delete_row(n){
	$('#tr-' + n).remove();
}

function show_retail(){
	if($('#select_customer').val() == ''){
		$('#retails').fadeIn();
		$('#customer_top').attr('readonly',true);
		$('#customer_top').val(0);
	} else {
		$('#retails').fadeOut();
		$.ajax({
			url	:'sales_order_customer_top.php',
			data:{
				customer_id:$('#select_customer').val(),
			},
			type:'GET',
			success:function(response){
				$('#customer_top').val(response);
				$('#customer_top').attr('readonly',false);
			},
		});
	}
}

function confirm_sales_order(){
	var reference_array = [];
	$('#check_available_input').val('true');
	$('#check_duplicate_input').val('true');
	$('#check_quantity_input').val('true');
	$('#check_price_input').val('true');
	
	$('input[id^="reference"]').each(function(){
		$.ajax({
			url: "../codes/check_item_availability.php",
			data: {
				reference: $(this).val(),
			},
			type: "POST",
			success: function (response) {
				if((response == 0)){
					$('#check_available_input').val('false');
					return false;
				}
			},
		})
	});
	
	$('input[id^="qty"]').each(function(){
		if($(this).val() <= 0){
			$('#check_quantity_input').val('false');
			return false;
		}
	});
	
	$('input[id^="vat"]').each(function(){
		if($(this).val() < 0){
			$('#check_price_input').val('false');
			return false;
		}
	});
	
	if ($('#select_customer').val() == "0"){
		alert("Pick a customer!");
		return false;
	} else if ($('#taxing').val() == ""){
		alert("Pick a taxing option");
		return false;
	} else {
		$('#add_item_button').hide();
		$('.delete_button').hide();
		$('#submitbtn').show();
		$('#back_button').show();
		$('#calculate').hide();
		
	var calculated_total = 0;
	
	$('input[id^="vat"]').each(function(){
		var input_id 		= $(this).attr('id');
		var vat				= $(this).val();
		var calculated_vat 	= evaluate_organic(input_id);
		var uid 			= input_id.substring(3,6);
		var pricelist 		= parseFloat($('#pl' + uid).val());
		var quantity		= parseFloat($('#qty' + uid).val());
		
		$(this).val(calculated_vat);
		
		var total_price		= parseFloat(vat * quantity);
		
		var discount 		= 100 - (calculated_vat * 100 / pricelist);
		$('#disc' + uid).html(discount.toFixed(2) + '%');
		$('#total' + uid).html(numeral(total_price).format('0,0.00'));
		calculated_total 	+= total_price; 
	})
	
	$('input').attr('readonly',true);
	$('select').attr('readonly',true);
	$('#total_number').val(calculated_total);
	$('#grand_total').html(numeral(calculated_total).format('0,0.00'));
}};


function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

function validate_sales_order(){
	if($('#check_available_input').val() == 'false'){
		alert('One or more reference is not defined');
		return false;
	} else if($('#check_duplicate_input').val() == 'false'){
		alert('There is a duplicate detected');
		return false;
	} else if($('#check_quantity_input').val() == 'false'){
		alert('Please insert correct quantity');
		return false;
	} else if($('#check_price_input').val() == 'false'){
		alert('please insert correct price');
		return false;
	} else if(isNaN($('#total_number').val())){
		alert("insert correct price");
		$('input').attr('readonly',false);
		$('input[id^="total"]').each(function(){
			$(this).val('');
		});
		$('input[id^="disc"]').each(function(){
			$(this).val('');
		});
		
		$('#total').val('');
		$('#submitbtn').hide();
		$('#back_button').hide();
		$('#calculate').show();	
	} else {
		$("#sales_order_create_form").submit();
	}
};

$("#back_button").click(function () {
	$('input').attr('readonly',false);
	$('select').attr('readonly',false);
	$('#add_item_button').show();
	$('.delete_button').show();
	$('#submitbtn').hide();
	$('#back_button').hide();
	$('#calculate').show();
});

function disable_option(string){
	$('#' + string).attr('disabled',true);
};
</script>