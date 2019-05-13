<?php
	include("salesheader.php");
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class="main" style='padding-top:0'>
	<div class='row'>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
		<div class='col-sm-10'>
			<div class="container">
				<h2>Customer</h2>
				<p>Edit customer data</p>
				<hr>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php
						$sql = "SELECT * FROM customer ORDER BY name";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
					?>
					<table id="edititemtable" style="width:100%">
						<tr>
							<td style="text-align:center"><strong>Name</strong></td>
							<td style="text-align:center"><strong>Address</strong></td>
							<td></td>
						</tr>
					<?php
						$i = 1;
						while($row = mysqli_fetch_array($result)) {
					?>
						<tr>
						<td><?= $row['name']?></td>
						<td><?= $row['address']?></td>
						<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</td>
						</tr>
						
						<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Input Supplier Data</h4>
									</div>
									<form id="editsupplier-<?=$row['id']?>" action="editcustomer.php" method="POST">
									<div class="modal-body">
										<input name="id" type="hidden" value="<?php echo $row['id']?>">
										<label for="name">Company: </label>
										<input class="form-control" for="name" name="namaperusahaan" value="<?=$row['name']?>" required>
										<label for="name" >Address: </label>
										<input class="form-control" for="name" name="address" value="<?=$row['address']?>" required>
										<label for="name" >NPWP: </label>
										<input class="form-control" for="name" name="npwp" value="<?=$row['npwp']?>" id='npwp<?= $i ?>' oninput='liat_npwp(<?= $i ?>)'>
										<label for="name" >Person in Charge: </label>
											<select  name="prefix" id="prefix" onclick="disable()" class="form-kontol">
												<option value="<?=$row['prefix']?>"><?=$row['prefix']?></option>
												<option value="Bapak">Bapak</option>
												<option value="Ibu">Ibu</option>
											</select>
										<input class="form-control" for="name" name="pic" value="<?=$row['pic']?>">
										<label for="name" >Phone number: </label>
										<input class="form-control" for="name" name="phone" value="<?=$row['phone']?>" required>
										</input>
										<label for="name" >City: </label>
										<input class="form-control" for="name" name="city" value="<?=$row['city']?>" required>
										</input>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-success">Edit</button>
									</div>
									</form>
								</div>
							</div>
						</div>
					<?php
						$i++;
					}
					?>
					</table>
					<?php
					} else {
						echo "0 results";
					}
					?>
				</div>
			</div>
		</div>
		<div class='col-sm-1' style='background-color:#ddd'>
		</div>
	</div>
</div>
</body>
</html>
<script>
	$("input[id^=npwp]").inputmask("99.999.999.9-999.999");
</script>
