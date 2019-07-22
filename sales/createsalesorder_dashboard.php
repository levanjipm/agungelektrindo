<?php
	include("salesheader.php");
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
<a href="#" id="folder"><i class="fa fa-folder"></i></a>
<a href="#" id="close"><i class="fa fa-close"></i></a>
<div class="main" style='padding-top:0;height:100%'>
	<div class='row' style='height:100%'>
		<div class='col-sm-1' style='background-color:#fff'>
		</div>
		<div class='col-sm-10' style='padding:30px'>
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
						<label>Label</label>
						<select class='form-control' name='label'>
							<option value='0'>--Label (optional) --</option>
							<option value='BLAPAK'>Bukalapak</option>
						</select>
						<label>Seller</label>
						<select class='form-control' name='seller'>
							<option value=''>--Seller (optional) --</option>
<?php
	$sql_seller = "SELECT id,name FROM users";
	$result_seller = $conn->query($sql_seller);
	while($seller = $result_seller->fetch_assoc()){
?>
							<option value='<?= $seller['id'] ?>'><?= $seller['name'] ?></option>
<?php
	}
?>
						</select>
						<script>
							function show_retail(){
								if($('#select_customer').val() == 0){
									$('#retails').fadeIn();
								} else {
									$('#retails').fadeOut();
								}
							}
						</script>
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
				<div class="row" id="headerlist" style="padding-top:25px;font-family:bebasneue;text-align:center">
					<div class="col-sm-1" style="background-color:#aaa">
						Nomor
					</div>
					<div class="col-sm-2" style="background-color:#ccc">
						Refference
					</div>
					<div class="col-sm-1" style="background-color:#aaa">
						Quantity
					</div>
					<div class="col-sm-2" style="background-color:#ccc">
						Price after tax
					</div>
					<div class="col-sm-2" style="background-color:#aaa">
						Price list
					</div>
					<div class="col-sm-1" style="background-color:#ccc">
						Discount
					</div>
					<div class="col-sm-2" style="background-color:#aaa">
						Total Price
					</div>
				</div>
				<div class="row" style="padding-top:10px;">
					<div class="col-sm-1">
						1
					</div>
					<div class="col-sm-2">
						<input id="reference1" class="form-control" name="reference1" style="width:100%">
					</div>
					<div class="col-sm-1">
						<input style="overflow-x:hidden" id="qty1" name="qty1" class="form-control" style="width:100%">
					</div>
					<div class="col-sm-2">
						<input style="overflow-x:hidden" id="vat1" name="vat1" class="form-control" style="width:100%">
					</div>
					<div class="col-sm-2">
						<input style="overflow-x:hidden" id="pl1" name="pl1" class="form-control" style="width:100%">
					</div>
					<div class="col-sm-1">
						<input class="form-control" id="disc1" readonly name="disc1">
					</div>
					<div class="col-sm-2">
						<input style="overflow-x:hidden" id="total1" class="form-control" readonly name="total1">
					</div>
				</div>
				<div id="input_list">
				</div>
				<br>
				<div class="row">
					<div class="col-sm-2 offset-sm-7">
						<a href="#" data-toggle="tooltip" data-placement="bottom" title="Check the purchase order's tax option"><b>Grand Total *</b></a>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="total" readonly name="total">
					</div>
				</div>
				<div id='retails' style='display:none' >
					<label>Name (Not required)</label>
					<input type='text' class='form-control' name='retail_name'>
					<div class="form-group">
						<label for="comment">Delivery Address (Not required)</label>
						<textarea class="form-control" rows="3" id="comment" name='retail_address' form='sales_order'></textarea>
					</div>
					<label>City (Not required)</label>
					<input type='text' class='form-control' name='retail_city'>
					<label>Phone (Not required)</label>
					<input type='text' class='form-control' name='retail_phone'>
				</div>
				<div class="row">
					<div class="col-sm-6" style="padding:20px">
						<button type="button" class="btn btn-default" onclick="return validateso()" id="calculate">Calculate</button>
						<button type="button" class="btn btn-danger" style="display:none" id="back">Back</button>
						<button type="button" class="btn btn-default" style="display:none" id="submitbtn" onclick="return look()">Submit</button	
					</div>
				</div>
				<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang"></input>
			</form>
		</div>
		<div class='col-sm-1' style='background-color:#ddd;z-index:-100'>
		</div>
	</div>
	<div class='row' style='height:70px;background-color:#333'>
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
	var total = document.forms["salesorder"]["total"].value;
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
		document.getElementById("sales_order").submit();
}};

function validateso(){
	var customer = document.forms["salesorder"]["select_customer"].value;
	var tax = document.forms["salesorder"]["taxing"].value;

	if (customer==""){
		alert("Pick a customer!");
		return false;
	} else if (tax==""){
		alert("Pick a taxing option");
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
	'<div class="col-sm-2"><input id="reference'+a+'" class="form-control" style="width:100%" name="reference'+a+'"></div>'+
	'<div class="col-sm-1"><input style="overflow-x:hidden" id="qty'+a+'"" class="form-control" style="width:100%" name="qty'+a+'"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="vat'+a+'" class="form-control" style="width:100%" name="vat'+a+'"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="pl'+a+'" class="form-control" name="pl'+a+'"></div>'+
	'<div class="col-sm-1"><input class="form-control" id="disc'+a+'" readonly name="disc'+a+'">'+'</div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="total'+a+'" class="form-control" style="width:100%" readonly name="total'+a+'"></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
	source: "search_item.php"
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