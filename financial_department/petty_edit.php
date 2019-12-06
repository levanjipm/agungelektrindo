<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
	$sql_petty_cash			= "SELECT * FROM petty_cash WHERE class <> '25' ORDER BY id DESC LIMIT 30";
	$result_petty_cash		= $conn->query($sql_petty_cash);
?>
<head>
	<title>Edit petty cash data</title>
</head>
<style>
	.btn-badge{
		border:none;
		outline:none!important;
		background-color:transparent;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Petty Cash</h2>
	<p>Edit transaction</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th style='text-align:center; width:15%'>Date</th>
			<th style='text-align:center; width:30%'>Transaction name</th>
			<th style='text-align:center; width:25%'>Value</th>
			<th style='text-align:center; width:30%'>Class</th>
		</tr>
<?php
	while($petty_cash		= $result_petty_cash->fetch_assoc()){
		$date				= $petty_cash['date'];
		$info				= $petty_cash['info'];
		$value				= $petty_cash['value'];
		$class				= $petty_cash['class'];
		$id					= $petty_cash['id'];
		
		$sql_class			= "SELECT name FROM petty_cash_classification WHERE id = '$class'";
		$result_class		= $conn->query($sql_class);
		$class				= $result_class->fetch_assoc();
		
		$class_name			= $class['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $info ?></td>
			<td>
				<button type='button' class='btn-badge' style='color:black' onclick='edit_transaction(<?= $id ?>)' id='petty_cash_button-<?= $id ?>'>
					Rp. <?= number_format($value,2) ?>
				</button>
				<input type='text' class='form-control' id='petty_cash_value-<?= $id ?>' value='<?= $value ?>' style='display:none' onfocusout='hide_transaction(<?= $id ?>)'>
			</td>
			<td><?= $class_name ?></td>
		</tr>
<?php
	}
?>
	</table>
</div>
<script>
	function edit_transaction(n){
		$('#petty_cash_button-' + n).hide();
		$('#petty_cash_value-' + n).show();
		$('#petty_cash_value-' + n).focus();
	}
	
	function hide_transaction(n){
		$('#petty_cash_button-' + n).show();
		$('#petty_cash_value-' + n).hide();
		
		var value		= $('#petty_cash_value-' + n).val();
		$.ajax({
			url:'petty_edit_input.php',
			data:{
				id		: n,
				value	: value
			},
			type:'POST',
			success:function(){
				$('#petty_cash_button-' + n).text('Rp. ' + numeral($('#petty_cash_value-' + n).val()).format('0,0.00'));
			},
		});
	}
</script>