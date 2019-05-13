<?php
	include ("salesheader.php");
?>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<body>
<div class="main">
	<div class='container'>
		<h2>Quotation</h2>
		<h4 style="color:#444">Edit or Print Quotation</h4>
		<hr>
	</div>
	<div class='row'>
		<div class='col-sm-4 col-sm-offset-4'>
			<div class="input-group">
				<span class="input-group-addon">
					<button type='button' class='btn btn-default' style='width:100%;padding:0;background-color:transparent;border:none'
					onclick='search_quotation()'>
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</span>
				<input type="text" id="search" name="search" class="form-control" placeholder="Search here">
			</div>
			<hr>
		</div>	
	</div>
	<div id='quotation_result'>
		<div class='container'>
			<h3>Latest Quotations</h3>
		</div>
		<div class='row'>
			<div class='col-sm-4'>
<?php
	$sql_quotation = "SELECT * FROM code_quotation ORDER BY id DESC LIMIT 10";
	$result_quotation = $conn->query($sql_quotation);
	while($quotation = $result_quotation->fetch_assoc()){
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
						<button type='button' class='btn btn-default' style='border:none;background-color:transparent' onclick='view_pane(<?= $quotation['id'] ?>)'>
							<i class="fa fa-eye" aria-hidden="true"></i>
						</button>
						<br>
						<button type='button' class='btn btn-success' onclick='edit_form(<?= $quotation['id'] ?>)'>
							<i class="fa fa-pencil" aria-hidden="true"></i>
							<form id='editing<?= $quotation['id'] ?>' action='editquotation.php' method='POST'>
								<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
							</form>
						</button>
						<button type='button' class='btn btn-warning' onclick='submit_form(<?= $quotation['id']?>)'>
							<i class="fa fa-print" aria-hidden="true"></i>
							<form id='<?= $quotation['id'] ?>' action='createquotation_print.php' method='POST'>
								<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
							</form>
						</button>
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