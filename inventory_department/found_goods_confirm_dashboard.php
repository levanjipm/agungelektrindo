<?php
	include('inventoryheader.php');
	$id = $_POST['id'];
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
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
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Event</h2>
	<p>Confirm found item event</p>
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
	$sql = "SELECT * FROM adjustment_event WHERE code_adjustment_event = '" . $id . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= $row['reference'] ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $row['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $row['quantity'] ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='btn btn-secondary' id='submit_button'>Submit</button>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this event</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		$('#confirm_notification').fadeIn();
	});
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$.ajax({
			url:'found_goods_confirm.php',
			data:{
				id : <?= $id ?>,
			},
			type:'POST',
			success:function(response){
				if(response == 0){
					alert('Failed to confirm!');
					setTimeout(function(){
						location.reload();
					},200)
				} else {
					window.location.href='inventory.php';
				}
			},
		});
	});
</script>