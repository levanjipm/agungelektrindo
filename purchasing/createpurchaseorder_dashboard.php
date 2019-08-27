<?php
	include("purchasingheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<link rel="stylesheet" href="css/create_purchase_order.css">
<script src="../jquery-ui.js"></script>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../codes/search_item.php"
	 })
});
</script>
<style>
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<div class="main">
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<h2 style='font-family:bebasneue'>Purchase order</h2>
	<p>Creating new purchase order</p>
	<hr>
	<br>
	<form name="purchaseorder" id="purchaseorder" method="POST" action="createpurchaseorder_validation.php" style="font-family:sans-serif">
		<div class="row">
			<div class="col-sm-5">
				<label for="name">Order to</label>
				<select class="form-control" id="selectsupplier" name="selectsupplier"  onclick="disable()">
				<option id="kosong" value="">--Please Select a supplier--</option>
					<?php
						include("connect.php");
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
			<div class="col-sm-5 col-sm-offset-1">
				<label for="date">Date</label>
				<input id="today" name="today" type="date" class="form-control" value="<?= date('Y-m-d');?>">
				<label>Send date</label>
				<input type='date' class='form-control' name='sent_date' id='sent_date'>
				<div class="checkbox">
					<label class="radio-inline"><input type="radio" name="delivery_date" checked value='1'>Insert date</label>
					<label class="radio-inline"><input type="radio" name="delivery_date" value='2'>Unknown date</label>
					<label class="radio-inline"><input type="radio" name="delivery_date" value='3'>Urgent delivery</label>
				</div>
			</div>
		</div>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Price</th>
				<th>Discount</th>
				<th>Quantity</th>
				<th>Net price</th>
				<th>Total price</th>
			</tr>
			<tbody id='purchaseorder_tbody'>
				<tr id='tr-1'>
					<td><input id="reference1" class="form-control ref" name="reference1" required></td>
					<td><input type='text' id="price1" name="price1" class="form-control" required step=".001"></td>
					<td><input type='number' id="discount1" class="form-control" name="discount1" required step=".001"></td>
					<td><input type='number' id="quantity1" class="form-control" name="quantity1" required></input></td>
					<td><input type='number' class="nomor" id="unitprice1" name="unitprice1" readonly step=".001"></input></td>
					<td><input type='number' class="nomor" id="totalprice1" name="totalprice1" readonly step=".001"></input></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<div class="row">
			<div class="col-sm-2 offset-lg-7">
				<label for="total">Total</label>
			</div>
			<div class="col-sm-2">
				<input class="nomor" id="total" name="total" readonly></input>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-8'>
				<label class="radio-inline"><input type="radio" name="optradio" checked value='1' onchange='delivery_option()'>Default</label>
				<label class="radio-inline"><input type="radio" name="optradio" value='2' onchange='delivery_option()'>As dropshiper</label>
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
			<textarea class="form-control" rows="5" form="purchaseorder" name='note'></textarea>
		</div>
		<br><br>
		<div class="row">
			<div class="col-sm-2">
				<button type="button" class="btn btn-default" onclick="hitung()" id="calculate">Calculate</button>
			</div>
		</div>
		<div class="row" style="padding-top:20px">
			<div class="col-sm-6">
				<button type="button" id="back" class="btn btn-danger" style="display:none">Back</button>
				<button id="submitbtn" class="btn btn-success" style='display:none'>Submit</button>
				<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang">
			</div>
		</div>
	</form>
</div>
<script>
var i;
var a=2;
var z;
function disable(){
	document.getElementById("kosong").disabled = true;
}
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-lg-1">'+a+'</div>'+
	'<div class="col-lg-2"><input id="reference'+a+'" class="form-control ref" style="width:100%" name="reference'+a+'" required></div>'+
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="price'+a+'"" class="form-control" style="width:100%" name="price'+a+'" step=".001"></div>'+
	'<div class="col-lg-1">'+'<input id="discount'+a+'"" class="form-control" style="width:100%" name="discount'+a+'" step=".001"></div>'+
	'<div class="col-lg-1">'+'<input class="form-control" id="quantity'+a+'"" name="quantity'+a+'"></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="unitprice'+a+'"" name="unitprice'+a+'" readonly step=".001"></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="totalprice'+a+'"" name="totalprice'+a+'" readonly step=".001"></div>'+
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
function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}
function hitung(){
	var kosongan = false;
	var duplicate = false;
	var failed = false;
	$('input[id^=reference]').each(function(){
		var $this = $(this);
		if ($this.val()===''){ return;};
		$('input[id^=reference]').not($this).each(function(){
			if ( $(this).val()==$this.val()) {duplicate=true;}
		});
		if ($this.val().trim() == ''){
			kosongan = true;
		};
	});
	var calculated_total = 0;
	for (z = 1; z < a; z++){
		var raw_price = document.getElementById('price'+z).value;
		var calculated_pricelist = eval(raw_price);
		document.getElementById('price'+z).value = round(calculated_pricelist,2);
		
		var raw_discount = document.getElementById('discount'+z).value;
		var discount = raw_discount/100;
		var netprice = calculated_pricelist * (1-discount);
		document.getElementById('unitprice'+z).value = round(netprice,2);
		var qty = document.getElementById('quantity'+z).value;
		var calculated_totalunitprice = qty * netprice;
		var calculated_price = round(calculated_totalunitprice,2);
		document.getElementById('totalprice'+z).value = calculated_price;
		calculated_total = calculated_total +calculated_price;
		
	};
	document.getElementById('total').value = calculated_total;
	document.getElementById('jumlah_barang').value = z - 1;
	if($('#selectsupplier').val() == 0){
		alert("Please insert a supplier");
	} else if(isNaN ($('#total').val())){
		alert("Insert correct price");
		return false;
	} else if($('input[name=optradio]:checked').val() == 2 && $('#dropship_address').val() == '' && $('#dropship_phone').val() == '' && $('#dropship_name').val() == '' && $('#dropship_city').val() == ''){
		alert('Insert valid delivery address for dropship!');
		return false;
	} else if($('input[name=delivery_date]:checked').val() == 1 && ($('#sent_date').val() == '' || $('#today').val() == '')){
		alert('Please insert date!');
		return false;
	} else if(duplicate){
		alert('May not duplicate input!');
		return false;
	} else if(kosongan){
		alert('There are empty inputs!');
		return false;
	} else{
		$('#submitbtn').show();
		$('#back').show();
		$('#dropship_address').attr('readonly',true);
		$('#dropship_phone').attr('readonly',true);
		$('#dropship_name').attr('readonly',true);
		$('#dropship_city').attr('readonly',true);
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		for (z = 1; z < a; z++){
			$('#quantity'+ z).attr('readonly',true);
			$('#reference'+ z).attr('readonly',true);
			$('#price'+ z).attr('readonly',true);
			$('#discount'+ z).attr('readonly',true);
		}
	}
};

$("#back").click(function () {
	for (z = 1; z < a; z++){
		$('#price'+ z).attr('readonly',false);
		$('#discount'+ z).attr('readonly',false);
		$('#quantity'+ z).attr('readonly',false);
		$('#reference'+ z).attr('readonly',false);
	}
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
});
</script>