<?php
	include('../codes/connect.php');
	$user_id			= $_POST['user_id'];
?>
	<h2 style='font-family:bebasneue'>Edit user</h2>
	<p>Set authority</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Department name</th>
			<th>Authority</th>
		</tr>
<?php
	$sql_edit_user		= "SELECT * FROM users WHERE id = '$user_id'";
	$result_edit_user	= $conn->query($sql_edit_user);
	$user_data			= $result_edit_user->fetch_assoc();
	
	$user_name			= $user_data['name'];
	$user_role			= $user_data['role'];
	
	$sql_department		= "SELECT * FROM departments ORDER BY department ASC";
	$result_department	= $conn->query($sql_department);
	while($department	= $result_department->fetch_assoc()){
		$dept_name		= $department['department'];
		$dept_id		= $department['id'];
		
		$sql_auth		= "SELECT id FROM authorization WHERE user_id = '$user_id' AND department_id =  '$dept_id'";
		$result_auth	= $conn->query($sql_auth);
?>
		<tr>
			<td><?= $dept_name ?></td>
			<td>
<?php
		if(mysqli_num_rows($result_auth) == 1){
?>
				<button type='button' class='button_danger_dark' id='del_auth_button' onclick='delete_auth(<?= $user_id ?>,<?= $dept_id ?>)'><i class="fa fa-lock" aria-hidden="true"></i></button>
<?php
		} else {
?>
				<button type='button' class='button_success_dark' id='add_auth_button'  onclick='add_auth(<?= $user_id ?>,<?= $dept_id ?>)'><i class="fa fa-unlock" aria-hidden="true"></i></button>
<?php
		}
?>
			</td>
		</tr>
<?php
	}
?>
<script>
function add_auth(user,department){
		$.ajax({
			url		: 'add_authority.php',
			data	: {
				user: user,
				dept: department,
			},
			type	: 'POST',
			beforeSend:function(){
				$('#del_auth_button').attr('disabled',true);
			},
			success:function(response){
				$('#del_auth_button').attr('disabled',false);
				if(reponse == 1){
					$('#del_auth_button').removeClass('button_success_dark').addClass('button_danger_dark');
				}
			},
		})
	};
	
	function delete_auth(user,department){
		$.ajax({
			url		: 'delete_authority.php',
			data	: {
				user: user,
				dept: department,
			},
			type	: 'POST',
			beforeSend:function(){
				$('#add_auth_button').attr('disabled',true);
			},
			success:function(response){
				$('#add_auth_button').attr('disabled',false);
				$('#add_auth_button').removeClass('button_danger_dark').addClass('button_success_dark');
			},
		})
	};
</script>