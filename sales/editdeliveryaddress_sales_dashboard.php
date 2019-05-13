<?php
	include('salesheader.php');
?>
	<div class="main">
		<table class="table">
			<tr>
				<th>Tag</th>
				<th>Address</th>
				<th>City</th>
				<th></th>
			</tr>
<?php
	$sql = "SELECT * FROM delivery_address";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
			<tr>
				<td><?= $row['tag']; ?></td>
				<td><?= $row['address']; ?></td>
				<td><?= $row['city']; ?></td>
				<td><button type='button' class='btn btn-default' data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Edit</button></td>
			</tr>
			<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Edit Item List</h4>
						</div>
						<form id="edit_deliveryaddress-<?=$row['id']?>" action="edit_deliveryaddress.php" method="POST">
							<div class="modal-body">
								<input name="id" type="hidden" value="<?php echo $row['id']?>">
								<label for="name">Tag</label>
								<input class="form-control" for="name" name="tag" value="<?=$row['tag']?>" required>
								<label for="name">Address</label>
								<input class="form-control" for="name" name="address" value="<?=$row['address']?>" required>
								<label for="name" >City </label>
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