<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<?php
	include("../../Codes/connect.php");
	$term = $_GET['term'];
	$sql = "SELECT * FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%' ORDER by reference ASC LIMIT 20";
	$result = $conn->query($sql);
	$i=0;
	//Starting the session for users//
	session_start();
	//Collecting users data from the session datum obtained//
	$sql_user = "SELECT name, role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user = $conn->query($sql_user);
	while($row_user = $result_user->fetch_assoc()){
		$role = $row_user['role'];
		$user_name = $row_user['name'];
	};
	//If user is set as superadmin, he can edit item//
	if($role == 'superadmin'){
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
	//Do not show the inactive items on default//
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
				<form id="editsupplier-<?= $row->id ?>">
				<div class="modal-body">
					<input name="id" type="hidden" value="<?= $row->id ?>">
					<label for="name">reference</label>
					<input class="form-control" for="name" name="reference" value="<?=$row->reference ?>" id ='reference<?= $row->id ?>' required>
					<label for="name" >Description </label>
					<input class="form-control" for="name" name="description" id="description<?= $row->id ?>" value="<?=$row->description ?>" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" onclick='send_edit(<?= $row->id ?>)' id="edit">Edit</button>
				</div>
				</form>
			</div>
		</div>
	</div>
<?php
	$i++;
	}
	}	else {
		while($row = $result->fetch_object()) {
			$function_result[$i]=$row;
?>
	<div class="row" style="text-align:center;padding:10px;">
		<div class="col-lg-4"><?= $row->reference ?></div>
		<div class="col-lg-8"><?= $row->description ?></div>
	</div>
<?php
		$i++;
		}
	}
?>