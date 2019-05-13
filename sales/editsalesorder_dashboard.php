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
<body>
<div class="main">
	<div class='container'>
		<h2>Sales Order</h2>
		<h4 style="color:#444">Edit or close Sales Order</h4>
		<hr>
	</div>
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
			<h3>Latest Sales Order</h3>
		</div>
		<div class='row' id='wrapping'>
			<div class='col-sm-4'>
<?php
	$sql_initial = "SELECT DISTINCT(so_id) FROM sales_order_sent WHERE status = '0'";
	$result_initial = $conn->query($sql_initial);
	if(mysqli_num_rows($result_initial) > 0){
		while($initial = $result_initial->fetch_assoc()){
			$sql_code = "SELECT * FROM code_salesorder WHERE id = '" . $initial['so_id'];
			$result_code = $conn->query($sql_code);
			$quotation = $result_code->fetch_assoc();
?>
				<div class='row' style='padding:20px;background-color:#ddd;margin-top:5px' id='row-<?= $quotation['id'] ?>'>
					<div class='col-sm-6'>
						<strong><?= $quotation['name'] ?></strong><br>
						<p><?php
							$sql_customer = "SELECT name FROM customer WHERE id = '" . $quotation['customer_id'] . "'";
							$result_customer = $conn->query($sql_customer);
							$customer = $result_customer->fetch_assoc();
							echo $customer['name'];
						?></p>
					</div>
					<div class='col-sm-6'>
						<button type='button' class='btn btn-default' style='border:none;background-color:#777' onclick='view_pane(<?= $quotation['id'] ?>)'>
							<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
						<a href="editquotation.php?id=<?= $quotation['id']?>" style="text-decoration:none;color:black">
							<button type='button' class='btn btn-success'>
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</button>
						</a>
<?php
	if($role == 'superadmin'){
?>
						<button type='button' class='btn btn-danger' onclick='closing(<?= $quotation['id'] ?>)'>
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
				<form action='close_so.php' method='POST' id='close_so_form'>
					<label>Input your pin</label>
					<input type='number' id='pin' class='form-control' name='pin'>
					<input type='hidden' id='id_so' name='id'>
					<br>
					<button type='button' class='btn btn-default'>Close</button>
					<button type='button' class='btn btn-warning' onclick='submiting()'>Submit</button>
				</form>
			</div>
<?php
	}
?>
		</div>
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
function submiting(){
	$('#close_so_form').submit();
}
function closing(n){
	$('#viewpane').fadeOut();
	$('#sure').fadeIn();
	$('.isactive').removeClass('isactive');
	$('#row-' + n).addClass('isactive');
	$('#id_so').val(n);
}
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