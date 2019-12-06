<?php
	include('accountingheader.php');
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<div class="main" style='padding-top:0;height:100%'>
		<div class='col-sm-12' style='padding:30px'>
			<h2 style='font-family:bebasneue'>Random Invoice</h2>
			<p>Create <i>Down payment</i> invoice</h2>
			<hr>
			<form method="POST" id="down_payment_form" action="down_payment_validation.php">
				<div class="row">
					<div class="col-sm-6">
						<label for="name">Customer</label>
						<select class="form-control" id="select_customer" name="select_customer"  onclick="disable_two()">
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
					<div class="col-sm-4 col-sm-offset-2">
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
				<br>
				<table class='table table-bordered'>
					<tr>
						<th>Reference</th>
						<th>Quantity</th>
						<th>VAT</th>
						<th>Price list</th>
						<th>Discount</th>
						<th>Total price</th>
					</tr>
					<tbody id='down_payment_table'>
						<tr>
							<td><input id="reference1" class="form-control" name="reference[1]"></td>
							<td><input id="qty1" name="qty[1]" class="form-control"></td>
							<td><input id="vat1" name="vat[1]" class="form-control"></td>
							<td><input id="pl1" name="pl[1]" class="form-control"></td>
							<td><input class="form-control" id="disc1" readonly name="disc[1]"></td>
							<td><input id="total1" class="form-control" readonly name="total[1]"></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td colspan='3'></td>
							<td><strong>Total</strong></td>
							<td id='grand_total' colspan='2'></td>
						</tr>
				</table>
				<div class="row">
					<div class="col-sm-12" style="padding:20px">
						<button type="button" class="button_default_dark" onclick="return validate_invoice()" id="calculate">Calculate</button>
						<button type="button" class="btn btn-danger" style="display:none" id="back">Back</button>
						<button type="button" class="btn btn-default" style="display:none" id="submitbtn" onclick="return look()">Submit</button>	
					</div>
				</div>
			</form>
		</div>
</div>
<script>
var i;
var a=2;
function disable(){
	document.getElementById("taxingopt_one").disabled = true;
}
function disable_two(){
	document.getElementById("customer_one").disabled = true;
}
function look(){
	var total = $('#total').val();
	if (isNaN(total)){
		alert("insert correct price");
		for (z = 1; z < a; z++){
			$('#vat'+ z).attr('readonly',false);
			$('#pl'+ z).attr('readonly',false);
			$('#total'+ z).val('');
			$('#disc'+ z).val('');
		}
		$('#total').val('');
		$('#submitbtn').hide();
		$('#back').hide();
		$('#calculate').show();
		$('#folder').show();
		$('#close').show();		
	} else{
		$('#down_payment_form').submit();
}};
function check_duplicate(){
	var arr = [];
	var duplicate = false;
	$('input[id^="reference"]').each(function(){
		var value = $(this).val();
		if (arr.indexOf(value) == -1){
			arr.push(value);
		} else {
			duplicate = true;
		}
	});
	return duplicate;
}
function validate_invoice(){
	var duplicate = check_duplicate();
	if ($('#select_customer').val() == ""){
		alert("Pick a customer!");
		return false;
	} else if ($('#taxing').val() == ""){
		alert("Pick a taxing option");
		return false;
	} else if(duplicate){
		alert('Cannot insert duplicate reference');
		return false;
	} else {
		$('input[id^="disc"]').each(function(){
			$(this).attr('readonly',true);
			var parent = $(this).parent().parent();
			var other_input = parent.find('input');
			other_input.each(function(){
				$(this).attr('readonly',true);
			})
		});
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		$('#purchaseordernumber').attr('readonly',true);
		$('#taxing').attr('readonly',true);
		$('#select_customer').attr('readonly',true);
		
	var calculated_total = 0;
	for (z = 1; z < a; z++){
		var raw_price = document.getElementById('vat'+z).value;
		var calculated_vat = eval(raw_price);
		document.getElementById('vat'+ z).value = round(calculated_vat,2);
		var price = document.getElementById('vat'+z).value;
		var price_list = document.getElementById('pl'+z).value;
		var calculated_pl = eval(price_list);
		var qty = document.getElementById('qty'+z).value;
		var calculated_totalunitprice = qty * calculated_vat;
		document.getElementById('total' + z).value = round(calculated_totalunitprice);
		document.getElementById('pl' + z).value = round(calculated_pl);
		var calculated_discount = (1 - price / calculated_pl) * 100;
		document.getElementById('disc'+z).value = round(calculated_discount,2);
		calculated_total = calculated_total + calculated_totalunitprice;
	
	}
	document.getElementById('total').value = round(calculated_total,2);
	document.getElementById('jumlah_barang').value = z - 1;
}};

function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}

$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1">'+a+'</div>'+
	'<div class="col-sm-2"><input id="reference'+a+'" class="form-control" style="width:100%" name="reference['+a+']"></div>'+
	'<div class="col-sm-1"><input style="overflow-x:hidden" id="qty'+a+'"" class="form-control" style="width:100%" name="qty['+a+']"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="vat'+a+'" class="form-control" style="width:100%" name="vat['+a+']"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="pl'+a+'" class="form-control" name="pl['+a+']"></div>'+
	'<div class="col-sm-1"><input class="form-control" id="disc'+a+'" readonly name="disc'+a+'">'+'</div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="total'+a+'" class="form-control" style="width:100%" readonly name="total['+a+']"></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "../codes/search_item.php"
	 });
	a++;
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

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip(); 
});
$("#back").click(function () {
	for (z = 1; z < a; z++){
		$('#vat'+ z).attr('readonly',false);
		$('#pl'+ z).attr('readonly',false);
		}
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
	$('#taxing').attr('readonly',false);
	$('#select_customer').attr('readonly',false);
	$('#purchaseordernumber').attr('readonly',false);
});
</script>
	