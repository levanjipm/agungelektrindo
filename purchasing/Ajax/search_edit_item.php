<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<?php
	include("../../Codes/connect.php");
	session_start();
	$term 			= mysqli_real_escape_string($conn,$_GET['term']);
	$sql 			= "SELECT itemlist.reference, itemlist.description, itemlist_category.name AS type
					FROM itemlist 
					JOIN itemlist_category ON itemlist.type = itemlist_category.id
					WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%' ORDER by reference ASC";
	$result 		= $conn->query($sql);
	$sql_user 		= "SELECT name, role FROM users WHERE id = " . $_SESSION['user_id'];
	$result_user 	= $conn->query($sql_user);
	$row_user 		= $result_user->fetch_assoc();
	$role 			= $row_user['role'];
	$user_name 		= $row_user['name'];
	
	while($row = $result->fetch_assoc()) {
		if($role == 'superadmin'){
?>
		<div class='row' style='text-align:center;margin-top:10px'>
			<div class="col-sm-3">
				<p><?= $row['reference']; ?></p>
			</div>
			<div class="col-sm-4">
				<p><?= $row['description']; ?></p>
			</div>
			<div class="col-sm-3">
				<p><?= $row['type'] ?></p>
			</div>
<?php
		} else {
?>
		<div class='row' style='text-align:center;margin-top:10px'>
			<div class="col-sm-3">
				<p><?= $row['reference']; ?></p>
			</div>
			<div class="col-sm-6">
				<p><?= $row['description']; ?></p>
			</div>
			<div class="col-sm-3">
				<p><?= $row['type']; ?></p>
			</div>
		</div>
<?php
		}
		if($role == 'superadmin'){
			$sql_disable 		= "SELECT 
								(SELECT COUNT(id) FROM quotation WHERE reference = '" . $row['reference'] . "') AS quotation_count,
								(SELECT COUNT(id) FROM sales_order WHERE reference = '" . $row['reference'] . "') AS so_count,
								(SELECT COUNT(id) FROM stock WHERE reference = '" . $row['reference'] . "') AS stock_count,
								(SELECT COUNT(id) FROM stock_value_in WHERE reference = '" . $row['reference'] . "') AS value_in_count";
			$result_disable 	= $conn->query($sql_disable);
			$disable 			= $result_disable->fetch_assoc();
			$disable_condition 	= $disable['quotation_count']  + $disable['so_count'] + $disable['stock_count'] + $disable['value_in_count'];
?>
			<div class="col-sm-2">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal-<?=$row['id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></button>
<?php
			if($disable_condition == 0){
?>					
				<button type='button' class='btn btn-default' onclick='disable(<?= $row['id'] ?>)'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
<?php
			} else {
?>
				<button type='button' class='btn btn-default' disabled><i class="fa fa-trash-o" aria-hidden="true"></i></button>
<?php
			}
?>
			</div>
		</div>
		<br>
		<div class="modal" id="myModal-<?= $row['id'] ?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit Item List</h4>
					</div>
					<form id="editsupplier-<?= $row['id'] ?>">
						<div class="modal-body">
							<input name="id" type="hidden" value="<?= $row['id'] ?>">
							<label for="name">reference</label>
							<input class="form-control" for="name" name="reference" value="<?=$row->reference ?>" id ='reference<?= $row['id'] ?>' required>
							<label for="name" >Description </label>
							<input class="form-control" for="name" name="description" id="description<?= $row['id'] ?>" value="<?= $row['description'] ?>" required>
							<label>Type</label>
							<select class='form-control' name='type' id='type<?= $row['id'] ?>'>
								<option value='0'>Please select a type</option>
<?php
					$sql_brand 		= "SELECT DISTINCT type FROM itemlist WHERE type <> '' ORDER BY type ASC";
					$result_brand 	= $conn->query($sql_brand);
					while($brand 	= $result_brand->fetch_assoc()){
?>
								<option value='<?= $brand['type'] ?>'><?= $brand['type'] ?></option>
<?php
					}
?>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-success" onclick='send_edit(<?= $row['id'] ?>)' id="edit">Edit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php
		}
	}
?>