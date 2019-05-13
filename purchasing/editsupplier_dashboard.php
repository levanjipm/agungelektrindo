<?php
	include("purchasingheader.php");
?>
<div class="main" style='padding-top:0'>
	<div class='row'>
		<div class='col-sm-1' style='background-color:#ccc'>
		</div>
		<div class='col-sm-10' style='padding:30px'>
			<div class="container" style="right:50px">
			<h2>Supplier</h2>
			<h4 style="color:#444">Edit supplier</h4>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-12">
					<?php
						$sql = "SELECT * FROM supplier";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
					?>
					<table id="edititemtable" style="width:100%">
						<tr>
							<td style="text-align:center"><strong>Name</strong></td>
							<td style="text-align:center"><strong>Address</strong></td>
					<?php
						if($role == 'superadmin'){
							echo ("<td></td>");
						}
					?>
						</tr>
					<?php
						while($row = mysqli_fetch_array($result)) {
					?>
						<tr>
						<td><?= $row['name']?></td>
						<td><?= $row['address']?></td>
					<?php
						if($role == 'superadmin'){
					?>
						<td><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</td>
						</tr>				
						<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title">Edit Supplier Data</h4>
									</div>
									<form id="editsupplier-<?=$row['id']?>" action="editsupplier.php" method="POST">
									<div class="modal-body">
										<input name="id" type="hidden" value="<?php echo $row['id']?>">
										<label for="name">Company: </label>
										<input class="form-control" for="name" name="namaperusahaan" value="<?=$row['name']?>" required>
										<label for="name" >Address: </label>
										<input class="form-control" for="name" name="address" value="<?=$row['address']?>" required>
										<label for="name" >NPWP: </label>
										<input class="form-control" for="name" name="npwp" value="<?=$row['npwp']?>">
										</input>
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
						} else {
					}
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
		<div class='col-sm-1' style='background-color:#ccc'>
		</div>
	</div>
</div>