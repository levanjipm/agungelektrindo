<?php
	include('inventoryheader.php');
	$id = $_POST['id'];
	$sql_code = "SELECT * FROM code_sample WHERE id = '" . $id . "'";
	$result_code = $conn->query($sql_code);
	$code = $result_code->fetch_assoc();
	
	$customer_id = $code['customer_id'];
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
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
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p>Receive sample</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer['name'] ?></h3>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<table class='table table-hover'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
		</tr>
<?php
	$sql_sample = "SELECT * FROM sample WHERE code_id = '" . $id . "'";
	$result_sample = $conn->query($sql_sample);
	while($sample = $result_sample->fetch_assoc()){
?>
		<tr>
			<td><?= $sample['reference'] ?></td>
			<td><?php
				$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $sample['reference'] . "'";
				$result_item = $conn->query($sql_item);
				$item = $result_item->fetch_assoc();
				echo $item['description'];
			?></td>
			<td><?= $sample['quantity']; ?>
		</tr>
<?php
	}
?>
	</table>
	Sent date : <?= date('d M Y',strtotime($code['date_sent'])) ?>
	<br>
	<button type='button' class='btn btn-default' id='receive_button'>Receive</button>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to receive back this sample?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#receive_button').click(function(){
		$('#confirm_notification').fadeIn();
	});
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$.ajax({
			url:'receive_sample.php',
			data:{
				id:<?= $id ?>,
			},
			type:'POST',
			success:function(){
				window.location.href = 'sample_dashboard.php';
			}
		})
	})
</script>