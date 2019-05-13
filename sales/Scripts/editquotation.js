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
	if(a > 2){
		a--;
		x = 'barisan' + a;
		$("#"+x).remove();
	} else {
		return false;
	}
});	
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
	console.log(angka);
	if($('#quote_person').val() == 0){
		alert("Please insert a customer");
		return false;
	} else if($('#terms').val() == 0) {
		alert("Please insert correct payment term")
	} if(angka == false){
		alert('Please insert correct discount!');
		return false;
	} else {
		$('#terms').attr('readonly',true);
		$('button[id^=close]').hide();
		$('#dp').attr('readonly',true);
		$('#lunas').attr('readonly',true);
		$('input[id^=reference]').attr('readonly',true);
		$('input[id^=quantity]').attr('readonly',true);
		$('input[id^=price]').attr('readonly',true);
		$('input[id^=discount]').attr('readonly',true);
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
		}
	if(isNaN ($('#total').val())){
		alert("Insert a correct price");
		return false;
	}
};
function round(value, precision) {
    var multiplier = Math.pow(10, precision || 0);
    return Math.round(value * multiplier) / multiplier;
}
$("#back").click(function () {
	$('input[id^=reference]').attr('readonly',false);
	$('input[id^=price]').attr('readonly',false);
	$('input[id^=discount]').attr('readonly',false);
	$('input[id^=quantity]').attr('readonly',false);
	$('#submitbtn').hide();
	$('#back').hide();
	$('#calculate').show();
	$('#folder').show();
	$('#close').show();
	$('button[id^=close]').show();
});
function validate(){
	if($('#danieltri').val() == 'salah'){
		alert('Please insert correct reference!');
		$('#terms').attr('readonly',false);
		$('#dp').attr('readonly',false);
		$('#lunas').attr('readonly',false);
		$('input[id^=reference]').attr('readonly',false);
		$('input[id^=price]').attr('readonly',false);
		$('input[id^=discount]').attr('readonly',false);
		$('input[id^=quantity]').attr('readonly',false);
		$('#submitbtn').hide();
		$('#back').hide();
		$('#calculate').show();
		$('#folder').show();
		$('#close').show();
		$('button[id^=close]').show();
		return false;
	} else {
		$('#quotation_edit').submit();
	}
};