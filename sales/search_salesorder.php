<?php
include("../codes/connect.php");
?>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href="salesstyle.css">
</head>
<body onload="startTime()">
<div class="topbar">
	<div class="row" style="background-color:#999;height:50px">
		<div class="col-lg-11"></div>
		<div class="col-lg-1" id="txt">
		</div>
	</div>
</div>
<?php
	$year = $_POST['year'];
	$month = $_POST['month'];
	$customer = $_POST['customer'];
?>
<div class="container">
	<h3>Search result for</h3>
	<p><b>Year</b> <?= $year ?></p>
	<p><b>Month</b> <?= $month ?></p>
	<p><b>Customer</b> <?= $customer ?></p>
</div>
<div class="container">
<?php
	$sql_customer = "SELECT * FROM customer WHERE name = '" . $customer . "'";
	$r = $conn->query($sql_customer);
	while($rows = $r->fetch_assoc()){
		$id = $rows['id'];
	}
	$sql = "SELECT * FROM code_salesorder WHERE year(date) = '" . $year . "' AND month(date) = '" . $month . "' AND customer_id = '" . $id . "' ORDER BY date DESC";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()){
	?>
	<div class="col-lg-3">
		<div class="container" style="padding:20px">
				<img src="../universal/document.png" style="width:10%"></img>
			<a href="editsalesorder.php?id=<?= $row['id']?>">
				<p style="padding-top:15px"><button type="button" class="btn btn-primary"><b><?= $row['name'] ?></b></button></p>
			</a>
		</div>
	</div>
	<?php
		}
	} else { 
	?>
					No result
	<?php }
?>
</div>	
<script>
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
<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: -5px;
  left: 110%;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>