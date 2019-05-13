function payment_js(){
	var payment_term = $('#terms').val();
	if (payment_term == 1) {
		$('#dp').val(0);
		$('#lunas').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
	} else if (payment_term == 2) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 3) {
		$('#dp').val(0);
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',false);
	} else if (payment_term == 4) {
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
	}
};
$("#close").click(function () {
	if(a>2){
	a--;
	x = 'barisan' + a;
	$("#"+x).remove();
	} else {
		return false;
	}
});	
function hitung(){
	if(isNaN ($('#total').val())){
		alert("Insert a correct price");
	} else if($('#terms').val() == 0) {
		alert("Please insert correct payment term");
	} else{
		for (z = 1; z < a; z++){
		$('#price'+ z).attr('readonly',true);
		$('#discount'+ z).attr('readonly',true);
		$('#submitbtn').show();
		$('#back').show();
		$('#calculate').hide();
		$('#folder').hide();
		$('#close').hide();
		var calculated_total = 0;

		for (z = 1; z < a; z++){
			if (document.getElementById('price'+z) !== null){
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
				calculated_total = calculated_total + calculated_price;
			}
		}
		document.getElementById('total').value = round(calculated_total,2);
		document.getElementById('jumlah_barang').value = z - 1;
		};
	}
};
function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}
$("#back").click(function () {
	for (z = 1; z < a; z++){
		$('#price'+ z).attr('readonly',false);
		$('#discount'+ z).attr('readonly',false);
		}
		$('#submitbtn').hide();
		$('#back').hide();
		$('#calculate').show();
		$('#folder').show();
		$('#close').show();
})