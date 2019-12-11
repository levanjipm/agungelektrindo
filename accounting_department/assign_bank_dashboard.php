<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p>Assign transaction to journal</p>
	<hr>
	<h3 style='font-family:bebasneue'>Debit</h3>
	<hr>
	<table class='table'>
		<tr>
			<th style='width:10%'>Date</th>
			<th style='width:30%'>Opponent</th>
			<th style='width:20%'>value</th>
			<th colspan='2'></th>
		</tr>
<?php
	$sql 		= "SELECT * FROM code_bank WHERE isdone = '0' AND transaction = '1' AND isdelete = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		$id				= $row['id'];
		$transaction 	= $row['transaction'];
		$date 			= $row['date'];
		$value 			= $row['value'];
		
		$opponent_id 	= $row['bank_opponent_id'];
		$opponent_type 	= $row['label'];
		
		if($opponent_type == 'CUSTOMER'){
			$database = 'customer';
		} else if($opponent_type == 'SUPPLIER'){
			$database = 'supplier';
		} else if($opponent_type == 'OTHER'){
			$database = 'bank_account_other';
		};
		
		$sql_selector 		= "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
		$result_selector 	= $conn->query($sql_selector);
		$selector 			= $result_selector->fetch_assoc();
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $selector['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td><button type='button' class='button_success_dark' onclick='assign_debit(<?= $row['id'] ?>)'>Assign as payment</button></td>
			
			<form action='assign_bank_assign' method='POST' id='form_assign_debit<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
			
			<td><button type='button' class='button_default_dark' onclick='other(<?= $row['id'] ?>)'>Assign as other</button></td>
			
			<form action='assign_bank_other' method='POST' id='other_form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
	</table>
	<h3 style='font-family:bebasneue'>Credit</h3>
	<hr>
	<table class='table'>
		<tr>
			<th style='width:10%'>Date</th>
			<th style='width:30%'>Opponent</th>
			<th style='width:20%'>value</th>
			<th colspan='2'></th>
		</tr>
<?php
	$sql 		= "SELECT * FROM code_bank WHERE isdone = '0' AND transaction = '2' AND isdelete = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		$transaction 	= $row['transaction'];
		$date 			= $row['date'];
		$value 			= $row['value'];
		
		$opponent_id 	= $row['bank_opponent_id'];
		$opponent_type 	= $row['label'];
		
		if($opponent_type == 'CUSTOMER'){
			$database = 'customer';
		} else if($opponent_type == 'SUPPLIER'){
			$database = 'supplier';
		} else if($opponent_type == 'OTHER'){
			$database = 'bank_account_other';
		};
		
		$sql_selector 		= "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
		$result_selector 	= $conn->query($sql_selector);
		$selector 			= $result_selector->fetch_assoc();
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $selector['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td><button type='button' class='button_success_dark' onclick='pass(<?= $row['id'] ?>)'>Assign as payment</button></td>
			
			<form action='assign_bank_assign' method='POST' id='form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='id'>
			</form>
			
			<td><button type='button' class='button_default_dark' onclick='other(<?= $row['id'] ?>)'>Assign as income</button></td>
			
			<form action='assign_bank_other' method='POST' id='other_form<?= $row['id'] ?>'>
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
	function assign_debit(n){
		var id = n;
		$('#form_assign_debit' + id).submit();
	}
</script>