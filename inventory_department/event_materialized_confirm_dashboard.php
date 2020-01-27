<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$event_id			= $_POST['id'];
	$sql				= "SELECT * FROM code_adjustment_event WHERE id = '$event_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$event_name			= $row['event_name'];
	$event_date			= $row['date'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Event</h2>
	<p style='font-family:museo'>Materialized item</p>
	<hr>
	<label>Event name</label>
	<p style='font-family:museo'><?= $event_name ?></p>
	
	<label>Event date</label>
	<p style='font-family:museo'><?= date('d M Y',strtotime($event_date)) ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Tranaction</th>
		</tr>
<?php
	$sql				= "SELECT adjustment_event.reference, adjustment_event.quantity, adjustment_event.transaction, itemlist.description
							FROM adjustment_event 
							JOIN itemlist ON adjustment_event.reference = itemlist.reference
							WHERE code_adjustment_event = '$event_id'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$transaction	= $row['transaction'];
		$description	= $row['description'];
?>
		<tr>	
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity) ?></td>
			<td><?= $transaction ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_danger_dark' id='delete_button'>Delete</button>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-exclamation'></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this event?</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id= 'confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		var window_height			= $(window).height();
		var notif_height			= $('.full_screen_notif_bar').height();
		var difference				= window_height - notif_height;
		$('.full_screen_notif_bar').css('top', 0.7 * difference / 2)
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'event_materialized_confirm.php',
			data:{
				event_id:<?= $event_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				window.location.href='/agungelektrindo/inventory_department/event_confirm_dashboard';
			}
		})
	});
	
	$('#delete_button').click(function(){
		$.ajax({
			url:'event_materialized_delete.php',
			data:{
				event_id:<?= $event_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				window.location.href='/agungelektrindo/inventory_department/event_confirm_dashboard';
			}
		})
	});
</script>