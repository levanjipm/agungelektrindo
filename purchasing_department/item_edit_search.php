<?php
	include("../codes/connect.php");
	session_start();
	$user_id	= $_SESSION['user_id'];
	$sql		= "SELECT role FROM users WHERE id = '$user_id'";
	$result		= $conn->query($sql);
	$user		= $result->fetch_assoc();
	
	$role		= $user['role'];
	
	$term 		= $_GET['term'];
	$sql 		= "SELECT * FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%' ORDER BY reference ASC";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()) {
		if($row['type'] == 0 || $row['type'] == NULL){
			$type_text	= 'unassigned';
		} else {
			$sql_type 		= "SELECT name FROM itemlist_category WHERE id = '" . $row['type'] . "'";
			$result_type 	= $conn->query($sql_type);
			$type 			= $result_type->fetch_assoc();
			$type_text		= $type['name'];
		}
		
		$sql_disable 		= "SELECT 
							(SELECT COUNT(id) FROM quotation WHERE reference = '" . $row['reference'] . "') AS quotation_count,
							(SELECT COUNT(id) FROM sales_order WHERE reference = '" . $row['reference'] . "') AS so_count,
							(SELECT COUNT(id) FROM stock WHERE reference = '" . $row['reference'] . "') AS stock_count,
							(SELECT COUNT(id) FROM stock_value_in WHERE reference = '" . $row['reference'] . "') AS value_in_count";
		$result_disable 	= $conn->query($sql_disable);
		$disable 			= $result_disable->fetch_assoc();
		$disable_condition 	= $disable['quotation_count']  + $disable['so_count'] + $disable['stock_count'] + $disable['value_in_count'];		
?>
		<tr>
			<td><?= $row['reference'] ?></td>
			<td><?= $row['description'] ?></td>
			<td><?= $type_text ?></td>
<?php
	if($role == 'superadmin'){
?>
			<td>
				<button type="button" class="button_default_dark" onclick='open_edit_pane(<?= $row['id'] ?>)'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</button>
<?php
		if($disable_condition == 0){
?>
				<button type='button' class='button_warning_dark' onclick='disable(<?= $row['id'] ?>)'>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
<?php
		} else if($disable_condition > 0){
?>
				<button type='button' class='button_danger_dark' disabled>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
<?php
		}
?>
			</td>
<?php
	}
?>
		</tr>
<?php
	}
?>