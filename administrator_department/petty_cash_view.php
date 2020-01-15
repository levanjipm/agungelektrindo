<?php
	include('../codes/connect.php');
	$start_date			= $_POST['start_date'];
	$end_date			= $_POST['end_date'];
?>
<table class='table table-bordered'>
	<tr>
		<th>Date</th>
		<th>Descrption</th>
		<th>Class</th>
		<th>Value</th>
	</tr>
<?php
	$sql			= "SELECT petty_cash.id, petty_cash.value, petty_cash.info, petty_cash_classification.name, petty_cash.date
						FROM petty_cash 
						JOIN petty_cash_classification ON petty_cash.class = petty_cash_classification.id
						WHERE petty_cash.date <= '$end_date' AND petty_cash.date >= '$start_date' ORDER BY petty_cash.date ASC";
	$result			= $conn->query($sql);
	while($row		= $result->fetch_assoc()){
		$date		= $row['date'];
		$id			= $row['id'];
		$value		= $row['value'];
		$info		= $row['info'];
		$class_name	= $row['name'];
?>
	<tr>
		<td><?= date('d M Y',strtotime($date)) ?></td>
		<td><?= $info ?></td>
		<td><?= $class_name ?></td>
		<td>Rp. <?= number_format($value,2) ?></td>
		<td>
			<button type='button' class='button_success_dark' onclick='view_edit_form(<?= $id ?>)'><i class='fa fa-pencil'></i></button>
			<button type='button' class='button_danger_dark' onclick='view_delete_confirmation(<?= $id ?>)'><i class='fa fa-trash'></i></button>
		</td>
	</tr>
<?php
	}
?>
</table>
<div class='full_screen_wrapper' id='delete_notif'>
	<div class='full_screen_notif_bar'>
		<h2 style='color:red;font-size:2em'><i class='fa fa-exclamation'></i></h2>
		<p style='font-family:museo'>Are you sure to delete this transaction</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
		<input type='hidden' id='transaction_id'>
	</div>
</div>
<script>
	function view_delete_confirmation(n){
		$('#transaction_id').val(n);
		var window_height			= $(window).height();
		var notif_height			= $('#delete_notif .full_screen_notif_bar').height();
		var difference				= window_height - notif_height;
		
		$('#delete_notif .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#delete_notif').fadeIn();
	}
	
	$('#close_notif_button').click(function(){
		$('#delete_notif').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'petty_cash_delete.php',
			data:{
				transaction_id:$('#transaction_id').val(),
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				$('button').attr('disabled',false);
				$('#search_button').click();
			}
		});
	});
</script>
<div class='full_screen_wrapper' id='edit_petty_cash'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'></div>
</div>
<script>
	function view_edit_form(n){
		$.ajax({
			url:'reset_petty_view.php',
			data:{
				transaction_id: n
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(response){
				$('button').attr('disabled',false);
				$('#edit_petty_cash .full_screen_box').html(response);
				$('#edit_petty_cash').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('#edit_petty_cash').fadeOut();
	});
</script>