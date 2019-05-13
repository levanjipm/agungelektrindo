<!DOCTYPE html>
<html lang="en">
<head>
<title> Purchasing Department</title>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<?php
	include("receptionist.css")
?>
</head>
<body onload="startTime()">
<div class="topbar" id="stopbar" style="color:white">
	<div class="row">
		<div class="col-lg-11"></div>
		<div class="col-lg-1" id="txt">
		</div>
	</div>
</div>
<div class="sidebar">
	<button class="dropdown-btn">Purchase Orders 
		<i class="fa fa-caret-down"></i>
	</button>
	<div class="dropdown-container">
		<a href="#">
			<p>Create a counter bill</p>
		</a>
		<a href="#">
			<p>Create a receipt</p>
		</a>
		<a href="#" style="background-color:#cc0000">
			<p>Close or Delete purchase Order</p>
		</a>
	</div>
	<button class="dropdown-btn" >Suppliers
		<i class="fa fa-caret-down"></i>
	</button>
		<div class="dropdown-container">
			<a href="addsupplier_dashboard.php">
				<p>Add Supplier</p>
			</a>
			<a href="editsupplier_dashboard.php" disabled>
				<p>Edit Supplier</p>
			</a>
		</div>
	<button class="dropdown-btn">Item List
		<i class="fa fa-caret-down"></i>
	</button>
	<div class="dropdown-container">
		<a href="additem_dashboard.php" onclick="showitem()">
			<p>Add Item</p>
		</a>
		<a href="edititem_dashboard.php">
			<p>Edit Item List</p>
		</a>
	</div>
	<button class="dropdown-btn" >Delivery Address
	<i class="fa fa-caret-down"></i>
	</button>
	<div class="dropdown-container">
		<a href="adddeliveryaddress_dashboard.php">
			<p>Input new delivery address</p>
		</a>
		<a href="editdeliveryaddress_dashboard.php">
			<p>Edit a delivery address</p>
		</a>
	</div>
</div>
<script>
window.onscroll = function() {scrollFunction()};
	var header = document.getElementById("stopbar");
	var sticky = header.offsetTop;
	
function scrollFunction() {
	if(window.pageYOffset > sticky ){
		header.classList.add("sticky");
	} else{
		header.classList.remove("sticky");
	}
}
function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('txt').innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}
function checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}
</script>