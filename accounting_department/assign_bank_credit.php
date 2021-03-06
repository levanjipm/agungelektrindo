<?php
	include('../codes/connect.php');
	$sql 		= "SELECT * FROM code_bank WHERE isdone = '0' AND transaction = '2' AND isdelete = '0' AND label <> 'OTHER'";
	$result 	= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no bank data to assign</p>
<?php
	} else{
?>
<table class='table table-bordered'>
	<tr>
		<th>Date</th>
		<th>Opponent</th>
		<th>value</th>
		<th></th>
	</tr>
<?php
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
		
		if($opponent_type			!= 'OTHER'){
?>
	<tr>
		<td><?= date('d M Y',strtotime($row['date'])) ?></td>
		<td><?= $selector['name'] ?></td>
		<td>Rp. <?= number_format($row['value'],2) ?></td>
		<td>
			<button type='button' class='button_success_dark' onclick='assign_as_payment(<?= $row['id'] ?>)'><i class='fa fa-plus' aria-hidden='true'></i></button>
			<button type='button' class='button_default_dark' onclick='assign_as_other(<?= $row['id'] ?>)'><i class='fa fa-ellipsis-v' aria-hidden='true'></i></button>
		</td>
	</tr>
<?php
		} else {
?>
	<tr>
		<td><?= date('d M Y',strtotime($row['date'])) ?></td>
		<td><?= $selector['name'] ?></td>
		<td>Rp. <?= number_format($row['value'],2) ?></td>
		<td>
			<button type='button' class='button_danger_dark' disabled><i class='fa fa-plus' aria-hidden='true'></i></button>
<?php
	if($role == 'superadmin' || $role == 'admin'){
?>
			<button type='button' class='button_default_dark' onclick='assign_as_other(<?= $row['id'] ?>)'><i class='fa fa-ellipsis-v' aria-hidden='true'></i></button>
<?php
	}
?>
		</td>
	</tr>
<?php
		}
	}
?>
</table>
<form action='assign_bank_other' method='POST' id='other_form'>
	<input type='hidden' name='id' id='bank_id_other'>
</form>
<form action='assign_bank_assign' method='POST' id='assign_form'>
	<input type='hidden' name='id' id='bank_id'>
</form>
<script>
	function assign_as_payment(n){
		$('#bank_id').val(n);
		$('#assign_form').submit();
	}
	
	function assign_as_other(n){
		$('#bank_id_other').val(n);
		$('#other_form').submit();
	}
</script>
<?php
	}
?>