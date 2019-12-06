window.onload
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;
var a=2;
var z;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
$("#close").click(function () {
	if(a>2){
	a--;
	x = 'barisan' + a;
	$("#"+x).remove();
	$('#jumlah_barang').val(a-1);
	} else {
		return false;
	}
});
$("#folder").click(function (){	
	$("#input_list").append(
	'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
	'<div class="col-lg-1"><input class="nomor" value="'+a+'" style="width:40%" style="text-align:center" disabled></input></div>'+
	'<div class="col-lg-3"><input id="reference'+a+'" class="form-control ref" style="width:100%" name="reference'+a+'" required></div>'+
	'<div class="col-lg-2">'+'<input class="form-control" id="quantity'+a+'" name="quantity'+a+'"></input></div>'+
	'<div class="col-lg-3">'+'<input class="form-control" id="price'+a+'" name="price'+a+'"></input></div>'+
	'</div>').find("input").each(function () {
		});
	$("#reference" + a).autocomplete({
		source: "search_item.php"
	 });
	a++;
	$('#jumlah_barang').val(a-1);
});