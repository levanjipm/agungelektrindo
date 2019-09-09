<?php
	include("purchasingheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<link rel="stylesheet" href="css/create_purchase_order.css">
<script src="../jquery-ui.js"></script>
<script src="../universal/Numeral-js-master/numeral.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class="main">
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p>Creating new purchase order</p>
	<hr>
	<br>
	<form id="purchaseorder" method="POST" action="createpurchaseorder_validation.php" style="font-family:sans-serif">
		<div class="row">
			<div class="col-sm-5">
				<label for="name">Order to</label>
				<select class="form-control" id="selectsupplier" name="selectsupplier"  onclick="disable()">
				<option id="kosong" value="">--Please Select a supplier--</option>
					<?php
						$sql = "SELECT id,name,address FROM supplier ORDER BY name";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = mysqli_fetch_array($result)) {
							echo '<option id="pilih" value="' . $row["id"] . '">'. $row["name"].'</option> ';
							}
						}
					?>
				</select>
				<label>Promo Code</label>
				<input type="text" class="form-control" name="code_promo" placeholder="Promo code">
				<label for="top">Payement Terms:</label>
				<input class="form-control" id="top" value="30" name="top" style='width:75%;display:inline-block;' required>
				<span style='width:20%;display:inline-block;'>Days</span>	
			</div>
			<style>
			.form-radio
			{
				-webkit-appearance: none;
				-moz-appearance: none;
				appearance: none;
				display: inline-block;
				position: relative;
				background-color: #f1f1f1;
				color: #666;
				top: 10px;
				height: 30px;
				width: 30px;
				border: 0;
				border-radius: 50px;
				cursor: pointer;     
				margin-right: 7px;
				outline: none;
				transition:0.3s all ease;
			}
			
			.form-radio:checked::before{
				position: absolute;
				font: 13px/1 'Open Sans', sans-serif;
				left: 11px;
				top: 7px;
				content: '\02143';
				transform: rotate(40deg);
				outline:none;
			}
			
			.form-radio:hover{
				background-color: #ddd;
			}
			
			.form-radio:checked{
				background-color: #f1f1f1;
			}
			
			.check_box_wrapper label{
				font: 13px/1.7 'Open Sans', sans-serif;
				color: #333;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
				cursor: pointer;
				padding-right:20px;
			}
		</style>
			<div class="col-sm-5 col-sm-offset-1">
				<label for="date">Date</label>
				<input id="today" name="today" type="date" class="form-control" value="<?= date('Y-m-d');?>">
				<label>Send date</label>
				<input type='date' class='form-control' name='sent_date' id='sent_date'>
				<div class='check_box_wrapper'>
					<input type="radio" name="delivery_date" checked value='1' class='form-radio'><label>Insert date</label>
					<input type="radio" name="delivery_date" value='2' class='form-radio'><label>Unknown date</label>
					<input type="radio" name="delivery_date" value='3' class='form-radio'><label>Urgent delivery</label>
				</div>
			</div>
		</div>
		<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
		<button type='button' class='button_add_row' id='add_item_button' style='display:inline-block'>Add item</button>
		<br>
		<br>
		<table class='table table-bordered'>
			<tr>
				<th style='width:20%'>Reference</th>
				<th style='width:20%'>Price</th>
				<th style='width:10%'>Discount</th>
				<th style='width:10%'>Quantity</th>
				<th>Net price</th>
				<th>Total price</th>
			</tr>
			<tbody id='purchaseorder_tbody'>
				<tr id='tr-1'>
					<td><input id="reference1" class="form-control ref" name="reference[1]"></td>
					<td><input type='text' id="price1" name="price[1]" class="form-control" step=".001"></td>
					<td><input type='number' id="discount1" class="form-control" name="discount[1]" step=".001"></td>
					<td><input type='number' id="quantity1" class="form-control" name="quantity[1]"></input></td>
					<td id='net_price-1'></td>
					<td id='total_price-1'></td>
					<td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td style='border:none' colspan='4'></td>
					<td>Total</td>
					<td id='total_number'></td>
					<input type='hidden' id="grand_total" readonly></input>
				</tr>
		</table>
		<div class='row'>
			<div class='col-sm-8'>
				<div class='check_box_wrapper'>
					<input type="radio" name="optradio" checked value='1' 	onchange='delivery_option()' class='form-radio'><label>Default</label>
					<input type="radio" name="optradio" value='2' 			onchange='delivery_option()' class='form-radio'><label>As dropshiper</label>
				</div>
				<br><br>
				<div id='dropshiper_delivery' style='display:none'>
					<label>Name</label>
					<input type='text' class='form-control' name='dropship_name' id='dropship_name'>
					<label>Delivery address:</label>
					<input type='text' class='form-control' name='dropship_address' id='dropship_address'>
					<label>City</label>
					<input type='text' class='form-control' name='dropship_city' id='dropship_city'>
					<label>Phone number</label>
					<input type='text' class='form-control' name='dropship_phone' id='dropship_phone'>
				</div>
			</div>
			<script>
				function delivery_option(){
					if($('input[name=optradio]:checked').val() == 1){
						$('#dropshiper_delivery').fadeOut();
					} else {
						$('#dropshiper_delivery').fadeIn();
					}
				}
			</script>
		</div>
		<div class='row' style='padding:20px'>
			<label>Note</label>
			<textarea class="form-control" rows="5" form="purchaseorder" name='note' style='resize:none'></textarea>
		</div>
		<br><br>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" class="button_default_dark" onclick="hitung()" id="calculate">Calculate</button>
				<input type='hidden' value='false' id='input_duplicate'>
				<input type='hidden' value='false' id='input_discount'>
				<input type='hidden' value='false' id='input_quantity'>
				<input type='hidden' value='false' id='input_reference'>
			</div>
		</div>
		<div class="row" style="padding-top:20px">
			<div class="col-sm-6">
				<button type='button' class="button_danger_dark" 	id="back" 		style="display:none">Back</button>
				<button type='button' class="button_success_dark"	id="submitbtn" 	style='display:none'>Submit</button>
			</div>
		</div>
	</form>
</div>
<script>
var i;
var a=2;

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

function disable(){
	document.getElementById("kosong").disabled = true;
}
$("#add_item_button").click(function (){	
	$("#purchaseorder_tbody").append(
	"<tr id='tr-" + a + "'>"+
	"<td><input id='reference" + a + "' class='form-control' name='reference[" + a + "]'></td>"+
	"<td><input type='text' id='price" + a + "' class='form-control' name='price[" + a + "]'></td>"+
	"<td><input type='number' id='discount" + a + "' class='form-control' name='discount[" + a + "]'></td>"+
	"<td><input type='number' id='quantity" + a + "' class='form-control' name='quantity[" + a + "]'></td>"+
	"<td id='net_price-" + a + "'></td>"+
	"<td id='total_price-" + a + "'></td>"+
	"<td><button type='button' class='button_delete_row' onclick='delete_row(" + a + ")'>X</button></td>"+
	'</tr>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "../codes/search_item.php"
	 });
	a++;
});

function delete_row(n){
	$('#tr-' + n).remove();
};

function hitung(){
	var reference_array = [];
	var calculated_total = 0;
	$('#input_duplicate').val('false');
	$('#input_discount').val('false');
	$('#input_quantity').val('false');
	$('#input_reference').val('false');
	
	$('input[id^="reference"]').each(function(){
		$.ajax({
			url:"../codes/check_item_availability.php",
			data:{
				reference: $(this).val()
			},
			success:function(response){
				if(response == 0){
					$('#input_reference').val('true');
				}
			},
			type:'POST'
		});
		
		var reference_value = $(this).val();
		if (reference_array.indexOf(reference_value) == -1){
			reference_array.push(reference_value);
		} else {
			$('#input_duplicate').val('true');
		}
	});
	
	$('input[id^="discount"]').each(function(){
		var discount_value = $(this).val();
		if (discount_value == '' || discount_value > 100){
			$('#input_discount').val('true');
		}
	});
	
	$('input[id^="quantity"]').each(function(){
		var quantity_value = $(this).val();
		if (quantity_value == '' || quantity_value <= 0){
			$('#input_quantity').val('true');
		}
	});

	$('input[id^=price]').each(function(){
		var input_id = $(this).attr('id');
		var calculated_pricelist = evaluate_organic(input_id);
		$(this).val(evaluate_organic(input_id));
		
		var uid 		= input_id.substring(5,8);
		
		if($('#discount' + uid).val() == ''){
			var discount = 0;
		} else {
			var discount = $('#discount' + uid).val();
		}
		
		var netprice 	= parseFloat(calculated_pricelist * (1 - discount*0.01));
		var totalprice 	= parseFloat(netprice * $('#quantity' + uid).val());
		
		$('#net_price-' + uid).html(numeral(netprice).format('0,0.00'));
		$('#total_price-' + uid).html(numeral($('#quantity' + uid).val() * netprice).format('0,0.00'));
		calculated_total = parseFloat(calculated_total + totalprice);
	});
	
	$('#grand_total').val(calculated_total);
	$('#total_number').html(numeral(calculated_total).format('0,0.00'));
	if($('#selectsupplier').val() == 0){
		alert("Please insert a supplier");
	} else if(isNaN ($('#grand_total').val())){
		alert("Insert correct price");
		return false;
	} else if($('input[name=optradio]:checked').val() == 2 && $('#dropship_address').val() == '' && $('#dropship_phone').val() == '' && $('#dropship_name').val() == '' && $('#dropship_city').val() == ''){
		alert('Insert valid delivery address for dropship!');
		return false;
	} else if($('input[name=delivery_date]:checked').val() == 1 && ($('#sent_date').val() == '' || $('#today').val() == '')){
		alert('Please insert date!');
		return false;
	} else{
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		
		$('input').attr('readonly',true);
	}
};

$('#submitbtn').click(function(){
	if($('#input_duplicate').val() == 'true'){
		alert('We found a duplicate reference');
		$('#back').click();
	} else if($('#input_quantity').val() == 'true'){
		alert('Error on quantity');
		$('#back').click();
	} else if($('#input_discount').val() == 'true'){
		alert('Error on discount value');
		$('#back').click();
	} else if($('#input_reference').val() == 'true'){
		alert('One or more reference not found!');
		$('#back').click();
	} else {
		$('#purchaseorder').submit();
	}
});

$("#back").click(function () {
	$('input').attr('readonly',false);
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
});
</script>