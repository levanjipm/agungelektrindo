<?php
	include('../codes/connect.php');
	session_start();
	$user_id = $_SESSION['user_id'];
	$id = $_POST['id'];
	$sql = "UPDATE code_sample SET issent = '1', date_sent = CURDATE(), sent_by = '" . $user_id . "' WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	if($result){
?>
	<form action='sample_print.php' method='POST' id='reg_form'>
		<input type='hidden' value='<?= $id ?>' name='id'>
	</form>
	<script>
		document.getElementById("reg_form").submit();
	</script>
<?php
	}
?>