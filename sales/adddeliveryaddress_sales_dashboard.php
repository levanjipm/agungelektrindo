<?php
	include("salesheader.php");
?>
<div class="main">
	<h2>Delivery Address</h2>
	<p>Add delivery address</p>
	<hr>
	<form method="POST" action="adddeliveryaddress_sales.php">
		<div class="row">
			<div class="col-lg-6">
				<label for="tag">Customer</label><br>
				<select class="form-control" id="select_customer" name="select_customer"  onclick="disable_two()">
					<option id="customer_one" value="">Please select a customer--</option>
						<?php
							include("connect.php");
							$sql = "SELECT id,name,address FROM customer";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								while($row = mysqli_fetch_array($result)) {
								echo '<option id="pilih" value="' . $row["id"] . '">'. $row["name"].'</option> ';
								}
							} else {
								echo "0 results";
							}
						?>
				</select>
			</div>	
		</div>
		<br><br>
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
</body>
</html>