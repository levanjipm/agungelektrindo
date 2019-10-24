<?php
	include ("salesheader.php");
?>
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
	
	.box_edit_quotation{
		background-color:#40322b;
		margin-top:5px;
		color:#eee;
		width:100%;
		height:100%;
		transition:0.3s all ease;
	}
	
	.box_edit_quotation:hover{
		color:#ddd;
		transition:0.3s all ease;
	}

	.view_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_inventory_view{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_view{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
	
	.isactive{
		background-color:#2B3940!important;
		color:white;
		transition:0.3s all ease;
	}
</style>
<body>
<div class="main">
	<h2 style='font-family:bebasneue'>Quotation</h2>
	<p>Edit or Print Quotation</p>
	<hr>
	<input type="text" id="search" name="search" placeholder="Search here">
	<br>
	<h3 style='font-family:bebasneue'>Latest Quotations</h3>
	<div class='row' style='padding:10px' id='quotation_row'>
<?php
	$sql_quotation = "SELECT * FROM code_quotation WHERE company = 'AE' ORDER BY id DESC LIMIT 30";
	$result_quotation = $conn->query($sql_quotation);
	while($quotation = $result_quotation->fetch_assoc()){
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $quotation['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		
		$quotation_name		= $quotation['name'];
?>
		<div class='col-sm-4' style='padding:5px'>
			<div class='row box_edit_quotation' id='row-<?= $quotation['id'] ?>'>
				<div class='col-sm-8' style='padding:20px;background-color:#63767F;cursor:pointer' onclick='view_quotation(<?= $quotation['id'] ?>)'>
					<strong><?= $quotation_name ?></strong><br>
					<p><?= $customer_name ?></p>
				</div>
				<div class='col-sm-4' style='padding:20px'>
					<button type='button' class='button_default_dark' style='width:100%' onclick='view_quotation(<?= $quotation['id'] ?>)'>
						<i class="fa fa-eye" aria-hidden="true"></i>
					</button>
					<br>
					<button type='button' class='button_success_dark' style='width:100%'  onclick='edit_form(<?= $quotation['id'] ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
					<br>
					<form id='editing<?= $quotation['id'] ?>' action='quotation_edit' method='POST'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
					<button type='button' class='button_warning_dark' style='width:100%' onclick='submit_form(<?= $quotation['id']?>)'>
						<i class="fa fa-print" aria-hidden="true"></i>
					</button>
					
					<form id='<?= $quotation['id'] ?>' action='quotation_create_print' method='POST' target='_blank'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
				</div>
				<hr>
			</div>
		</div>
<?php
	}
?>
	</div>
	<div class='row'>
		<div class='col-xs-12' style='text-align:center'>
			<button type='button' class='button_default_dark' id='load_old_quotation_button'>
				<span id='loading_text'>Load older archieves</span>
				<span id='loading_spin' style='display:none'><i class="fa fa-spinner fa-spin"></i></span>
			</button>
			<input type='hidden' value='30' id='quotation_showed'>
		</div>
	</div>
</div>
<div class='view_wrapper'>
	<button id='button_close_view'>X</button>
	<div id='view_inventory_view'>
	</div>
</div>
</body>
<script>
	function edit_form(n){
		$('#editing' + n).submit();
	}

	function submit_form(n){
		$('#' + n).submit();
	}

	function view_quotation(n){
		$('.isactive').removeClass('isactive');
		$('#row-' + n).addClass('isactive');
		$.ajax({
			url: "ajax/view_quotation.php",
			data: {
				term: n
			},
			type: "POST",
			dataType: "html",
			success: function (response) {
				$('.view_wrapper').fadeIn();
				$('#view_inventory_view').html(response);
			},
		});
	}
	
	$('#button_close_view').click(function(){
		$('.view_wrapper').fadeOut();
	});
	
	$('#load_old_quotation_button').click(function(){
		var quotation_showed		= parseInt($('#quotation_showed').val());
		var quotation_to_be_showed	= parseInt(quotation_showed + 30);
		
		$.ajax({
			url:'load_more_quotation.php',
			data:{
				quotation_showed: quotation_showed,
				quotation_to_be_showed: quotation_to_be_showed,
			},
			type:'POST',
			beforeSend:function(){
				$('#loading_text').hide();
				$('#loading_spin').show();
				$('#quotation_row').html('');
			},
			success:function(response){
				$('#quotation_row').append(response);
				$('#loading_text').show();
				$('#loading_spin').hide();
				$('#quotation_showed').val(quotation_to_be_showed);
			}
		})
	});
	
	$('#search').change(function(){
		if(($('#search')).val() == ''){
			$('#quotation_showed').val(0);
			$('#load_old_quotation_button').click();
		} else {
			$.ajax({
				url: "ajax/search_quotation.php",
				data: {
					term: $('#search').val()
				},
				type: "POST",
				dataType: "html",
				beforeSend:function(){
					$('#search').attr('disabled',true);
				},
				success: function (response) {
					$('#search').attr('disabled',false);
					$('#quotation_row').html(response);
				},
			});
		}
	});
</script>