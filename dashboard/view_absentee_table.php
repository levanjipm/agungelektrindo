<?php
	include('../codes/connect.php');
?>
	<table class='table table-bordered' id='table_to_absent'>
		<tr>
			<th>Name</th>
			<th colspan='2'></th>
		</tr>
		<tbody id='table_body_absent'>
<?php
	$sql_user_absen 		= "SELECT id,name FROM users WHERE isactive = '1'";
	$result_user_absen 		= $conn->query($sql_user_absen);
	while($user_absen 		= $result_user_absen->fetch_assoc()){
		$id					= $user_absen['id'];
		$name				= $user_absen['name'];
		
		$sql_absen 			= "SELECT id FROM absentee_list WHERE date = '" . date('Y-m-d') . "' AND user_id = '$id'";
		$result_absen 		= $conn->query($sql_absen);
		if(mysqli_num_rows($result_absen) == 0){
?>
			<tr>
				<td><?= $name ?></td>
				<td>
					<button type='button' class='button_default_dark' onclick='input_absent(<?= $id ?>)'><i class="fa fa-check"></i></button>
					<button type='button' class='button_danger_dark' onclick='delete_absent(<?= $id ?>)'><i class='fa fa-trash'></i></button>
				</td>
			</tr>
<?php
		}
	}
?>
		</tbody>
	</table>
	<script>
		function input_absent(n){
			$.ajax({
				url:'/agungelektrindo/dashboard/input_absentee.php',
				data:{
					user_id: n,
					date: "<?= date('Y-m-d') ?>",
					tipe: "1",
				},
				type:'POST',
				success:function(){
					refresh_absentee();
				},
			});
			var Number_of_row = $('#table_body_absent tr').length;
			if(Number_of_row == 0){
				$('#table_to_absent').hide();
			};
		};
		
		function delete_absent(n){
			$.ajax({
				url:'/agungelektrindo/dashboard/input_absentee.php',
				data:{
					user_id: n,
					date: "<?= date('Y-m-d') ?>",
					tipe: "2",
				},
				type:'POST',
				success:function(){
					refresh_absentee();
				},
			});
		};
	</script>