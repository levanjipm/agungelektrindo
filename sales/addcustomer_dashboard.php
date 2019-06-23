<?php
	include("salesheader.php")
?>
<style>
	.alert_wrapper{
		position:absolute;
		z-index:105;
	}
</style>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class="main" style='padding-top:0'>
	<div class='alert_wrapper'>
		<div class="alert alert-warning" id='alert_npwp' style='display:none'>
			<strong>Warning!</strong>NPWP number does not met the criteria set.
		</div>
		<div class="alert alert-warning" id='alert_exist' style='display:none'>
			<strong>Warning!</strong>Customer already exist!
		</div>
		<div class="alert alert-success" id='alert_success' style='display:none'>
			input data success!
		</div>
		<div class="alert alert-danger" id='alert_failed' style='display:none'>
			<strong>Warning!</strong>Input failed!
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
		<div class='col-sm-10'>
			<div class="container">
				<h2>Customer</h2>
				<p>Add new customer data</p>
				<hr>
			</div>
			<form id="inputcustomer" method="POST" action="addcustomer.php">
				<div class="row">
					<div class="col-sm-12">
					<label for="name">Nama Perusahaan:</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
							<input type="text" class="form-control" name="namaperusahaan" id="namaperusahaan" placeholder="input nama Perusahaan..." required></input>
						</div>
					</div>
					<div class="col-sm-12" style="padding-top:12px">
					<label for-"name">Person in Charge: </label>
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<span class="input-group-addon">
								<select  class="selectmr" name="prefix" id="prefix" onclick="disable()" required>
									<option value="0" id="kosong">Select</option>
									<option value="Bapak">Mr.</option>
									<option value="Ibu">Ms.</option>
								</select>
							</span>
							<input type="text" class="form-control" id="pic" name="pic" placeholder="Person in charge...">
						</div>
					</div>
					<div class="col-sm-4">
						<label for="name">Jalan</label>
						<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Nama Jalan..." required></input>
					</div>
					<div class="col-sm-4">
						<label for="name">Nomor</label>
						<input type="text" class="form-control" name="nomor" id="number" placeholder="Nomor..." required></input>	
					</div>
					<div class="col-sm-4">
						<label for="name">Kota</label>
						<input type="text" class="form-control" name="city" id="city" placeholder="Kota..." required></input>
					</div>
					<div class="col-sm-4">
						<label for="name">Blok</label>
						<input type="text" class="form-control" name="blok" id="blok" placeholder="Blok..." required></input>
					</div>
					<div class="col-sm-4">
						<label for="name">RT</label>
						<input type="text" class="form-control" name="rt" id="rt" placeholder="RT..." required minlength="3" maxlength="3"></input>
					</div>
					<div class="col-sm-4">
						<label for="name">RW</label>
						<input type="text" class="form-control" name="rw" id="rw" placeholder="RW..." required minlength="3" maxlength="3"></input>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-10">
						<label for="name">Phone Number</label>
						<input id="phone" name="phone" type="text" class="form-control"></input>
					</div>
				</div>
				<div class='row'>
					<div class="col-sm-10">
						<label for="Name">NPWP</label>
						<input type='text' class='form-control' id='npwp' name='npwp'/>
						<script>
							$("#npwp").inputmask("99.999.999.9-999.999");
						</script>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3" style="padding:10px">
						<button type="button" class="btn btn-primary" id="submitBtn">Submit Here</button>
						<div class="modal" id="myModal" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Input Customer Data</h4>
									</div>
									<div class="modal-body">
										<table class="table">
											<tr>
												<th style="width:30%">Nama Perusahaan</th>
												<td id="namaperusahaans"></td>
											</tr>
											<tr>
												<th style="width:30%">Person in charge</th>
												<td id="picss"></td>
											</tr>
											<tr>
												<th style="width:30%">Alamat</th>
												<td id="alamats"></td>
											</tr>
											<tr>
												<th style="width:30%">NPWP</th>
												<td id="npwps"></td>
											</tr>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id='close_modal'>Close</button>
										<button type="button" class="btn btn-success" onclick='proceed()'>Proceed</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
	<div>
</div>
<script>
$('#submitBtn').click(function() {
	if($('#namaperusahaan').val() == ''){
		alert('Please insert correct name!');
		return false;
	} else if($('#alamat').val() == '' && $('#rt').val() == '' && $('#rw').val() == '' && $('#blok').val() == '' && $('#city').val() == ''){
		alert('Please insert correct address!');
		return false;
	} else if($('#pic').val() == ''){
		alert('Please insert person in charge name!');
		return false;
	} else if($('#pa').val() == 0){
		alert('Insert correct prefix!');
		return false;
	} else {
		$('#namaperusahaans').text($('#namaperusahaan').val());
		$('#alamats').text($('#alamat').val());
		var npwp = $('#npwp').val();
		$('#npwps').html(npwp);
		var pre = $('#prefix').val();
		var pa = $('#pic').val();
		var pics = pre + " " +pa;
		$('#picss').text(pics);
		$('#myModal').modal('toggle');
	}
});
function disable(){
	document.getElementById("kosong").disabled = true;
}
function proceed(){
	$.ajax({
		url:"addcustomer.php",
		data:{
			npwp : $('#npwp').val(),
			prefix : $('#prefix').val(),
			pic : $('#pic').val(),
			prefix : $('#prefix').val(),
			phone : $('#phone').val(),
			namaperusahaan : $('#namaperusahaan').val(),
			alamat : $('#alamat').val(),
			blok : $('#blok').val(),
			rt : $('#rt').val(),
			rw : $('#rw').val(),
			city : $('#city').val(),
			nomor: $('#number').val(),
		},
		type:"POST",
		success:function(response){
			if(response == 0){
				$('#close_modal').click();
				$('#alert_exist').fadeIn();
				setTimeout(function(){
					$('#alert_exist').fadeOut();
				},1000);
			} else if(response == 1){
				$('#close_modal').click();
				$('#alert_success').fadeIn();
				setTimeout(function(){
					$('#alert_success').fadeOut();
				},1000);
			} else if(response == 2){
				$('#close_modal').click();
				$('#alert_failed').fadeIn();
				setTimeout(function(){
					$('#alert_failed').fadeOut();
				},1000);
			}
		},
	});
}
</script>
</body>
</html>