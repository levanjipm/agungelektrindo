<?php
	include('accountingheader.php');
?>
<div class='main'>
<?php
	$sql = "SELECT * FROM code_bank WHERE id = '" . $_POST['id'] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
?>
	<h2><?= $row['name'] ?></h2>
	<p><?= date('d M Y',strtotime($row['date'])) ?></p>
	<hr>
	<h4>Rp. <?= number_format($row['value']) ?></h4>
	<hr>
	Assign this transaction as:
	<form action='assign_bank_other_assign.php' method='POST' id='assign_form'>
		<select class='form-control' name='type' id='type'>
			<option value='0'>Please select a classification</option>
<?php
	$sql = "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>	
			<option value='<?= $row['id'] ?>' style='font-weight:bold' disabled><?= $row['name'] ?></option>				
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
		<br>
		<label>Information</label>
		<input type='text' class='form-control' name='keterangan' id='keterangan'>
		<input type='hidden' value='<?= $_POST['id'] ?>' name='id' readonly>
	</form>
	<br><br>
	<button type='button' class='btn btn-default' id='other_assign_button'>Assign this transaction</button>
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