<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Supplier</h2>
	<p>Add new supplier</p>
	<hr>
	<div class='row'>
		<div class="col-sm-12">
			<label>Company name</label>
			<input type="text" class="form-control" id="name" required>
		</div>
		<div class="col-sm-4">
			<label>Street</label>
			<input type="text" class="form-control" id="address" required>
		</div>
		<div class="col-sm-4">
			<label>Number</label>
			<input type="text" class="form-control" id="number" required>	
		</div>
		<div class="col-sm-4">
			<label>City</label>
			<input type="text" class="form-control" id="city" required>
		</div>
		<div class="col-sm-4">
			<label for="name">Block</label>
			<input type="text" class="form-control" id="block" required>
		</div>
		<div class="col-sm-4">
			<label for="name">RT</label>
			<input type="text" class="form-control" id="rt" required>
		</div>
		<div class="col-sm-4">
			<label for="name">RW</label>
			<input type="text" class="form-control" id="rw" required>
		</div>
		<div class="col-sm-12">
			<br>
			<label for="name">Phone Number</label>
			<input type="text" class="form-control"	id="phone">
		</div>
		<div class="col-sm-12">
			<label for="Name">NPWP</label>
			<input type='text' class='form-control' id='npwp' name='npwp'/>
			<script>
				$("#npwp").inputmask("99.999.999.9-999.999");
			</script>
		</div>
	</div>
	<br>
	<button type="button" class="button_default_dark" id='next_button'>Next</button>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h3 style='font-family:bebasneue'>Input supplier</h3>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<td>Name</td>
				<td id='company_name'></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td id='phone_number'></td>
			</tr>
			<tr>
				<td>Address</td>
				<td id='company_address'></td>
			</tr>
			<tr>
				<td>NPWP</td>
				<td id='company_tax'></td>
			</tr>
		</table>
		<br>
		<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	</div>
</div>
</body>
</html>
<script>
$('#next_button').click(function(){
	phone_expression = /[0-9][\s\./0-9]*$/;
	if(!phone_expression.test($('#phone').val())){
		alert('Incorrect format phone number');
		return false;
	} else if($('#phone').val().length <= 5){
		alert('Phone number length is insufficient');
		$('#phone').focus();
		return false
	} else if($('#namaperusahaan').val() == ''){
		alert('Please insert a valid value');
		$('#namaperusahaan').focus();
		return false;
	} else if($('#alamat').val() == ''){
		alert('Please insert a valid value');
		$('#alamat').focus();
		return false;
	} else if($('#number').val() == ''){
		alert('Please insert a valid value');
		$('#number').focus();
		return false;
	} else if($('#rt').val() == '' || $('#rt').val().length < 3){
		alert('Please insert a valid value');
		$('#rt').focus();
		return false;
	} else if($('#rw').val() == '' || $('#rw').val().length < 3){
		alert('Please insert a valid value');
		$('#rw').focus();
		return false;
	} else if($('#city').val() == ''){
		alert('Please insert a valid value');
		$('#city').focus();
		return false;
	} else {
		$('#company_name').html($('#namaperusahaan').val());
		$('#company_address').html($('#alamat').val() + ' no.' + $('#number').val() + ' blok ' + $('#blok').val());
		$('#phone_number').html($('#phone').val());
		$('#company_tax').html($('#npwp').val());

		$('.full_screen_wrapper').fadeIn();
	}
});

$('#submit_button').click(function(){
	$.ajax({
		url:'supplier_add.php',
		data:{
			name: $('#name').val(),
			address: $('#address').val(),
			number: $('#number').val(),
			city: $('#city').val(),
			block: $('#block').val(),
			rt: $('#rt').val(),
			rw: $('#rw').val(),
			phone: $('#phone').val(),
			npwp: $('#npwp').val(),
		},
		type:'POST',
		beforeSend:function(){
			$('#submit_button').attr('disabled',true);
		},
		success:function(){
			$('#submit_button').attr('disabled',false);
			location.reload();
		}
	});
});

$('.full_screen_close_button').click(function(){
	$('.full_screen_wrapper').fadeOut();
});
</script>