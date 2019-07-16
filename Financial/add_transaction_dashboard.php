<?php
	include('financialheader.php');
?>
<div class='main'>
	<div class='row'>
		<div class='col-sm-10 col-sm-offset-1'>
			<h2 style='font-family:bebasneue'>Bank Account</h2>
			<p>Add transaction</p>
			<hr>
			<form action='add_transaction_validation.php' method='POST' id='add_transaction_form'>
				<label>Date</label>
				<input type='date' class='form-control' id='date' name='date'>
				<label>Transaction type</label>
				<select class='form-control' name='transaction' id='transaction'>
					<option value='0'>Insert transaction type</option>
					<option value='1'>Debit</option>
					<option value='2'>Credit</option>
				</select>
				<label>Value</label>
				<div class="input-group">
					<span class="input-group-addon">Rp.</span>
					<input type="number" class="form-control" placeholder="Insert value" id='value' name='value'>
				</div>
				<label>Transaction to/from</label>
				<div class="input-group mb-3">
					<select class='form-control' id='lawan' name='lawan' style='width:80%'>
						<option value='0'>Please pick a client</option>
						<option value='0' style='font-weight:bold' disabled>Customer</option>
<?php
	$sql = "SELECT id,name FROM customer ORDER BY name ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
						<option value='<?= $row['id'] . "-" . "CUSTOMER" ?>'><?= $row['name']; ?></option>
<?php
	}
?>
						<option value='0' style='font-weight:bold' disabled>Supplier</option>
<?php
	$sql = "SELECT id,name FROM supplier ORDER BY name ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
						<option value='<?= $row['id'] . "-" . "SUPPLIER" ?>'><?= $row['name']; ?></option>
<?php
	}
?>
						<option value='0' style='font-weight:bold' disabled>Other</option>
<?php
	$sql = "SELECT id,name FROM bank_account_other ORDER BY name ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
						<option value='<?= $row['id'] . "-" . "OTHER" ?>'><?= $row['name']; ?></option>
<?php
	}
?>
					</select>
					<div class="input-group-append">
						<button class="btn btn-success" type="submit">Go</button> 
					</div>
				</div>
				<label>Description</label>
				<textarea class='form-control' form='add_transaction_form' name='description'></textarea>
				<hr>
				<button type='button' class='btn btn-secondary' onclick='check_all()'>
					Submit
				</button>
			</div>
		</div>
	</form>
</div>
<script>
	function check_all(){
		if($('#date').val() == ''){
			alert('Insert valid date!');
		} else if($('#transaction').val() == 0){
			alert('Please pick transaction type!');
		} else if($('#value').val() == '' || $('#value').val() == 0){
			alert('Please insert value number!');
		} else if($('#lawan').val() == 0){
			alert('Please pick a client!');
		} else {
			$('#add_transaction_form').submit();
		}
	}
</script>