<?php
	include('accountingheader.php');
	
?>
<form method="POST" action='stock_value_output.php'>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script>
$( function() {
	$('#reference1').autocomplete({
		source: "search_item_in.php"
	 })
});
$( function() {
	$('#customer').autocomplete({
		source: "search_customer.php"
	 })
});
</script>
<a href="#" id="folder"style="display:none"><i class="fa fa-folder"></i></a>
<a href="#" id="close" style="display:none"><i class="fa fa-close"></i></a>
<div class="main">	
<form id="regForm" method="POST" action="stock_value_in_input.php">
	<div class="tab"><h3>Prelimiary Data Input</h3>
		<p><input placeholder="Customer name" class="form-control" id="customer" name="customer"></p>
		<p><input placeholder="Document number" class="form-control" name="document"></p>
	</div>
	<div class="tab"><h3>Item Input</h3>
		<div class="container">
			<div class="row" id="headerlist" style="border-radius:10px;padding-top:25px">
				<div class="col-lg-1" style="background-color:#aaa">
					Nomor
				</div>
				<div class="col-lg-3" style="background-color:#ccc">
					reference
				</div>
				<div class="col-lg-2" style="background-color:#ccc">
					Quantity
				</div>
				<div class="col-lg-3" style="background-color:#ccc">
					Price
				</div>
			</div>
			<div class="row" style="padding-top:10px;">
				<div class="col-lg-1">
					<input class="nomor" id="no1" style="width:40%" value="1" disabled></input>
				</div>
				<div class="col-lg-3">
					<input id="reference1" class="form-control ref" name="reference1" style="width:100%" required>
				</div>
				<div class="col-lg-2">
					<input id="quantity1" class="form-control" name="quantity1" style="width:100%" required></input>
				</div>
			</div>
			<div id="input_list">
			</div>
			<div class="row" style="padding-top:20px">
				<div class="col-lg-2">
					<input type="hidden" class="form-control" id="jumlah_barang" name="jumlah_barang" value='1'>
				</div>
			</div>
		</div>
	</div>
	<div style="overflow:auto;">
		<div style="float:right;">
			<button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
			<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
		</div>
	</div>
	<div style="text-align:center;margin-top:40px;">
		<span class="step"></span>
		<span class="step"></span>
	</div>
</form>
<script>
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
	hide_buttons();
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
	document.getElementById("nextBtn").type = "submit";
	show_buttons();
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  fixStepIndicator(n)
}

function nextPrev(n) {
	var x = document.getElementsByClassName("tab");
	if (n == 1 && !validateForm()) return false;
	x[currentTab].style.display = "none";
	currentTab = currentTab + n;
	if (currentTab >= x.length) {
		document.getElementById("regForm").submit();
		return false;
	}
	showTab(currentTab);
}
function show_buttons(){
	$('#folder').fadeIn("slow");
	$('#close').fadeIn("slow");
}
function hide_buttons(){
	$('#folder').fadeOut("slow");
	$('#close').fadeOut("slow");
}
function validateForm() {
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid;
}

function fixStepIndicator(n) {
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}
</script>
<script type="text/javascript"src="Scripts/value_out.js">Hey</script>
	