<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$month			= date('m');
	$year			= date('Y');
?>
<head>
	<title>Manage customer</title>
</head>
<script>
	$('#customer_side').click();
	$('#customer_manage_dashboard').find('button').addClass('activated');
</script>
<style>
	#search_bar {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	#search_bar:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>View customer</p>
	<hr>
	<button type='button' class='button_default_dark' id='add_customer_button'>Add customer</button>
	<br><br>
	<input type='text' class='form-control' id='search_bar'>
	<br>
	<div id='customer_view_pane'></div>
</div>
<div class='full_screen_wrapper' id='add_customer_wrapper'>
	<div class='full_screen_box'>
		<button type='button' class='full_screen_close_button'>&times</button>
		<form action='customer_create_input' method='POST'>
			<h2 style='font-family:bebasneue'>Customer</h2>
			<p style='font-family:museo'>Add customer</p>
			<hr>
			<label>Name</label>
			<input type='text' class='form-control' name='customer_name' placeholder="Company or person name" required>
			<label >Person in Charge</label>
			<div class="input-group">
				<span class="input-group-addon">
					<select name="customer_prefix" id="customer_prefix" required>
						<option value="Bapak">Mr.</option>
						<option value="Ibu">Ms.</option>
					</select>
				</span>
				<input type="text" class="form-control" name="customer_pic" placeholder="Person in charge">
			</div>
			<label>Street Name</label>
			<input type="text" class="form-control" name="customer_address" placeholder="Address" required></input>

			<label for="name">Number</label>
			<input type="text" class="form-control" name="customer_nomor" placeholder="Number"></input>	

			<label for="name">City</label>
			<input type="text" class="form-control" name="customer_city" placeholder="City" required></input>

			<label for="name">Block</label>
			<input type="text" class="form-control" name="customer_blok" placeholder="Block number" required></input>
			
			<label for="name">Neighbourhood (RT)</label>
			<input type="text" class="form-control" name="customer_rt" placeholder="RT" required minlength="3" maxlength="3"></input>

			<label for="name">Hamlet (RW)</label>
			<input type="text" class="form-control" name="customer_rw" id="customer_address_rw" placeholder="RW" required minlength="3" maxlength="3"></input>

			<label for="name">Phone Number</label>
			<input id="customer_phone_number" name="customer_phone" type="text" class="form-control"></input>

			<label for="Name">Tax Identification Number</label>
			<input type='text' class='form-control' id='customer_npwp' name='customer_npwp'/>
			<script>
				$("#customer_npwp").inputmask("99.999.999.9-999.999");
			</script>
			
			<label>Default Term of Payment (in days)</label>
			<input type='number' class='form-control' name='customer_top' required min='0' max='60'>

			<br>
			<button class='button_success_dark'>Submit</button>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'customer_manage_view.php',
			data:{
			},
			type:'GET',
			beforeSend:function(){
				$('#customer_view_pane').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success:function(response){
				$('#customer_view_pane').html(response);
			}
		});
	});
	
	$('#search_bar').change(function(){
		$.ajax({
			url:'customer_manage_view.php',
			data:{
				term:$('#search_bar').val()
			},
			type:'GET',
			beforeSend:function(){
				$('#c').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
			},
			success:function(response){
				$('#customer_view_pane').html(response);
			}
		});
	});
	
	$('#add_customer_button').click(function(){
		$('#add_customer_wrapper').fadeIn();
	});
</script>