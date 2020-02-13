<?php
	include('../codes/connect.php');
	$sql		= "SELECT COUNT(absentee_list.id) as absentee, COUNT(users.id) as users FROM absentee_list
					JOIN users ON absentee_list.user_id = users.id
					WHERE absentee_list.date = CURDATE() AND users.isactive = '1'";
	$result		= $conn->query($sql);
	$row		= $result->fetch_assoc();
	if($row['absentee'] == $row['users']){
?>
	<p style='font-family:museo'>There is no one to be list today</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>User</th>
			<th>Action</th>
		</tr>
<?php
		$not_in_array = '(';
		while($row	= $result->fetch_assoc()){
			$not_in_array .= $row['user_id'] . ',';
		}
		$array		= substr($not_in_array,0,-1) . ')';
		
		$sql		= "SELECT id, name FROM users WHERE id NOT IN $array AND isactive = '1'";
		$result		= $conn->query($sql);
		while($row	= $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['name'] ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='absentee_input(<?= $row['id'] ?>, 0)'><i class='fa fa-check'></i></button>
				<button type='button' class='button_danger_dark' onclick='absentee_input(<?= $row['id'] ?>, 1)'><i class='fa fa-trash'></i></button>
			</td>
		</tr>
<?php
		}
	}
?>