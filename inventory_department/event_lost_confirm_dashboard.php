<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	$id = $_POST['id'];
?>
<head>
	<title>Confirm lost goods</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Event</h2>
	<p>Confirm lost item event</p>
	<hr>
<?php
	$sql = "SELECT * FROM code_adjustment_event WHERE id = '" . $id . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
?>
	<h3 style='font-family:bebasneue'><?= $row['event_name'] ?></h3>
	<p><?= date('d M Y',strtotime($row['date'])) ?></p>
	<table class='table'>
		<tr>
			<td>Reference</td>
			<td>Description</td>
			<td>Quantity</td>
		</tr>
<?php
	$sql 				= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '" . $id . "'";
	$result 			= $conn->query($sql);
	while($row 			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$quantity		= $row['quantity'];
		$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
		$result_item 	= $conn->query($sql_item);
		$item 			= $result_item->fetch_assoc();
		$description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $quantity ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
</div>
<div class='full_screen_wrapper' id='confirm_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this event</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
</div>
<script>
	$('#submit_button').click(function(){
		var window_height			= $(window).height();
		var notif_height			= $('#confirm_notification .full_screen_notif_bar').height();
		var difference				= window_height - notif_height;
		$('#confirm_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#confirm_notification').fadeIn();
	});

	$('#close_notif_button').click(function(){
		$('#confirm_notification').fadeOut(300);
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'event_lost_confirm.php',
			data:{
				id : <?= $id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('#confirm_button').attr('disabled',true);
			},
			success:function(response){
				if(response == 0){
					alert('Failed to confirm!');
					setTimeout(function(){
						location.reload();
					},200)
				} else {
					window.location.href='../inventory';
				}
			},
		});
	});
</script>