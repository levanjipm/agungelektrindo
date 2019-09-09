<?php
	include("accountingheader.php");
?>
<script src='../universal/Numeral-js-master/numeral.js'></script>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../Codes/search_item.php"
	 })
});
</script>
<div class="main">
	<h2 style='font-family:bebasneue'>Random Invoice</h2>
	<p>Create <i>Proforma Invoice</i></h2>
	<hr>
	<form method="POST" id="proforma_invoice_form" action="build_proforma_invoice_validation.php" method='POST'>
		<div class="row">
			<div class="col-sm-6">
				<label>Proforma Invoice type</label>
				<select class='form-control' name='proforma_invoice_type' id='proforma_invoice_type'>
					<option value='1'>Down payment</option>
					<option value='2'>Repayment</option>
					<option value='3'>Full payment</option>
				</select>
				<label for="name">Customer</label>
				<select class="form-control" id="select_customer" name="select_customer">
				<option id="customer_one" value="">Please select a customer--</option>
					<?php
						$sql = "SELECT id,name FROM customer";
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
			</div>
			<div class="col-sm-4 col-sm-offset-1">
				<label>Date</label>
				<input id="invoice_date" name="invoice_date" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
				<label>Taxing</label>
				<select class='form-control' name='taxing' id='taxing'>
					<option value=''>-- Please insert taxing --</option>
					<option value='1'>Tax</option>
					<option value='0'>Non tax</option>
				</select>
			</div>
		</div>
		<br>
		<div class='row'>
			<div class='col-xs-12'>
				<h4 style='font-family:bebasneue;display:inline-block'>Detail </h4>
				<button type='button' class='button_default_dark' style='display:inline-block' id='add_row_button'>Add row</button>
				<table class='table table-bordered'>
					<tr>
						<th>Reference</th>
						<th>Quantity</th>
						<th>VAT</th>
						<th>Total price</th>
					</tr>
					<tbody id='proforma_table_body'>
						<tr>
							<td><input id="reference1" 	class="form-control"	 name="reference[1]"></td>
							<td><input id="quantity1" 	class="form-control"	 name="quantity[1]" ></td>
							<td><input id="price1" 		class="form-control"	 name="price[1]" ></td>
							<td id='total1'></td>
						</tr>
					</tbody>
					<tfoot id='proforma_table_footer'>
						<tr>
							<td colspan='2'></td>
							<td>Total</td>
							<td id='grand_total'></td>
							<input type='hidden' id='grand_total_number'>
						</tr>
						<tr id='down_payment_tr'>
							<td colspan='2'></td>
							<td id='down_payment_label'>Down Payment</td>
							<td><input type='number' class='form-control' id='down_payment' name='down_payment' readonly></td>
						</tr>
						<tr id='billed_tr'>
							<td colspan='2'></td>
							<td>Billed</td>
							<td id='billed_payment'></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-6" style="padding:20px">
				<button type="button" class="button_default_dark" id="calculate_button">Calculate</button>
				<button type="button" class="button_danger_dark" style="display:none" id="back_button">Back</button>
				<button type="button" class="button_default_dark" style="display:none" id="submit_form_button">Submit</button>	
			</div>
		</div>
	</form>
</div>
<input type='hidden' value='true' id='check_reference'>
<input type='hidden' value='true' id='check_quantity'>
<script>
var a = 2;
var grand_total;

function evaluate_organic(x){
	var to_be_evaluated = $('#' + x).val();
	return eval(to_be_evaluated);
}

$('#select_customer').click(function(){
	$('#customer_one').attr('disabled',true);
});

$("#add_row_button").click(function (){	
	$("#proforma_table_body").append(
	"<tr id='tr-" + a + "'>"+
	"<td><input id='reference" + a + "' 	class='form-control'	 name='reference[" + a + "]'></td>"+
	"<td><input id='quantity" + a + "' 	class='form-control'	 name='quantity[" + a + "]' ></td>"+
	"<td><input id='price" + a + "'		class='form-control'	 name='price[" + a + "]' ></td>"+
	"<td id='total" + a + "'></td>"+
	"<td><button type='button' class='button_danger_dark' onclick='remove_row(" + a + ")'>X</button></td>"+
	"</tr>");
	
	$("#reference" + a).autocomplete({
		source: "../codes/search_item.php"
	});
	
	a++;
});

function remove_row(n){
	$('#tr-' + n).remove();
}

$('#proforma_invoice_type').change(function(){
	if($(this).val() == '1'){
		$('#down_payment_label').html('Down payment');
		$('#down_payment_tr').show();
		$('#billed_tr').show();
	} else if($(this).val() == '2'){
		$('#down_payment_label').html('Paid in advance');
		$('#down_payment_tr').show();
		$('#billed_tr').show();
	} else {
		$('#down_payment_tr').hide();
		$('#billed_tr').hide();
	}
});

$('#calculate_button').click(function(){
	$('#check_reference').val('true');
	$('#check_quantity').val('true');
	var grand_total = 0;
	
	if($('#select_customer').val() == ''){
		alert('Please select a customer');
		$('#select_customer').focus();
		return false;
	} else if($('#taxing').val() == ''){
		alert('Please select a taxing option');
		$('#taxing').focus();
		return false;
	}
	$('input[id^="reference"]').each(function(){
		var input_id	= $(this).attr('id');
		var uid			= input_id.substr(9,15);
		var quantity	= $('#quantity' + uid).val();
		var price		= evaluate_organic('price' + uid);
		var total_price	= quantity * price;
		
		grand_total += total_price;
		
		if(quantity <= 0){
			$('#check_quantity').val('false');
		}
		
		$('#total' + uid).html(numeral(total_price).format('0,0.00'))
		
		$.ajax({
			url:'../codes/check_item_availability.php',
			data:{
				reference:$(this).val()
			},
			dataType: "html",
			success:function(response){
				if(response == 0){
					alert('Reference not found');
					$('#check_reference').val('false');
					return false;
				}
			},
			type:"POST",
		});
	})
	
	if(isNaN(grand_total)){
		alert('Please insert a correct price');
		return false;
	} else {
		$('#grand_total').html(numeral(grand_total).format('0,0.00'));
		$('#grand_total_number').val(grand_total);
		$('#calculate_button').hide();
		$('#back_button').show();
		$('#submit_form_button').show();
		$('input').attr('readonly',true);
		$('select').attr('readonly',true);
		$('#down_payment').attr('readonly',false);
	}
});

$('#back_button').click(function(){
	$('#calculate_button').show();
	$('#back_button').hide();
	$('#submit_form_button').hide();
	$('input').attr('readonly',false);
	$('select').attr('readonly',false);
	$('#down_payment').attr('readonly',true);
});

$('#submit_form_button').click(function(){
	if($('#check_quantity').val() == 'false'){
		alert('Please insert valid quantity');
		$('#back_button').click();
		return false;
	} else if($('#check_reference').val() == 'false'){
		alert('Please insert valid quantity');
		$('#back_button').click();
		return false;
	} else if(parseInt($('#grand_total_number').val()) < parseInt($('#down_payment').val()) && $('#proforma_invoice_type').val() != 3){
		alert('Please insert valid billed invoice');
		return false;
	} else {
		$('#proforma_invoice_form').submit();
	}
});
</script>