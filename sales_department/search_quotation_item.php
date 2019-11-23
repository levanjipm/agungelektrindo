<?php
	include('../codes/connect.php');
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
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<script>
$( function() {
	$('#customer').autocomplete({
		source: "search_customer.php"
	 })
});
</script>
<style>
ul.ui-autocomplete {
    z-index: 1100;
}
.secondary{
	opacity:0;
	visibility:hidden;
	position:relative;
	transition:visibility 0.5s linear, opacity 0.3s linear;
	text-decoration:none;
}
.primary:hover + .secondary, .secondary:hover{
	opacity:1;
	transition:0.5s ease;
	visibility:visible;
	margin-top:0px;
	transition:visibility 0.5s linear, opacity 0.3s linear;
}

.copy_quotation, .delete_quotation{
	color:black;
	font-size:14px;
}
.copy_quotation:hover, .delete_quotation:hover{
	font-weight: bold;
	text-decoration:none;
	color:black;
	font-size:14px;
}
</style>		
<body onload="startTime()">
<div class="topbar">
	<div class="row" style="background-color:#999;height:50px">
		<div class="col-lg-11"></div>
		<div class="col-lg-1" id="txt">
		</div>
	</div>
</div>
<?php
	$reference = $_POST['reference'];
?>
<div class="container">
	<h3>Search result for</h3>
	<p><b>Item reference:</b> <?= $reference ?></p>
</div>
<div class="container">
<?php
	$sql = "SELECT DISTINCT * FROM quotation WHERE reference = '" . $reference . "'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$quotation_id = $row['quotation_code'];
			$sql_q = "SELECT * FROM code_quotation WHERE id = '" . $quotation_id . "'";
			$result_q = $conn->query($sql_q);
			while($rows = $result_q->fetch_assoc()){
				$quotation_name = $rows['name'];
				$customer_id = $rows['customer_id'];
			}
			$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer = $conn->query($sql_customer);
			while($row_customer = $result_customer->fetch_assoc()){
				$customer_name = $row_customer['name'];
			}
?>
			<div class="col-lg-3" style="padding:10px">
				<div style="text-align:center">
					<img src="../universal/document.png" style="width:50%"></img>
				</div>
				<p style="text-align:center"><?= $customer_name ?></p>
				<a style="text-align:center" href="editquotation.php?id=<?= $quotation_id ?>" class="primary">
					<p style="padding-top:15px;margin:0px;"><button type="button" class="btn btn-primary"><b><?= $quotation_name ?></b></button></p>
				</a>
				<div class="container secondary">
					<ul style="padding:0px;width:15%" class="list-group">
						<li class="list-group-item">
							<button class="btn" class="copy_quotation" style="background-color:#fff">Copy quotation</button>
						</li>
						<li class="list-group-item list-group-item-danger">
							<a href="delete_quotation.php?id=<?= $row['id']?>" class="delete_quotation">Delete quotation</a>
						</li>
					</ul>
				</div>
			</div>
<?php
		}
	}		else {
?>
	<div class="row">
		<div class="col-lg-3">
			<?= "0 result" ?>
		</div>
	</div>
<?php
		}
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
  if (i < 10) {i = "0" + i};
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