<?php
	include('accountingheader.php');
?>
<div class='main'>
<?php
	$sql = "SELECT * FROM code_bank WHERE id = '" . $_POST['id'] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$description		= $row['description'];
	
	$opponent_id = $row['bank_opponent_id'];
	$opponent_type = $row['label'];
	
	if($opponent_type == 'CUSTOMER'){
		$database = 'customer';
	} else if($opponent_type == 'SUPPLIER'){
		$database = 'supplier';
	} else if($opponent_type == 'OTHER'){
		$database = 'bank_account_other';
	};
	
	$sql_selector = "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
	$result_selector = $conn->query($sql_selector);
	$selector = $result_selector->fetch_assoc();
?>
	<h2><?= $selector['name'] ?></h2>
	<p><?= date('d M Y',strtotime($row['date'])) ?></p>
	<hr>
	<h4>Rp. <?= number_format($row['value']) ?></h4>
	<hr>
	<label>Assign this transaction as</label>
	<form action='assign_bank_other_assign.php' method='POST' id='assign_form'>
		<select class='form-control' name='type' id='type'>
			<option value='0'>Please select a classification</option>
<?php
	$sql 		= "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
?>	
			<option value='<?= $row['id'] ?>' style='font-weight:bold'><?= $row['name'] ?></option>				
<?php
		$sql_detail = "SELECT * FROM petty_cash_classification WHERE major_id = '" . $row['id'] . "'";
		$result_detail = $conn->query($sql_detail);
		if($result_detail){
			while($detail = $result_detail->fetch_assoc()){
?>
			<option value='<?= $detail['id'] ?>'><?= $detail['name'] ?></option>	
<?php
			}
		}
	}
?>
		</select>
		<label>Information</label>
		<input type='text' class='form-control' name='keterangan' id='keterangan' value='<?= $description  ?>'>
		<input type='hidden' value='<?= $_POST['id'] ?>' name='id' readonly>
	</form>
	<br><br>
	<button type='button' class='button_default_dark' id='other_assign_button'>Assign this transaction</button>
</div>
<script>
	$('#other_assign_button').click(function(){
		if($('#type').val() == 0){
			alert('Please insert a correct classification!');
			return false;
		} else if($('#keterangan').val() == ''){
			alert('Please insert information!');
			return false;
		} else {
			$('#assign_form').submit();
		}
	})
</script>