<DOCTYPE html>
<head>
<title>Welcome Page</title>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<style>
.topbar {
	background-color:#333;
	width:100%;
	height:50px;
	color:white;
}
.main{
	width:90%;
	background-color:white;
	margin-left:10%;
	padding:10px;
	overflow-x:hidden;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
div a {
	color:black;
}
.box {
  width: 25%;
  height: 300px;
  float: left;
  border: 6px solid #333;
  margin: 10px;
  padding:20px;
}
.box:hover{
  height: 310px;
  margin-top: -10px;
  margin-bottom: 10px;
 -moz-box-shadow:    0 0 20px #333;
 -webkit-box-shadow: 0 0 20px #333;
 box-shadow:         0 0 20px #333;  
}
.sidebar{
	width:10%;
	background-color:#99ff99;
	height:100%;
	padding:5px;
	overflow-x:hidden;
	z-index:1;
	position:fixed;
}
.sidebar a,.dropdown-btn,.sidebar .btn{
	text-decoration:none;
	font-size:15px;
	transition:0.3s all;
	padding: 6px 8px 6px 16px;
	border:none;
	display:block;
	color: #333;
	background: none;
	width:100%;
	outline: none;
	text-align:left;
}
.sidebar a:hover,.dropdown-btn:hover{
	text-decoration:none;
	color:white;
	font-size:15px;
	transition:0.3s all;
}
#user_button{
	background-color:transparent;
	border:none;
}
.dropdown {
  float: left;
  overflow: hidden;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}
.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}
.dropdown-content a:hover {
  background-color: #ddd;
}
.dropdown:hover .dropdown-content {
  display: block;
}
</style>
<body>
<?php
	include("codes/connect.php");
	session_start();
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	$sql_user = "SELECT name, role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
		$user_name = $row_user['name'];
	};
	if(mysqli_num_rows($result_user) == 0){
		header('location:../landing_page.php');
	}
	if ( isset( $_SESSION['user_id'] ) && $role == 'superadmin' || $role == 'purchasing' ) {
?>
<div class="topbar" id="stopbar">
	<div class="col-lg-1" id="txt">
	</div>
	<div class="col-lg-2 col-lg-offset-10" style=";padding-top:10px;text-align:right;">
		<button type="button" id="user_button" onclick="show_menu_user()">
			<i class="fa fa-user"><?= $user_name ?></i>
		</button>
		<div class="dropdown-content">
			<a href="#">Account info</a>
			<a href="../Codes/logout.php">Logout</a>
			<button type='button' style="border:none;color:black;background-color:transparent" onclick="close_menu_user()">&times</button>
		</div>
	</div>
</div>
<script>
	function show_menu_user(){
		$('.dropdown-content').show();
	}
	function close_menu_user(){
		$('.dropdown-content').hide();
	}
</script>
<div class="sidebar w3-light-grey">
	<a href="purchasing/purchasing.php">Purchasing Department</a>
	<a href="inventory/inventory.php">Inventory Department</a>
	<a href="sales/sales.php">Sales Department</a>
	<a href="accounting/accounting.php">Accounting Department</a>
	<a href="receptionist/receptionist.php">Receptionist</a>
</div>
<div class="main">
<?php
include('connect.php');
$sql_inventory = "SELECT COUNT(DISTINCT so_id) as jumlah FROM sales_order_sent WHERE status = '0'";
$result_inventory = $conn->query($sql_inventory);
while($row_inventory = $result_inventory->fetch_assoc()){
	$jumlah = $row_inventory['jumlah'];
}
if ($jumlah == 0){
} else {
	if($jumlah == 1){
	$jumlah_say = 'there is one pending sales order.'; 
} else {
	$jumlah_say = 'there are ' . $jumlah . ' pending sales orders to be send.';
}
?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<h3>Pending Sales Order</h3>
				<p><?= $jumlah_say ?></p>
				<a href="inventory/confirm_do_dashboard.php">Click here to see the details</a>
			</div>
		</div>
	</div>
<?php
	};
	$sql_sales_return = "SELECT COUNT(*) AS jumlah_return FROM code_sales_return WHERE isconfirm = '0'";
	$result_sales_return = $conn->query($sql_sales_return);
	while($row_sales_return = $result_sales_return->fetch_assoc()){
		$return = $row_sales_return['jumlah_return'];
	}
	if ($return == 0){
		} else {
			if($return == 1){
			$return_say = 'there is one unconfirmed sales return.'; 
		} else {
			$return_say = 'there are ' . $jumlah . ' unconfirmed sales return.';
		}
?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<h3>Pending Confirmed Return</h3>
				<p><?= $return_say ?></p>
				<a href="#">Click here to see the details</a>
			</div>
		</div>
	</div>
<?php
	} 
}else {
	header('location:landing_page.php');
}
?>