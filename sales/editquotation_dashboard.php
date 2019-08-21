<?php
	include ("salesheader.php");
?>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<style>
	input[type=text] {
		padding:10px;
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
	}
	input[type=text]:focus {
		width: 100%;
	}
</style>
<body>
<div class="main">
	<h2 style='font-family:bebasneue'>Quotation</h2>
	<p>Edit or Print Quotation</p>
	<hr>
	<input type="text" id="search" name="search" placeholder="Search here" onchange="search_quotation()">
	<br>
	<br>
	<div id='quotation_result'>
		<div class='container'>
			<h3 style='font-family:bebasneue'>Latest Quotations</h3>
		</div>
		<div class='row'>
			<div class='col-sm-4'>
<?php
	$sql_quotation = "SELECT * FROM code_quotation ORDER BY id DESC LIMIT 10";
	$result_quotation = $conn->query($sql_quotation);
	while($quotation = $result_quotation->fetch_assoc()){
?>
				<div class='row' style='padding:20px;background-color:#ddd;margin-top:5px' id='row-<?= $quotation['id'] ?>'>
					<div class='col-sm-5'>
						<strong><?= $quotation['name'] ?></strong><br>
						<p><?php
							$sql_customer = "SELECT name FROM customer WHERE id = '" . $quotation['customer_id'] . "'";
							$result_customer = $conn->query($sql_customer);
							$customer = $result_customer->fetch_assoc();
							echo $customer['name'];
						?></p>
					</div>
					<div class='col-sm-7'>
						<button type='button' class='btn btn-default' style='border:none;background-color:transparent' onclick='view_pane(<?= $quotation['id'] ?>)'>
							<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
						<button type='button' class='btn btn-success' onclick='edit_form(<?= $quotation['id'] ?>)'>
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</button>
						<button type='button' class='btn btn-warning' onclick='submit_form(<?= $quotation['id']?>)'>
							<i class="fa fa-print" aria-hidden="true"></i>
							<form id='<?= $quotation['id'] ?>' action='createquotation_print.php' method='POST'>
								<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
							</form>
						</button>
						<form id='editing<?= $quotation['id'] ?>' action='editquotation.php' method='POST'>
							<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
						</form>
					</div>
					<hr>
				</div>
<?php
	}
?>
			</div>
			<div class='col-sm-8' id='viewpane'>
			</div>
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
function edit_form(n){
	$('#editing' + n).submit();
}
function submit_form(n){
	$('#' + n).submit();
}
function view_pane(n){
	$('.isactive').removeClass('isactive');
	$('#row-' + n).addClass('isactive');
	$.ajax({
		url: "ajax/view_quotation.php",
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
			url: "ajax/search_quotation.php",
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