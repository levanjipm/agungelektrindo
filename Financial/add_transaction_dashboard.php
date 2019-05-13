<?php
	include('financialheader.php');
?>
<div class='main'>
	<form action='add_transaction_validation.php' method='POST' id='formasi'>
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
		<div class="input-group">
		<select class='form-control' id='lawan' name='lawan'>
			<option value='0'>Please pick a client</option>
<?php
	$sql = "SELECT name FROM bank_accounts";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
				<option value='<?= $row['name'] ?>'><?= $row['name']; ?></option>
<?php
}
?>
		</select>
		<br><br>
		<a href='add_client.php'>
			<button type='button' class='btn btn-default'>
				Add
			</button>
		</a>
		<hr>
		<button type='button' class='btn btn-primary' onclick='check_all()'>
			Submit
		</button>
	</form>
</div>
<script>
	$('#formasi').on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 13) { 
			e.preventDefault();
			return false;
		}
	});
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
			$('#formasi').submit();
		}
	}
</script>