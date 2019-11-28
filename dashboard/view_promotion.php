<?php
	include('../codes/connect.php');
	session_start();
	$sql_user 		= "SELECT role FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user	= $conn->query($sql_user);
	$user			= $result_user->fetch_assoc();
	
	$role			= $user['role'];
	
	$sql			= "SELECT * FROM promotion WHERE start_date <= CURDATE() AND end_date >= CURDATE()";
	$result			= $conn->query($sql);
	if(mysqli_num_rows($result) != 0){
		$row		= $result->fetch_assoc();
		if($row['image_url'] != NULL){
?>
			<img src='../sales/<?= $row['image_url'] ?>' style='width:80%;margin-left:10%;'>
<?php
		}
?>
		<h2 style='font-family:bebasneue'><?= $row['name'] ?></h2>
		<p><?= $row['description'] ?></p>
		<p><i>Valid until <?= date('d F Y',strtotime($row['end_date'])) ?></i></p>
<?php
	} else {
		echo ('There is no promotion at the time');
	}
?>
	<hr>