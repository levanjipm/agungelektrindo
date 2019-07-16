<?php
	include('inventoryheader.php');
	if($role == 'superadmin'){
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<style>
	.options{
		background-color:#333;
		display:none;
		color:white;
		width:80%;
		margin-left:10%;
		box-shadow: 4px 4px 4px 4px #888888;
	}
	.box{
		padding:5px;
		background-color:#333;
		color:white;
		text-align:center;
		cursor:pointer;
		display:none;
	}
	.box:hover{
		background-color:#777;
		transition:0.3s all ease;
	}
</style>
<div class="main">
	<h2 style='font-family:bebasneue'>Event</h2>
	<p>Add event</p>
	<hr>
	<div class='row'>
<?php
	$sql_event = "SELECT * FROM event";
	$result_event = $conn->query($sql_event);
	while($event = $result_event->fetch_assoc()){
?>
		<div class='col-sm-3' style='padding:20px'>
			<a  href='<?= $event['url'] ?>' style='text-decoration:none'>
				<div class='box' id='event_box-<?= $event['id'] ?>'>
					<h1 style='font-size:6em'><?= $event['icon'] ?></h1>
					<h3 style='font-family:bebasneue'><?= $event['name'] ?></h3>
				</div>
			</a>
		</div>
<?php
	}
?>
	<script>
		$(document).ready(function(){
			var timeout = 150;
			$('div[id^="event_box-"]').each(function(){
				var selected_box = $(this);
				setTimeout(function(){
					selected_box.fadeIn();
				},timeout);
				timeout = timeout + 100;
			});
		});
	</script>
	</div>
<?php
	} else {
?>
	<script>
		window.location.href = 'inventory.php';
	</script>
<?php
	}
?>