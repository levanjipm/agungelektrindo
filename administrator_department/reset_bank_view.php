<?php
	include('../codes/connect.php');
	$start_date		= $_POST['start_date'];
	$end_date		= $_POST['end_date'];
	$type			= $_POST['type'];
?>
	<table class='table table-bordered'>
<?php	
	$sql						= "SELECT * FROM code_bank WHERE major_id = '0' AND transaction = '$type' AND date >= '$start_date' AND date <= '$end_date'";
	$result						= $conn->query($sql);
	while($row					= $result->fetch_assoc()){
		$id						= $row['id'];
		$date					= $row['date'];
		$value					= $row['value'];
		$opponent				= $row['bank_opponent_id'];
		$label					= $row['label'];
		
		$isdone					= $row['isdone'];
		$isdelete				= $row['isdelete'];
		
		if($label 				== 'CUSTOMER'){
			$table_from_label 	= 'customer';
		} else if($label 		== 'SUPPLIER'){
			$table_from_label 	= 'supplier';
		} else {
			$table_from_label 	= 'bank_account_other';
		}
		
		$sql_opponent 			= "SELECT name FROM " . $table_from_label . " WHERE id = '$opponent'";
		$result_opponent 		= $conn->query($sql_opponent);
		$opponent 				= $result_opponent->fetch_assoc();
			
		$opponent_name			= $opponent['name'];
?>
	<tr>
		<td><?= date('d M Y',strtotime($date)) ?></td>
		<td><?= $opponent_name ?></td>
		<td>Rp. <?= number_format($value,2) ?></td>
		<td>
		<?php	if($isdelete == 1 && $isdone == 0){ ?>
			<button type='button' class='button_success_dark' onclick='open_reset_view(<?= $id ?>)'><i class='fa fa-undo'></i></button>
		<?php } else { ?>
			<button type='button' class='button_danger_dark' onclick='confirm_delete(<?= $id ?>)'><i class='fa fa-trash'></i></button>
			<button type='button' class='button_default_dark' onclick='confirm_edit(<?= $id ?>)'><i class='fa fa-pencil'></i></button>
		<?php } ?>
		</td>
	</tr>
<?php
	}
?>
</table>

<form action='edit_bank_dashboard' method='POST' id='transaction_edit_form'>
	<input type='hidden' id='bank_id' name='id'>
</form>

<script>
	function open_reset_view(n){
		$.ajax({
			url:'reset_bank_validation.php',
			data:{
				bank_id: n
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(response){
				$('button').attr('disabled',false);
				$('#reset .full_screen_box').html(response);
				$('#reset').fadeIn(300);
			}
		});
	};
	
	function confirm_delete(n){
		$('#bank_delete_id').val(n);
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#delete').fadeIn();
	};
	
	function confirm_edit(n){
		$('#bank_id').val(n);
		$('#transaction_edit_form').submit();
	};
</script>