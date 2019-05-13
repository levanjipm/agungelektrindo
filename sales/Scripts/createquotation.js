var i;
var a = 2;
function disable(){
	document.getElementById("kosong").disabled = true;
}
function disable_two(){
	document.getElementById("kosongan").disabled = true;
}
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-sm-1"><input class="nomor" value="'+a+'" style="width:40%" style="text-align:center"></div>'+
	'<div class="col-sm-2"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-2"><input style="overflow-x:hidden" id="price'+a+'" name="price'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-1">'+'<input type="number" id="discount'+a+'" name="discount'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-1">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
	'<div class="col-sm-2">'+'<input class="nomor" id="unitprice'+a+'" name="unitprice'+a+'"></div>'+
	'<div class="col-sm-2">'+'<input class="nomor" id="totalprice'+a+'" name="totalprice'+a+'" ></div>'+
	'<div class="col-sm-2"></div>'+
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