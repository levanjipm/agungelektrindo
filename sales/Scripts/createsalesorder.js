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
	for (z = 1; z < a; z++){
		$('#vat'+ z).attr('readonly',true);
		$('#pl'+ z).attr('readonly',true);
		$('#disc'+ z).attr('readonly',true);
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		$('#purchaseordernumber').attr('readonly',true);
		$('#taxing').attr('readonly',true);
		$('#select_customer').attr('readonly',true);
		var calculated_total = 0;
	};
	
	calculated_total = 0;	
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
	'<div class="col-lg-1"><input class="nomor" value="'+a+'" style="width:40%" style="text-align:center"></input></div>'+
	'<div class="col-lg-2"><input id="reference'+a+'" class="form-control" style="width:100%" name="reference'+a+'"></div>'+
	'<div class="col-lg-1"><input style="overflow-x:hidden" id="qty'+a+'"" class="form-control" style="width:100%" name="qty'+a+'"></div>'+
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="vat'+a+'" class="form-control" style="width:100%" name="vat'+a+'"></div>'+
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="pl'+a+'" class="form-control" name="pl'+a+'"></div>'+
	'<div class="col-lg-1"><input class="form-control" id="disc'+a+'" readonly name="disc'+a+'">'+'</div>'+
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="total'+a+'" class="form-control" style="width:100%" readonly name="total'+a+'"></div>'+
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