<?php
	include ("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createsalesorder.js"></script>
<script>
function disable_year(){
	document.getElementById("kosong").disabled = true;
	buka();
}
</script>
<style>
.inactive{
	display:none;
}
.notification_large{
	position:fixed;
	top:0;
	left:0;
	background-color:rgba(51,51,51,0.3);
	width:100%;
	text-align:center;
	height:100%;
}
.notification_large .notification_box{
	position:relative;
	background-color:#fff;
	padding:30px;
	width:100%;
	top:30%;
	box-shadow: 3px 4px 3px 4px #ddd;
}
.btn-delete{
	background-color:red;
	font-family:bebasneue;
	color:white;
	font-size:1.5em;
}
.btn-back{
	background-color:#777;
	font-family:bebasneue;
	color:white;
	font-size:1.5em;
}
</style>
<body>
<div class="main">
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<h4 style="color:#444">Edit or close Sales Order</h4>
	<hr>
	<div class='row'>
		<div class='col-sm-4 col-sm-offset-4'>
			<div class="input-group">
				<span class="input-group-addon">
					<button type='button' class='btn btn-default' style='width:100%;padding:0;background-color:transparent;border:none'  onclick='search_quotation()'>
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</span>
				<input type="text" id="search" name="search" class="form-control" placeholder="Search here">
			</div>
			<hr>
		</div>	
	</div>
	<style>
		#pin{
			-webkit-text-security: disc;
		}
		input[type=number]::-webkit-inner-spin-button, 
		input[type=number]::-webkit-outer-spin-button { 
			-webkit-appearance: none; 
			margin: 0; 
		}
	</style>
	<div id='quotation_result'>
		<div class='container'>
			<h3>Incomplete Sales Order</h3>
		</div>
		<div class='row' id='wrapping'>
			<div class='col-sm-4'>
<?php
	$sql_initial = "SELECT DISTINCT(so_id) AS so_id FROM sales_order_sent WHERE status = '0'";
	$result_initial = $conn->query($sql_initial);
	if(mysqli_num_rows($result_initial) > 0){
		while($initial = $result_initial->fetch_assoc()){
			$sql_code = "SELECT * FROM code_salesorder WHERE id = '" . $initial['so_id'] . "'";
			$result_code = $conn->query($sql_code);
			$code = $result_code->fetch_assoc();
?>
				<div class='row' style='padding:20px;background-color:#ddd;margin-top:5px' id='row-<?= $code['id'] ?>'>
					<div class='col-sm-6'>
						<strong><?= $code['name'] ?></strong><br>
						<p><?php
							$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
							$result_customer = $conn->query($sql_customer);
							$customer = $result_customer->fetch_assoc();
							echo $customer['name'];
						?></p>
					</div>
					<div class='col-sm-6'>
						<button type='button' class='btn btn-default' style='border:none;background-color:#777' onclick='view_pane(<?= $code['id'] ?>)'>
							<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
<?php
	if($role == 'superadmin'){
?>
						<button type='button' class='btn btn-success' onclick='editing(<?= $code['id'] ?>)'>
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</button>
						<form id='edit_form<?= $code['id'] ?>' method='POST' action='edit_so.php'>
							<input type='hidden' value='<?= $code['id'] ?>' name='id'>
						</form>
						<script>
							function editing(n){
								$('#edit_form' + n).submit();
							}
						</script>
						<button type='button' class='btn btn-danger' onclick='closing(<?= $code['id'] ?>)'>
							<i class="fa fa-ban" aria-hidden="true"></i>
						</button>
<?php
	}
?>
					</div>
					<hr>
				</div>
<?php
	}
?>
			</div>
			<div class='col-sm-8' id='viewpane'>
			</div>
<?php
	if($role == 'superadmin'){
?>
			<div class='col-sm-4 col-sm-offset-4' id='sure' style='position:absolute;top:50%;z-index:200;display:none'>
				<form action='close_so.php' method='POST' id='close_so_form<?= $code['id'] ?>'>
					<label>Input your pin</label>
					<input type='number' id='pin' class='form-control' name='pin'>
					<br>
					<button type='button' class='btn btn-default'>Close</button>
					<button type='button' class='btn btn-warning' onclick='submiting(<?= $code['id'] ?>)'>Submit</button>
				</form>
			</div>
<?php
	}
?>
		</div>
	</div>
</div>
<div class='notification_large' style='display:none'>
	<div class='notification_box' id='box_display'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to close this sales order?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Close</button>
		<input type='hidden' value='0' id='id_so' name='id'>
	</div>
	<div class='notification_box' id='box_pin' style='display:none'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to close this sales order?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Close</button>
		<input type='hidden' value='0' id='id_so' name='id'>
	</div>
</div>
<style>
	.isactive{
		background-color:#1ac6ff!important;
		color:white;
		transition:0.3s all ease;
	}
</style>
</body>
<script>
function submiting(n){
	$('#close_so_form' + n).submit();
}
function closing(n){
	$('.isactive').removeClass('isactive');
	$('#row-' + n).addClass('isactive');
	$('#id_so').val(n);
	$('.notification_large').fadeIn();
	
}
$('.btn-back').click(function(){
	$('.notification_large').fadeOut();
});
$('.btn-delete').click(function(){
	$('#box_display').fadeOut();
	setTimeout(function(){
		$('#box_pin').fadeIn();
	},300);
});
function view_pane(n){
	$('#sure').fadeOut();
	$('#viewpane').fadeIn();
	$('.isactive').removeClass('isactive');
	$('#row-' + n).addClass('isactive');
	$.ajax({
		url: "ajax/view_so.php",
		data: {
			term: n
		},
		type: "POST",
		dataType: "html",
		success: function (data) {
			$('#viewpane').html(data);
		},
		error: function (xhr, status) {
			alert("Sorry, there was a problem!");
		},
		complete: function (xhr, status) {
		}
	});
}
function search_quotation(){
	if(($('#search')).val() == ''){
		alert('Please insert a keyword!');
		return false;
	} else {
		$.ajax({
			url: "ajax/search_so.php",
			data: {
				term: $('#search').val()
			},
			type: "POST",
			dataType: "html",
			success: function (data) {
				$('#quotation_result').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
			}
		});
	}
};
</script>
<?php
	} else {
		echo ('There is no sales order to be seen');
	}
?>