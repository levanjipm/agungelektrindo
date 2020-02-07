<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Assign bank as other</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Bank</h2>
	<p style='font-family:museo'>Assign bank as other</p>
	<hr>
<?php
	$transaction_id		= $_POST['id'];
	$sql 				= "SELECT * FROM code_bank WHERE id = '$transaction_id'";
	$result 			= $conn->query($sql);
	$row 				= $result->fetch_assoc();
	
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
	
	$sql_selector 		= "SELECT name FROM " . $database . " WHERE id = '" . $opponent_id . "'";
	$result_selector 	= $conn->query($sql_selector);
	$selector 			= $result_selector->fetch_assoc();
?>
	<label>Transaction data</label>
	<p style='font-family:museo'><?= $selector['name'] ?></p>
	<p style='font-family:museo'><?= date('d M Y',strtotime($row['date'])) ?></p>
	<p style='font-family:museo'>Rp. <?= number_format($row['value'],2) ?></p>
	<hr>
	<label>Assign this transaction as</label>
	<form action='assign_bank_other_assign' method='POST' id='assign_form'>
		<select class='form-control' name='type' id='type'>
			<option value='0'>Please select a classification</option>
<?php
	$sql 		= "SELECT * FROM petty_cash_classification WHERE major_id = '0'";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
?>	
			<option value='<?= $row['id'] ?>' style='font-weight:bold'><?= $row['name'] ?></option>				
<?php
		$sql_detail 		= "SELECT * FROM petty_cash_classification WHERE major_id = '" . $row['id'] . "'";
		$result_detail 		= $conn->query($sql_detail);
		if($result_detail){
			while($detail 	= $result_detail->fetch_assoc()){
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
		<input type='hidden' value='<?= $transaction_id ?>' name='id' readonly>
	</form>
	<br><br>
	<button type='button' class='button_success_dark' id='other_assign_button'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
	<button type='button' class='button_default_dark' id='internal_assign_button'><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to assign this transaction as internal transaction?</p>
		<button class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button class='button_success_dark' id='submit_button'>Confirm</button>
	</div>
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
	
	$('#internal_assign_button').click(function(){
		var window_height			= $(window).height();
		var notif_height			= $('.full_screen_notif_bar').height();
		var difference				= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn(300);
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#submit_button').click(function(){
		$.ajax({
			url:'assign_bank_null.php',
			data:{
				bank_id:<?= $transaction_id ?>,
			},
			type:'POST',
			success:function(){
				window.location.href='/agungelektrindo/financial_department/assign_bank_dashboard';
			}
		})
	});
</script>