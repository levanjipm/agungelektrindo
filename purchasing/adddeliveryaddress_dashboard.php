<?php
	include("purchasingheader.php");
?>
<div class="main" style='padding-top:0px'>
	<div class='row' style='height:100%'>
		<div class='col-sm-1' style='background-color:#ccc'>
		</div>
		<div class='col-sm-10'>
			<div class="container" style="right:50px">
			<h2>Delivery Address</h2>
			<h4 style="color:#444">Add delivery address</h4>
			</div>
			<hr>
			<form id="inputda" method="POST" action="adddeliveraddress.php">
				<div class="row">
					<div class="col-lg-6">
						<label for="tag">Address Tag</label>
						<input type="text" class="form-control" name="tag" required>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4">
						<label for="name">Jalan</label>
						<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Nama Jalan..." required></input>
					</div>
					<div class="col-lg-4">
						<label for="name">Nomor</label>
						<input type="text" class="form-control" name="nomor" id="nomor" placeholder="Nomor..." required></input>	
					</div>
					<div class="col-lg-4">
						<label for="name">Kota</label>
						<input type="text" class="form-control" name="city" id="city" placeholder="Kota..." required></input>
					</div>
					<div class="col-lg-4">
						<label for="name">Blok</label>
						<input type="text" class="form-control" name="blok" id="blok" placeholder="Blok..." required></input>
					</div>
					<div class="col-lg-4">
						<label for="name">RT</label>
						<input type="text" class="form-control" name="rt" id="rt" placeholder="RT..." required minlength="3" maxlength="3"></input>
					</div>
					<div class="col-lg-4">
						<label for="name">RW</label>
						<input type="text" class="form-control" name="rw" id="rw" placeholder="RW..." required minlength="3" maxlength="3"></input>
					</div>
				</div>
				<div class="row" style="margin-top:20px">
					<div class="col-lg-6">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>	
			</form>
		</div>
		<div class='col-sm-1' style='background-color:#ccc'>
		</div>
	</div>
</div>
<script>
$('#submitbutton').click(function() {
	$('#itemref').text($('#itemreff').val());
	$('#itemdesc').text($('#itemdescs').val());
});
</script>
</body>
</html>