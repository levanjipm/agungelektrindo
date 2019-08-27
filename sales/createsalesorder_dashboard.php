<?php
	include("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<link rel="stylesheet" href="css/create_quotation.css">
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
	<div class='row'>
		<div class='col-sm-12'>
			<h2 style='font-family:bebasneue'>Sales Order</h2>
			<p>Create sales order</h2>
			<hr>
			<form name="salesorder" class="form" method="POST" id="sales_order" action="createsalesorder_validation.php">
				<div class="row">
					<div class="col-sm-6">
						<label for="name">Customer</label>
						<select class="form-control" id="select_customer" name="select_customer"  onclick="disable_two()" onchange='show_retail()'>
						<option id="customer_one" value="">Please select a customer--</option>
						<option value='0'>Retail</option>
							<?php
								$sql = "SELECT id,name FROM customer ORDER BY name ASC";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									while($row = mysqli_fetch_array($result)) {
									echo '<option id="pilih" value="' . $row["id"] . '">'. $row["name"].'</option> ';
									}
								} else {
									echo "0 results";
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
					<div class="col-sm-4">
						<label for="date">Date</label>
						<input id="today" name="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
						<label for="taxing">Taxing option</label>
						<select name="taxing" id="taxing" class="form-control" onclick="disable()">
							<option id="taxingopt_one" value="">--Please choose taxing option--</option>
							<option value="1">Tax</option>
							<option value="0">Non-Tax</option>
						</select>
					</div>
				</div>
				<h4 style='font-family:bebasneue;display:inline-block;margin-right:10px'>Detail </h4>
				<button type='button' class='button_add_row' id='add_item_button' style='display:inline-block'>Add item</button>
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
							<td><input id='disc1' class='nomor' readonly></td>
							<td><input id='total1' class='nomor' readonly></td>
							<td></td>
						</tr>
					</tbody>
					<tfoot>	
						<tr>
							<td style='border:none;' colspan='4'></td>
							<td>Total</td>
							<td id="total">
							</td>
							<input type='hidden' id='total_number'/>
						</tr>
					</tfoot>
				</table>
				<div id='retails' style='display:none' >
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
						<button type="button" class="hide_note_button" onclick="confirm_sales_order()" id="calculate">Calculate</button>
						<button type="button" class="btn btn-danger" style="display:none" id="back">Back</button>
						<button type="button" class="btn btn-default" style="display:none" id="submitbtn" onclick="validate_sales_order()">Submit</button>	
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<input type='hidden' id='check_available_input' value='true'>
<script>
var a=2;

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

$("#add_item_button").click(function (){	
	$("#sales_order_table").append(
	"<tr id='tr-" + a + "'>"+
	"<td><input type='text' id='reference" + a + "' class='form-control' name='reference[" + a + "]''></td>"+
	"<td><input type='number' id='qty" + a + "' name='qty[" + a + "]' class='form-control'></td>"+
	"<td><input type='text' id='vat" + a + "' name='vat[" + a + "]'' class='form-control'></td>"+
	"<td><input type='text' id='pl" + a + "' name='pl[" + a + "]'' class='form-control'></td>"+
	"<td><input id='disc" + a + "' class='nomor' readonly></td>"+
	"<td><input id='total" + a + " class='nomor' readonly></td>"+
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
	if($('#select_customer').val() == 0){
		$('#retails').fadeIn();
	} else {
		$('#retails').fadeOut();
	}
}

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

function confirm_sales_order(){
	$('input[id^=reference]').each(function(){
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
				} else {
				}
			},
		})
	});
	
	if ($('#select_customer').val() == ""){
		alert("Pick a customer!");
		return false;
	} else if ($('#taxing').val() == ""){
		alert("Pick a taxing option");
		return false;
	} else {
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		$('#purchaseordernumber').attr('readonly',true);
		$('#taxing').attr('readonly',true);
		$('#select_customer').attr('readonly',true);
		
	var calculated_total = 0;
	$('input[id^="vat"]').each(function(){
		var input_id = $(this).attr('id');
		var vat			= $(this).val();
		var calculated_vat = evaluate_organic(input_id);
		var uid 		= input_id.substring(3,6);
		var pricelist 	= parseFloat($('#pl' + uid).val());
		var quantity	= parseFloat($('#qty' + uid).val());
		
		var total_price	= parseFloat(vat * quantity);
		
		var discount 	= calculated_vat * 100 / pricelist;
		$('#disc' + uid).val(discount.toFixed(2));
		$('#total' + uid).val(numeral(total_price).format('0,0.00'));
		calculated_total += total_price; 
		console.log(calculated_total);
	})
	$('#total_number').val(calculated_total);
	$('#total').html(numeral(calculated_total).format('0,0.00'));
}};

function validate_sales_order(){
	console.log($('#total_number').val());
	if($('#check_available_input').val() == 'false'){
		alert('One or more reference is not defined');
		return false;
	} else if (isNaN($('#total_number').val())){
		alert("insert correct price");
		$('input').each(function(){
			$(this).attr('readonly',false);
		});
		$('input[id^="total"]').each(function(){
			$(this).val('');
		});
		$('input[id^="disc"]').each(function(){
			$(this).val('');
		});
		$('#total').val('');
		$('#submitbtn').hide();
		$('#back').hide();
		$('#calculate').show();	
	} else {
		$("#sales_order").submit();
	}
};

function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}

$("#back").click(function () {
	$('input[id^="disc"]').each(function(){
		$(this).attr('readonly',false);
		var parent = $(this).parent().parent();
		var other_input = parent.find('input');
		other_input.each(function(){
			$(this).attr('readonly',false);
		})
	});
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
	$('#taxing').attr('readonly',false);
	$('#select_customer').attr('readonly',false);
	$('#purchaseordernumber').attr('readonly',false);
});

function disable(){
	document.getElementById("taxingopt_one").disabled = true;
}

function disable_two(){
	document.getElementById("customer_one").disabled = true;
}
</script>