<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confirm event</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Event</h2>
	<p style='font-family:museo'>Confirm event</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Event name</th>
			<th>Created by</th>
			<th></th>
		</tr>
<?php
	$sql_event 		= "SELECT code_adjustment_event.id, code_adjustment_event.date, code_adjustment_event.event_name, users.name, event.confirmation_url
						FROM code_adjustment_event 
						JOIN users ON users.id = code_adjustment_event.created_by
						JOIN event ON event.id = code_adjustment_event.event_id
						WHERE isconfirm = '0'";
	$result_event 	= $conn->query($sql_event);
	while($event 	= $result_event->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($event['date'])) ?></td>
			<td><?= $event['event_name'] ?></td>
			<td><?= $event['name'] ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='submit(<?= $event['id'] ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
			</td>
			
			<form id='confirm_event-<?= $event['id'] ?>' action='<?= $event['confirmation_url'] ?>' method='POST'>
				<input type='hidden' value='<?= $event['id'] ?>' name='id'>
			</form>
		</tr>
<?php
	}
?>
</div>
<script>
	function submit(n){
		$('#confirm_event-' + n).submit();
	}
</script>