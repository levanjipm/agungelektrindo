<?php
	include("purchasingheader.php");
?>
<div class="main">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div id="filter">
				<table width="100%" id="edititemtable">
					<tr class="header">
						<th style="text-align:center"><strong>Address Tag</strong></td>
						<th style="text-align:center"><strong>Address</strong></td>
						<td></td>
						<td></td>
					</tr>
				<?php
					$sql = "SELECT * FROM delivery_address";
					$result = $conn->query($sql);
					while($row = mysqli_fetch_array($result)) {
				?>
					<tr>
					<td style="text-align:center" width="40%"><?= $row['tag']?></td>
					<td style="text-align:center" width="40%"><?= $row['address']?></td>
					<td width="20%"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</td>
					<td width="20%"><button type="button" class="btn btn-danger">Delete</td>
					</tr>
				</div>
					<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title">Edit Item List</h4>
								</div>
								<form id="editdeliveryaddress-<?=$row['id']?>" action="editdeliveryaddress.php" method="POST">
								<div class="modal-body">
									<input name="id" type="hidden" value="<?php echo $row['id']?>">
									<label for="name">Address tag</label>
									<input class="form-control" for="name" name="tag" value="<?=$row['tag']?>" required>
									<label for="name" >Address</label>
									<input class="form-control" for="name" name="address" value="<?=$row['address']?>" required>
									<label for="city">City</label>
									<input class="form-control" for="name" name="city" value="<?=$row['city']?>" required>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-success"  id="edit">Edit</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				<?php
					}
				?>
				</table>
			</div>
		</div>
	</div>
</div>