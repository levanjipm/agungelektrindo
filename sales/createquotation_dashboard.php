<?php
	include("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "ajax/search_item.php"
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
	<div class="container" style="right:50px">
	<h2>Quotation</h2>
	<h4 style="color:#444">Create new quotation</h4>
	<hr>
		<form name="quotation" id="quotation" class="form" method="POST" action="createquotation_validation.php">
			<div class="row">
				<div class="col-sm-6">
					<label for="name">Quote to:</label>
					<select class="form-control" id="quote_person" name="quote_person"  onclick="disable()">
					<option id="kosong" value="0">Please Select a customer--</option>
						<?php
							include("connect.php");
							$sql = "SELECT id,name,address FROM customer ORDER BY name ASC";
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
				</div>
				<div class="col-sm-2 offset-lg-2">
					<label for="date">Date</label>
					<input id="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name="today">
				</div>
			</div>
			<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
				<div class="col-sm-1">
					Nomor
				</div>
				<div class="col-sm-2">
					Refference
				</div>
				<div class="col-sm-2">
					Price
				</div>
				<div class="col-sm-1">
					Discount
				</div>
				<div class="col-sm-1">
					Quantity
				</div>
				<div class="col-sm-2">
					Nett Unit Price
				</div>
				<div class="col-sm-2">
					Total Price
				</div>
			</div>
			<hr>
			<div class="row" style="padding-top:10px;">
				<div class="col-sm-1">
					<input class="nomor" id="no1" style="width:40%" value="1" disabled></input>
				</div>
				<div class="col-sm-2">
					<input id="reference1" class="form-control" name="reference1" style="width:100%">
				</div>
				<div class="col-sm-2">
					<input style="overflow-x:hidden" id="price1" name="price1" class="form-control" style="width:100%">
				</div>
				<div class="col-sm-1">
					<input type='number' id="discount1" name="discount1"class="form-control" style="width:100%" name="discount1">
				</div>
				<div class="col-sm-1">
					<input id="quantity1" name="quantity1" class="form-control" style="width:100%" name="quantity1">
				</div>
				<div class="col-sm-2">
					<input class="nomor" id="unitprice1" name="unitprice1" readonly>
				</div>
				<div class="col-sm-2">
					<input class="nomor" id="totalprice1" name="totalprice1" readonly>
				</div>
				<div class="col-sm-2">
				</div>
			</div>
			<div id="input_list">
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-2 offset-lg-7">
					<label for="total">Total</label>
				</div>
				<div class="col-sm-2">
					<input class="nomor" id="total" name="total" readonly>
				</div>
			</div>
			<div class="row" style="padding-top:20px">
				<div class="col-sm-2">
					<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang">
				</div>	
			</div>
			<div class="container" style="background-color:#eee">
				<div class="row" style="padding:20px">
					<h3><b>Note</b></h3>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<p><b>1. Payment term</b></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<select id="terms" name="terms" class="form-control" style="width:100%" onchange="payment_js()" onclick="disable_two()">
						<option value='0' id="kosongan">--Please select payment terms--</option>
						<?php
							include("connect.php");
							$sql_payment = "SELECT * FROM payment";
							$result = $conn->query($sql_payment);
							if ($result->num_rows > 0) {
								while($rows = mysqli_fetch_array($result)) {
								echo '<option value="' . $rows["id"] . '">'. $rows["payment_term"].'</option> ';
								}
							} else {
								echo "0 results";
							}
						?>
						</select>
					</div>
				</div>
				<input type='hidden' id='danieltri' value='benar'>
				<div class="row" style="padding:5px">
					<div class="col-sm-6" style="padding:5px">
						<div class="col-sm-6" style="padding:5px">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="dp" name="dp" readonly maxlength='2'>
									<span class="input-group-addon" style="font-size:12px">%</span>
								</div>
							</div>
						</div>
						<div class="col-sm-6" style="padding:5px">
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" id="lunas" name="lunas" readonly maxlength='2'>
									<span class="input-group-addon" style="font-size:12px">days</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<p><b>2. </b>Prices and availability are subject to change at any time without prior notice.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<p><b>3. </b>Prices mentioned above are tax-included.</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<textarea class="form-control" name="comment" rows="10" form="quotation"></textarea>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-2">
					<button type="button" class="btn btn-primary" onclick="hitung()" id="calculate">Calculate</button>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
					<button type="button" id='tombolku' class="btn btn-success" style="display:none" onclick='validate()'>Submit</button>
				</div>
				<div class="col-sm-2">
					<button type="button" id="back" class="btn btn-primary" style="display:none">Back</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
function hitung(){
	$('#danieltri').val('benar');
	var payment_term = $('#terms').val();
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
				$('#danieltri').val('salah');
			} else {
			}
        },
        error: function (xhr, status) {
            alert("Sorry, there was a problem!");
        }
		})
	});
	var angka = true;
	$('input[id^=discount]').each(function(){
		if($(this).val() > 75 || $(this).val() == ''){
			angka = false;
		}
	});
	if($('#quote_person').val() == 0){
		alert("Please insert a customer");
		return false;
	} else if($('#today').val() == ''){
		alert('Please insert correct date!');
		return false;
	} else if(payment_term == 0) {
		alert("Please insert correct payment term");
		return false;
	} else if(angka == false){
		alert('Please insert correct discount!');
		return false;
	} else {
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
		}
		document.getElementById('total').value = round(calculated_total,2);
		document.getElementById('jumlah_barang').value = z - 1;
		if(isNaN($('#total').val())){
			alert('Insert correct price!');
			return false;
		} else {
			$('#quote_person').attr('readonly',true);
			$('input[id^=price]').attr('readonly',true);
			$('input[id^=reference]').attr('readonly',true);
			$('input[id^=discount]').attr('readonly',true);
			$('input[id^=quantity]').attr('readonly',true);
			$('#today').attr('readonly',true);
			$('#terms').attr('readonly',true);
			$('#tombolku').show();
			$('#back').show();
			$('#calculate').hide();
			$('#folder').hide();
			$('#close').hide();
		}
	}
};
function validate(){
	var payment_term = $('#terms').val();
	if($('#danieltri').val() == 'salah'){
		alert('One or more reference does not exist on database!');
		$('#quote_person').attr('readonly',false);
		$('input[id^=reference]').attr('readonly',false);
		$('input[id^=discount]').attr('readonly',false);
		$('input[id^=price]').attr('readonly',false);
		$('input[id^=quantity]').attr('readonly',false);	
		$('#terms').attr('readonly',false);
		$('#today').attr('readonly',false);
		$('#tombolku').hide();
		$('#back').hide();
		$('#calculate').show();
		$('#folder').show();
		$('#close').show();
		return false;
	} else if(payment_term == 2 && $('#lunas').val() == '') {
		alert('Please insert correct payement detail!');
		return false;
	} else if (payment_term == 3 && $('#lunas').val() == '') {
		alert('Please insert correct payement detail!');
		return false;
	} else if (payment_term == 4 && ($('#dp').val() == '' || $('#lunas').val() == '')){
		alert('Please insert correct payement detail!');
		return false;
	} else {
		$('#quotation').submit();
	}
}
$("#back").click(function (){
	$('#quote_person').attr('readonly',false);
	$('input[id^=reference]').attr('readonly',false);
	$('input[id^=discount]').attr('readonly',false);
	$('input[id^=price]').attr('readonly',false);
	$('input[id^=quantity]').attr('readonly',false);	
	$('#terms').attr('readonly',false);
	$('#today').attr('readonly',false);
	$('#tombolku').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
})

function payment_js(){
	var payment_term = $('#terms').val();
	if (payment_term == 1) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
	} else if (payment_term == 2) {
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 3) {
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 4) {
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
	}
}
</script>
<script type="text/javascript" src="scripts/createquotation.js"></script>