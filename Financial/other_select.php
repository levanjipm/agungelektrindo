<?php
	include('../codes/connect.php');
?>
	<select class='form-control'  id='transaction_select_to'  name='transaction_select_to'>
		<option value='0'>Please select an account</option>
<?php
	$sql_other				= "SELECT id,name FROM bank_account_other";
	$result_other			= $conn->query($sql_other);
	while($other			= $result_other->fetch_assoc()){
		$other_id			= $other['id'];
		$other_name			= $other['name'];
?>
		<option value='<?= $other_id ?>'><?= $other_name ?></option>
<?php
	}
?>
	</select>