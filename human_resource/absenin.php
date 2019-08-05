<?php
	include('../codes/connect.php');
	$date = $_POST['date'];
	$user_id = $_POST['user_id'];
	
	if($_POST['tipe'] == 1){
		$sql = "INSERT INTO absentee_list (user_id,date,time) VALUES ('$user_id','$date',CURTIME())";
		$result = $conn->query($sql);
	} else {
		$sql = "INSERT INTO absentee_list (user_id,date,time,isdelete) VALUES ('$user_id','$date',CURTIME(),'1')";
		$result = $conn->query($sql);
	}
?>
<h2 style='font-family:bebasneue'>Absentee</h2>
<?php
	$sql_user_absen = "SELECT id,name FROM users";
	$result_user_absen = $conn->query($sql_user_absen);
	while($user_absen = $result_user_absen->fetch_assoc()){
		$sql_absen = "SELECT * FROM absentee_list WHERE date = '" . date('Y-m-d') . "' AND user_id = '" . $user_absen['id'] . "'";
		$result_absen = $conn->query($sql_absen);
		if(mysqli_num_rows($result_absen) == 0){
?>
		<button type='button' class='btn btn-absent' onclick='absent(<?= $user_absen['id'] ?>)'><?= $user_absen['name'] ?></button>
		<button type='button' class='btn btn-danger' onclick='confirm_delete(<?= $user_absen['id'] ?>)'>X</button>
		<br>
		<br>
<?php
		}
	}
?>