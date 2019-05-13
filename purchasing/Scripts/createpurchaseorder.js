window.onload
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
	'<div class="col-lg-2"><input style="overflow-x:hidden" id="price'+a+'"" class="form-control" style="width:100%" name="price'+a+'"></div>'+
	'<div class="col-lg-1">'+'<input id="discount'+a+'"" class="form-control" style="width:100%" name="discount'+a+'"></div>'+
	'<div class="col-lg-1">'+'<input class="form-control" id="quantity'+a+'"" name="quantity'+a+'"></input></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="unitprice'+a+'"" name="unitprice'+a+'" readonly></input></div>'+
	'<div class="col-lg-2">'+'<input class="nomor" id="totalprice'+a+'"" name="totalprice'+a+'" readonly></input></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "ajax/search_item.php"
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
	$('#reference1').on('input', function () {
		var value = $(this).val().replace(/'/g, '').replace(/"/g, '');
		});
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
	console.log(kosongan);
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
	} else if(duplicate){
		alert('May not duplicate input!');
	} else if(kosongan){
		alert('There are empty inputs!');
	} else{
		for (z = 1; z < a; z++){
			$('#quantity'+ z).attr('readonly',true);
			$('#reference'+ z).attr('readonly',true);
			$('#price'+ z).attr('readonly',true);
			$('#discount'+ z).attr('readonly',true);
			$('#submitbtn').show();
			$('#back').show();
			$('#calculate').hide();
			$('#folder').hide();
			$('#close').hide();
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