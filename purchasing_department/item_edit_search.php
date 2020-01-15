<?php
	include("../codes/connect.php");
	session_start();
	$user_id	= $_SESSION['user_id'];
	$sql		= "SELECT role FROM users WHERE id = '$user_id'";
	$result		= $conn->query($sql);
	$user		= $result->fetch_assoc();
	if(empty($_GET['page'])){
		$page	= 0;
	} else {
		$page	= ($_GET['page'] - 1) * 25;
	}
	
	$role		= $user['role'];
?>
	<table class='table table-bordered'>
		<tr>
			<th style='width:20%'>Reference</th>
			<th style='width:40%'>Description</th>
			<th style='width:20%'>Type</th>
<?php if($role == 'superadmin'){ ?>
			<th></th>
<?php } ?>
		</tr>
<?php
	if(empty($_GET['term'])){
		$sql		= "SELECT * FROM itemlist ORDER BY reference ASC LIMIT 25 OFFSET $page";
		$sql_count	= "SELECT COUNT(id) as counted FROM itemlist";
	} else {
		$term 		= $_GET['term'];
		$sql 		= "SELECT * FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%' ORDER BY reference ASC LIMIT 25 OFFSET $page";
		$sql_count	= "SELECT COUNT(id) as counted FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%'";
	}
	
	$result 		= $conn->query($sql);
	$result_count	= $conn->query($sql_count);
	$count			= $result_count->fetch_assoc();
	$max_page		= ceil($count['counted'] / 25);
	
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
	</table>
	<p style='font-family:museo'>Total record: <?= number_format($count['counted']) ?></p>
	<select class='form-control' id='page' style='width:100px;display:inline-block'>
<?php
	for($i = 1; $i <= $max_page; $i++){
?>
	<option value='<?= $i ?>' <?php if(!empty($_GET['page']) && $_GET['page'] == $i){ echo 'selected disabled'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
	<button type='button' class='button_default_dark' id='search_page' style='display:inline-block'><i class='fa fa-search'></i></button>
	<script>
		$('#search_page').click(function(){
			$.ajax({
				url: "item_edit_search.php",
				data: {
					term: $('#search_item_bar').val(),
					page: $('#page').val(),
				},
				type: "GET",
				dataType: "html",
				beforeSend:function(){
					$('#search_item_bar').attr('disabled',true);
					$('#edit_item_table').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
				},
				success: function (data) {
					$('#search_item_bar').attr('disabled',false);
					$('#edit_item_table').html(data);
				},
			});
		});
	</script>