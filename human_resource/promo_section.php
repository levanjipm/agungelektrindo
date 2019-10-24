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
?>

		<h2 style='font-family:bebasneue'><?= $row['name'] ?></h2>
		<p><?= $row['description'] ?></p>
		<p><i>Valid until <?= date('d F Y',strtotime($row['end_date'])) ?></i></p>
<?php
		if($role	== 'superadmin'){
?>
		<button type='button' class='button_success_dark'>Edit Promotion</button>
<?php
		}
	} else {
		echo ('There is no promotion at the time');
	}
?>
	<hr>
	<button type='button' class='button_default_dark' id='create_promo_button'>Create new promotion</button>
	<script>
	$('#create_promo_button').click(function(){
		$('#create_news_wrapper').fadeIn();
		$('#create_news_box').fadeOut();
		$('#create_promo_box').fadeIn();
	});

	$('#close_news_wrapper_button').click(function(){
		$('#create_news_wrapper').fadeOut();
	});
	</script>