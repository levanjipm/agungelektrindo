<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Create sales order</title>
</head>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class="main">
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Sales Order</h2>
			<p>Create sales order</h2>
			<hr>
			<form method="POST" id="sales_order" action="sales_order_create_validation">
				<div class="row">
					<div class="col-sm-6">
						<label for="name">Customer</label>
						<select class="form-control" id="select_customer" name="select_customer"  onclick="disable_two()" onchange='show_retail()'>
						<option id="customer_one" value='0'>Please select a customer--</option>
						<option value=''>Retail</option>
							<?php
								$sql 		= "SELECT id,name,address FROM customer WHERE is_blacklist = '0' ORDER BY name ASC";
								$result 	= $conn->query($sql);
								while($row 	= mysqli_fetch_array($result)) {
									echo '<option value="' . $row["id"] . '">'. $row["name"].'</option> ';
								}
							?>
						</select>
						<label for="purchaseordernumber">Purchase Order number</label>
						<input type="name" class="form-control" id="purchaseordernumber" name="purchaseordernumber">
						<label>Label</label>
						<select class='form-control' name='label'>
							<option value='0'>--Label (optional) --</option>
							<option value='BLAPAK'>Bukalapak</option>
						</select>
						<label>Seller</label>
						<select class='form-control' name='seller'>
							<option value=''>--Seller (optional) --</option>
<?php
	$sql_seller = "SELECT id,name FROM users WHERE isactive = '1'";
	$result_seller = $conn->query($sql_seller);
	while($seller = $result_seller->fetch_assoc()){
?>
							<option value='<?= $seller['id'] ?>'><?= $seller['name'] ?></option>
<?php
	}
?>
						</select>
					</div>
					<div class="col-sm-6">
						<label for="date">Date</label>
						<input id="today" name="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
						<label for="taxing">Taxing option</label>
						<select name="taxing" id="taxing" class="form-control" onclick="disable()">
							<option id="taxingopt_one" value="">--Please choose taxing option--</option>
							<option value="1">Tax</option>
							<option value="0">Non-Tax</option>
						</select>
						<label>Term of payment</label>
						<input type='number' class='form-control' id='customer_top' name='customer_top' readonly>
					</div>
				</div>
				<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
				<button type='button' class='button_default_dark' id='add_item_button' style='display:inline-block'>Add item</button>
				<br>
				<br>
				<table class='table table-bordered'>
					<tr>
						<th>Reference</th>
						<th>Quantity</th>
						<th>Price after tax</th>
						<th>Price list</th>
						<th>Discount</th>
						<th>Total Price</th>
					</tr>
					<tbody id='sales_order_table'>
						<tr id='tr-1'>
							<td><input id='reference1' class='form-control' name='reference[1]'></td>
							<td><input id='qty1' name='quantity[1]' class='form-control'></td>
							<td><input id='vat1' name='vat[1]' class='form-control'></td>
							<td><input id='pl1' name='pl[1]' class='form-control'></td>
							<td id='disc1'></td>
							<td id='total1'></td>
							<td></td>
						</tr>
					</tbody>
					<tfoot>	
						<tr>
							<td style='border:none;' colspan='4'></td>
							<td>Total</td>
							<td id="grand_total"></td>
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
				<div class="row">
					<div class="col-sm-6" style="padding:20px">
						<button type="button" class="button_default_dark" onclick="confirm_sales_order()" id="calculate">Calculate</button>
						<button type="button" class="button_danger_dark" style="display:none" id="back_button">Back</button>
						<button type="button" class="button_success_dark" style="display:none" id="submitbtn" onclick="validate_sales_order()">Submit</button>	
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<input type='hidden' id='check_available_input' value='true'>
<input type='hidden' id='check_duplicate_input' value='true'>
<script>
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
	"<td><button type='button' class='button_delete_row' onclick='delete_row(" + a + ")'>X</button></td>"+
	"</tr>").find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "search_item.php"
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
	
	$('input[id^="reference"]').each(function(){
		$.ajax({
			url: "ajax/check_item_available.php",
			data: {
				reference: $(this).val(),
			},
			type: "POST",
			dataType: "html",
			success: function (response) {
				if((response == 1)){
					$('#check_available_input').val('false');
					return false;
				}
			},
		})
	});
	
	if ($('#select_customer').val() == "0"){
		alert("Pick a customer!");
		return false;
	} else if ($('#taxing').val() == ""){
		alert("Pick a taxing option");
		return false;
	} else {
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
		
		var total_price	= parseFloat(vat * quantity);
		
		var discount 	= 100 - (calculated_vat * 100 / pricelist);
		$('#disc' + uid).html(discount.toFixed(2) + '%');
		$('#total' + uid).html(numeral(total_price).format('0,0.00'));
		calculated_total += total_price; 
		console.log(calculated_total);
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
	} else if (isNaN($('#total_number').val())){
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
		$("#sales_order").submit();
	}
};

$("#back_button").click(function () {
	$('input').attr('readonly',false);
	$('select').attr('readonly',false);
	$('#submitbtn').hide();
	$('#back_button').hide();
	$('#calculate').show();
});

function disable(){
	document.getElementById("taxingopt_one").disabled = true;
}

function disable_two(){
	document.getElementById("customer_one").disabled = true;
}
</script>