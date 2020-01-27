<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Input customer data</title>
</head>
<script>
	$('#customer_side').click();
	$('#customer_create_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<div class='row' style='height:100%'>
		<div class='col-sm-12 col-xs-12'>
			<h2 style='font-family:bebasneue'>Customer</h2>
			<p style='font-family:museo'>Add new customer data</p>
			<hr>
			<label for="name">Company</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				<input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Company or person name" required></input>
			</div>
			<label >Person in Charge:</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<span class="input-group-addon">
					<select name="pic_prefix" id="pic_prefix" onclick="disable()" required>
						<option value="0" id="kosong">Select</option>
						<option value="Bapak">Mr.</option>
						<option value="Ibu">Ms.</option>
					</select>
				</span>
				<input type="text" class="form-control" id="pic_name" name="pic_name" placeholder="Person in charge">
			</div>
			<div class='row'>
				<div class="col-sm-4">
					<label for="name">Street Name</label>
					<input type="text" class="form-control" name="customer_address" id="customer_address" placeholder="Address" required></input>
				</div>
				<div class="col-sm-4">
					<label for="name">Number</label>
					<input type="text" class="form-control" name="customer_address_number" id="customer_address_number" placeholder="Number" required></input>	
				</div>
				<div class="col-sm-4">
					<label for="name">City</label>
					<input type="text" class="form-control" name="customer_city" id="customer_city" placeholder="City" required></input>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-4">
					<label for="name">Block</label>
					<input type="text" class="form-control" name="customer_address_block" id="customer_address_block" placeholder="Block number" required></input>
				</div>
				<div class="col-sm-4">
					<label for="name">RT</label>
					<input type="text" class="form-control" name="customer_address_rt" id="customer_address_rt" placeholder="RT" required minlength="3" maxlength="3"></input>
				</div>
				<div class="col-sm-4">
					<label for="name">RW</label>
					<input type="text" class="form-control" name="customer_address_rw" id="customer_address_rw" placeholder="RW" required minlength="3" maxlength="3"></input>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<label for="name">Phone Number</label>
					<input id="customer_phone_number" name="customer_phone_number" type="text" class="form-control"></input>
				</div>
			</div>
			<div class='row'>
				<div class="col-sm-12">
					<label for="Name">Tax Identification Number</label>
					<input type='text' class='form-control' id='customer_npwp' name='customer_npwp'/>
					<label>Default Term of Payment (in days)</label>
					<input type='number' class='form-control' id='customer_default_top'>
					<script>
						$("#customer_npwp").inputmask("99.999.999.9-999.999");
					</script>
					<br>
					<button type="button" class="button_success_dark" id="proceed_button">Submit</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h3 style='font-family:bebasneue'>Create customer data</h3>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<td><strong>Customer name</strong></td>
				<td id='customer_name_view'></td>
			</tr>
			<tr>
				<td><strong>Person in charge</strong></td>
				<td id='customer_pic_view'></td>
			</tr>
			<tr>
				<td><strong>Adrress</strong></td>
				<td id='customer_address_view'></td>
			</tr>
			<tr>
				<td><strong>Phone number</strong></td>
				<td id='customer_phone_number_view'></td>
			</tr>
			<tr>
				<td><strong>Tax identification number</strong></td>
				<td id='customer_npwp_view'></td>
			</tr>
		</table>
		<button type='button' class='button_success_dark' onclick='submit_customer()' id='input_customer_button'>Submit</button>
	</div>
</div>
<script>
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#proceed_button').click(function() {
		if($('#customer_name').val() == ''){
			alert('Please insert correct name!');
			$('#customer_name').focus();
			return false;
		} else if($('#customer_address').val() == '' && $('#customer_address_rt').val() == '' && $('#customer_address_rw').val() == '' && $('#customer_address_block').val() == '' && $('#customer_city').val() == ''){
			alert('Please insert correct address!');
			return false;
		} else if($('#pic_name').val() == ''){
			alert('Please insert person in charge name!');
			$('#pic_name').focus();
			return false;
		} else if($('#pic_prefix').val() == 0){
			alert('Insert correct prefix!');
			return false;
		} else if($('#customer_default_top').val() < 0 || $('#customer_default_top').val() > 60 || $('#customer_default_top').val() == ''){
			alert('Please insert valid term of payment');
			$('#customer_default_top').focus();
			return false;
		} else {
			var customer_name		= $('#customer_name').val();
			var customer_pic_raw	= $('#pic_prefix').val();
			if(customer_pic_raw		== 'Bapak'){
				var customer_pic	= 'Mr. ' + $('#pic_name').val();
			} else {
				var customer_pic	= 'Ms. ' + $('#pic_name').val();
			};
			var	customer_address	= $('#customer_address').val() + ' No. ' + $('#customer_address_number').val() + ' Blok ' + $('#customer_address_block').val();
			var customer_city		= $('#customer_city').val();
			var customer_npwp		= $('#customer_npwp').val();
			var customer_phone		= $('#customer_phone_number').val();
			
			$('#customer_name_view').text(customer_name);
			$('#customer_address_view').html(customer_address + '<br/>' + customer_city);
			$('#customer_npwp_view').text(customer_npwp);
			$('#customer_phone_number_view').text(customer_phone);
			$('#customer_pic_view').text(customer_pic);

			$('.full_screen_wrapper').fadeIn();
			
		}
	});
	
	function disable(){
		$('#kosong').attr('disabled',true);
	}
	
	function submit_customer(){
		$.ajax({
			url:"customer_create_input.php",
			data:{
				customer_npwp				: $('#customer_npwp').val(),
				customer_prefix 			: $('#pic_prefix').val(),
				customer_pic 				: $('#pic_name').val(),
				customer_phone 				: $('#customer_phone_number').val(),
				customer_name				: $('#customer_name').val(),
				customer_alamat 			: $('#customer_address').val(),
				customer_blok 				: $('#customer_address_block').val(),
				customer_rt 				: $('#customer_address_rt').val(),
				customer_rw 				: $('#customer_address_rw').val(),
				customer_city 				: $('#customer_city').val(),
				customer_nomor				: $('#customer_address_number').val(),
				customer_top				: $('#customer_default_top').val(),
			},
			type:"POST",
			beforeSend:function(){
				$('#input_customer_button').attr('disabled',true);
			},
			success:function(response){
				location.reload();
			},
		});
	}
</script>
</body>
</html>