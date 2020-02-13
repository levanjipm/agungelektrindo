<?php
	include('../codes/connect.php');
	$id		= $_GET['id'];
	$sql	= "SELECT * FROM announcement WHERE id = '$id' AND date >= CURDATE()";
	$result	= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>We are sorry we couldn't find this announcement. It is either has been deleted or expired.</p>
<?php
	} else {
		$row			= $result->fetch_assoc();
		$date			= $row['date'];
		$name			= $row['event'];
		$description	= $row['description'];
?>
	<h2 style='font-family:bebasneue'>Edit announcement</h2>
	<hr>
	<form action='announcement_edit' method='POST'>
		<input type='hidden' value='<?= $id ?>' name='id'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' required value='<?= $date ?>'>
		
		<label>Name</label>
		<input type='text' class='form-control' name='name' required value='<?= $name ?>'>
		
		<label>Description</label>
		<textarea class='form-control' style='resize:none' name='description' required><?= $description ?></textarea>
		<br>
		<button type='submit' class='button_success_dark'>Submit</button>
	</form>
<?php
	}
?>