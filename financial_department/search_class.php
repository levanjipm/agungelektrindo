<?php
	include('../codes/connect.php');
	$term = $_POST['term'];
	$sql_detail = "SELECT * FROM petty_cash_classification WHERE major_id = '" . $term . "'";
	$result_detail = $conn->query($sql_detail);
	if(mysqli_num_rows($result_detail)){
?>
		<label>Sub Classification</label>
		<select class='form-control' name='sub' id='sub'>
			<option value='0'>Please select a sub class</option>
<?php
	while($detail = $result_detail->fetch_assoc()){
?>
			<option value='<?= $detail['id'] ?>'><?= $detail['name'] ?></option>
<?php
	}
?>
		</select>
<?php
	} else {
	}	
?>	