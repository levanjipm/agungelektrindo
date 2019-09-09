<?php
	include("purchasingheader.php")
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class="main">
	<form id="inputsupplier" method="POST" action="addsupplier.php">
		<h2 style='font-family:bebasneue'>Supplier</h2>
		<p>Add new supplier</p>
		<hr>
		<div class="col-sm-12">
			<label for="name">Nama Perusahaan:</label>
			<input type="text" class="form-control" name="namaperusahaan" id="namaperusahaan" placeholder="input nama Perusahaan..." required></input>
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
		<div class="col-sm-10">
			<br>
			<label for="name">Phone Number</label>
			<input id="phone" name="phone" type="text" class="form-control"></input>
		</div>
		<div class="col-sm-10">
			<label for="Name">NPWP</label>
			<input type='text' class='form-control' id='npwp' name='npwp'/>
			<script>
				$("#npwp").inputmask("99.999.999.9-999.999");
			</script>
		</div>
		<div class="col-sm-3" style="padding:10px">
			<button type="button" class="button_default_dark" id="submitBtn" onclick="getdata()">Submit Here</button>
			<div class="modal" id="myModal" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Input Supplier Data</h4>
						</div>
						<div class="modal-body">
							<table class="table">
								<tr>
									<th>Nama Perusahaan</th>
									<td id="namaperusahaans"></td>
								</tr>
								<tr>
									<th>Alamat</th>
									<td id="alamats"></td>
								</tr>
								<tr>
									<th>NPWP</th>
									<td id="npwps"></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success">Proceed</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
</body>
</html>
<script>
function getdata(){
	phone_expression = /[0-9][\s\./0-9]*$/;
	if(!phone_expression.test($('#phone').val())){
		alert('Incorrect format phone number');
		return false;
	} else if($('#phone').val().length <= 5){
		alert('Phone number length is insufficient');
		$('#phone').focus();
		return false
	} else if($('#namaperusahaan').val() == ''){
		alert('Name is required');
		$('#namaperusahaan').focus();
		return false;
	} else if($('#alamat').val() == ''){
		alert('Address is required');
		$('#alamat').focus();
		return false;
	} else if($('#number').val() == ''){
		alert('Number is required');
		$('#number').focus();
		return false;
	} else if($('#rt').val() == ''){
		alert('RT value is required');
		$('#rt').focus();
		return false;
	} else if($('#rw').val() == ''){
		alert('RW value is required');
		$('#rw').focus();
		return false;
	} else if($('#city').val() == ''){
		alert('City is required');
		$('#city').focus();
		return false;
	} else {
		$('#myModal').modal('show');
		$('#namaperusahaans').html($('#namaperusahaan').val());
		$('#alamats').html($('#alamat').val() + ' no.' + $('#number').val() + ' blok ' + $('#blok').val());
	}
};
</script>