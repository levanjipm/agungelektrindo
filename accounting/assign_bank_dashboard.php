<?php
	//Assign bank transaction//
	include('accountingheader.php');
?>
<div class='main'>
	<div class='container'>
		<h2>Bank</h2>
		<p>Assign transaction to journal</p>
		<hr>
	</div>
	<div class='container'>
		<h3>Debit</h3>
		<hr>
	</div>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Opponent</th>
			<th>value</th>
			<th colspan='2'></th>
		</tr>
<?php
	$sql = "SELECT * FROM code_bank WHERE isdone = '0' AND transaction = '1' AND isdelete = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td><button type='button' class='btn btn-default' onclick='pass(<?= $row['id'] ?>)'>Assign as payment</button></td>
			<td><button type='button' class='btn btn-primary'>Assign as other</button></td>
			<form action='assign_bank_assign.php' method='POST' id='form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
	</table>
	<div class='container'>
		<h3>Credit</h3>
		<hr>
	</div>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Opponent</th>
			<th>value</th>
			<th colspan='2'></th>
		</tr>
<?php
	$sql = "SELECT * FROM code_bank WHERE isdone = '0' AND transaction = '2' AND isdelete = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td><button type='button' class='btn btn-default' onclick='pass(<?= $row['id'] ?>)'>Assign as payment</button></td>
			<td><button type='button' class='btn btn-primary' onclick='other(<?= $row['id'] ?>)'>Assign as other income</button></td>
			<form action='assign_bank_assign.php' method='POST' id='form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
			<form action='assign_bank_other.php' method='POST' id='other_form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
	</table>
</div>
<script>
	function other(n){
		$('#other_form' + n).submit();
	}
	function pass(n){
		var id = n;
		$('#form' + id).submit();
	}
</script>