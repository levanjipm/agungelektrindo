<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>

<?php
	include("connect.php");
	$term = $_GET['term'];
	$sql = "SELECT * FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%' LIMIT 20";
	$result = $conn->query($sql);
	$i=0;
	while($row = $result->fetch_object()) {
		$function_result[$i]=$row;
?>
	<div class="row" style="text-align:center">
		<div class="col-lg-3"><?= $row->reference ?></div>
		<div class="col-lg-5"><?= $row->description ?></div>
		<div class="col-lg-1">
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row->id ?>">Edit</button>
		</div>
<?php
	if ($row->isactive == 1){
?>
		<div class="col-lg-2">
			<a href="deactivate_item.php?id=<?= $row->id ?>">
				<button type="button" class="btn btn-warning">Set Inactive</button>
			</a>
		</div>
<?php
	} else{
?>
		<div class="col-lg-2">
			<a href="activate_item.php?id=<?= $row->id ?>">
				<button type="button" class="btn btn-success">Set Active</button>
			</a>
		</div>
	<?php } ?>
		<div class="col-lg-1">
			<button type="button" class="btn btn-danger">Delete</button>
		</div>
	</div>
	<br>
	<div class="modal" id="myModal-<?=$row->id?>" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Item List</h4>
				</div>
				<form id="editsupplier-<?= $row->id ?>" action="edititem.php" method="POST">
				<div class="modal-body">
					<input name="id" type="hidden" value="<?= $row->id ?>">
					<label for="name">reference</label>
					<input class="form-control" for="name" name="reference" value="<?= $row->reference ?>" required>
					<label for="name" >Description </label>
					<input class="form-control" for="name" name="description" value="<?=$row->description ?>" required>
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
		$i++;
	}
	// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	// header("Cache-Control: post-check=0, pre-check=0", false);
	// header("Pragma: no-cache");
	// header("Content-Type: application/json; charset=utf-8");
	//echo json_encode($function_result);
?>