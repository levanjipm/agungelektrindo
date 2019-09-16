<?php
	include('hrheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Set inactive</h2>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>User name</th>
			<th></th>
		</tr>
<?php
	$sql_user		= "SELECT * FROM users WHERE isactive = '1'";
	$result_user	= $conn->query($sql_user);
	while($user		= $result_user->fetch_assoc()){
?>
		<tr>
			<td><?= $user['id'] ?></td>
			<td><?= $user['name'] ?></td>
			<td><?= $user['username'] ?></td>
			<td>
				<button type='button' class='button_danger_dark' onclick='set_inactive(<?= $user['id'] ?>)'>Set inactive</button>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<h2 style='font-family:bebasneue'>Set active</h2>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>User name</th>
			<th></th>
		</tr>
<?php
	$sql_user		= "SELECT * FROM users WHERE isactive = '0'";
	$result_user	= $conn->query($sql_user);
	while($user		= $result_user->fetch_assoc()){
?>
		<tr>
			<td><?= $user['id'] ?></td>
			<td><?= $user['name'] ?></td>
			<td><?= $user['username'] ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='set_active(<?= $user['id'] ?>)'>Set active</button>
			</td>
		</tr>
<?php
	}
?>
</div>
<script>
	function set_active(n){
		