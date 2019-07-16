<?php
	include("accountingheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "../Codes/search_item.php"
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
			<h2 style='font-family:bebasneue'>Random Invoice</h2>
			<p>Create <i>Proforma Invoice</i></h2>
			<hr>
			<form method="POST" id="proforma_invoice_form" action="build_proforma_invoice_validation.php">
				<div class="row">
					<div class="col-sm-6">
						<label for="name">Customer</label>
						<select class="form-control" id="select_customer" name="select_customer" onclick="disable_two()">
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
						<input id="today" name="today" type="date" class="form-control" value="<?php echo date('Y-m-d');?>">
						<label>Taxing</label>
						<select class='form-control' name='taxing' id='taxing'>
							<option value='0'>-- Please insert taxing --</option>
							<option value='1'>Tax</option>
							<option value='2'>Non tax</option>
						</select>
					</div>
				</div>
				<div class="row" id="headerlist" style="padding-top:25px;font-family:bebasneue;text-align:center">
					<div class="col-sm-1" style="background-color:#aaa">
						Nomor
					</div>
					<div class="col-sm-3" style="background-color:#ccc">
						Refference
					</div>
					<div class="col-sm-1" style="background-color:#aaa">
						Quantity
					</div>
					<div class="col-sm-3" style="background-color:#ccc">
						Price after tax
					</div>
					<div class="col-sm-3" style="background-color:#aaa">
						Total Price
					</div>
				</div>
				<div class="row" style="padding-top:10px;">
					<div class="col-sm-1">
						1
					</div>
					<div class="col-sm-3">
						<input id="reference1" class="form-control" name="reference[1]" style="width:100%">
					</div>
					<div class="col-sm-1">
						<input id="quantity1" name="quantity[1]" class="form-control" style="width:100%">
					</div>
					<div class="col-sm-3">
						<input id="price1" name="price[1]" class="form-control" style="width:100%">
					</div>
					<div class="col-sm-3">
						<input id="total1" class="form-control" readonly>
					</div>
				</div>
				<div id="input_list">
				</div>
				<br>
				<div class="row">
					<div class="col-sm-3 offset-sm-5">
						<a href="#" data-toggle="tooltip" data-placement="bottom" title="Check the purchase order's tax option"><b>Grand Total *</b></a>
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="grand_total" readonly name="grand_total">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6" style="padding:20px">
						<button type="button" class="btn btn-default" onclick="return validateso()" id="calculate">Calculate</button>
						<button type="button" class="btn btn-danger" style="display:none" id="back">Back</button>
						<button type="button" class="btn btn-default" style="display:none" id="submit_form_button">Submit</button	
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
var a = 2;
var grand_total;

function disable_two(){
	document.getElementById("customer_one").disabled = true;
}
$('#submit_form_button').click(function(){	
	$('#proforma_invoice_form').submit();
});
function validateso(){
	grand_total = 0;
	$('input[id^="reference"]').each(function(){
		var input_wrapper = $(this).parent().siblings();
		var total_input = input_wrapper.find($('input[id^="total"]'));
		
		var quantity = input_wrapper.find($('input[id^="quantity"]'));
		var price = input_wrapper.find($('input[id^="price"]'));
		var price_value = price.val();
		var quantity_value = quantity.val();
		
		var total_each = price_value * quantity_value;
		total_input.val(total_each);
		
		grand_total = grand_total + total_each;
	});
	$('#grand_total').val(grand_total);
	if ($('#select_customer').val() == ""){
		alert("Pick a customer!");
		return false;
	} else if($('#taxing').val() == 0){
		alert('Please insert taxing method');
		return false;
	} else {
		$('#submit_form_button').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		$(':input').attr('readonly',true);
	}
};
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1">'+a+'</div>'+
	'<div class="col-sm-3"><input id="reference'+a+'" class="form-control" style="width:100%" name="reference['+a+']"></div>'+
	'<div class="col-sm-1"><input id="quantity'+a+'"" class="form-control" style="width:100%" name="quantity['+a+']"></div>'+
	'<div class="col-sm-3"><input id="price'+a+'" class="form-control" style="width:100%" name="price['+a+']"></div>'+
	'<div class="col-sm-3"><input id="total'+a+'" class="form-control" style="width:100%" readonly name="total['+a+']"></div>'+
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
	$(':input').attr('readonly',false);
	$('input[id^="total"]').attr('readonly',true);
	$('#submit_form_button').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
});
</script>