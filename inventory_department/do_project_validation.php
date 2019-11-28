<?php
	include('inventoryheader.php');
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
<div class="main">
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p>Create new delivery order</p>
	<hr>
	<form id='send_project_form' method='POST' action='do_project_input.php'>
	<label>Date</label>
	<input type='date' class='form-control' name='project_send_date' id='project_send_date'>
<?php
	$project_id = $_POST['project_id'];
	$sql = "SELECT * FROM code_project WHERE id = '" . $project_id . "'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
		<script>
			window.history.back();
		</script>
<?php
	} else {
		$row = $result->fetch_assoc();
		$so_id = $row['id'];
		$taxing = $row['taxing'];
		$customer_id = $row['customer_id'];
		
		$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
	}
?>
	<h4 style='font-family:bebasneue'><?= $customer['name'] ?></h4>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $row['project_name'] ?></h3>
	<p><?= $row['description'] ?></p>
	<hr>
	<button type='button' class='btn btn-secondary' id='send_project_button'>Send</button>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
	<input type='hidden' value='<?= $project_id ?>' name='project_id'>
</form>
<script>
	$('#send_project_button').click(function(){
		if($('#project_send_date').val() == ''){
			alert('Please insert valid date');
			$('#project_send_date').focus();
			return false;
		} else {
			$('#confirm_notification').fadeIn();
		}
	});
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('.btn-confirm').click(function(){
		$('#send_project_form').submit();
	});
</script>