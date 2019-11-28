<?php
	include('inventoryheader.php');
	$event_id			= $_POST['id'];
	$sql_event			= "SELECT * FROM code_adjustment_event WHERE id = '$event_id' AND isconfirm = '0'";
	$result_event		= $conn->query($sql_event);
	$event				= $result_event->fetch_assoc();
	
	$event_name			= $event['event_name'];
	
	
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Confirm event</h2>
	<p>Swap</p>
	<hr>
	<h2 style='font-family:bebasneue'><?= $event_name ?></h2>
	<h3 style='font-family:bebasneue'>Initial items</h3>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql_in				= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'OUT'";
	$result_in			= $conn->query($sql_in);
	while($row_in		= $result_in->fetch_assoc()){
		$quantity		= $row_in['quantity'];
		$reference		= $row_in['reference'];
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<h3 style='font-family:bebasneue'>Product items</h3>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql_in				= "SELECT * FROM adjustment_event WHERE code_adjustment_event = '$event_id' AND transaction = 'IN'";
	$result_in			= $conn->query($sql_in);
	while($row_in		= $result_in->fetch_assoc()){
		$quantity		= $row_in['quantity'];
		$reference		= $row_in['reference'];
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= number_format($quantity,0) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_warning_dark' id='delete_button_event'>Delete</button>
	<button type='button' class='button_success_dark' id='confirm_button_event'>Submit</button>
</div>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
		z-index:50;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		outline:none;
		border:none;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		outline:none;
		border:none;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		outline:none;
		border:none;
	}
</style>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this event?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-delete' id='delete_button'>Delete</button>
	</div>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this event?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#delete_button_event').click(function(){
		$('#delete_notification').fadeIn();
	});
	
	$('#confirm_button_event').click(function(){
		$('#confirm_notification').fadeIn();
	});
	
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'event_swap_confirm.php',
			data:{
				event_id: <?= $event_id ?>
			},
			type:'POST',
			beforeSend:function(){
				$('#confirm_button').attr('disabled',true);
			},
			success:function(){
				location.href='inventory';
			}
		});
	});
	
	$('#delete_button').click(function(){
		$.ajax({
			url:'event_swap_delete.php',
			data:{
				event_id: <?= $event_id ?>
			},
			type:'POST',
			beforeSend:function(){
				$('#delete_button').attr('disabled',true);
			},
			success:function(){
				location.href='inventory';
			}
		});
	});
</script>		