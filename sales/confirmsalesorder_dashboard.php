<?php
	include('salesheader.php');
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
		outline:none;
		border:none;
		padding:5px 10px;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		border:none;
		padding:5px 10px;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		border:none;
		padding:5px 10px;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
	
	.alert_wrapper{
		position:fixed;
		top:80px;
		width:300px;
		margin:auto;
		text-align:center;
	}
</style>
<div class='main'>
	<div class='alert_wrapper'>
<?php
	if(empty($_GET['alert'])){
	} else if($_GET['alert'] == 'true'){
?>
	<div class="alert alert-success" id='alert'>
		<strong>Success!</strong> Input data success.
	</div>
<?php
	} else if($_GET['alert'] == 'warning'){	
?>
	<div class="alert alert-warning" id='alert'>
		<strong>Warning</strong> Input data unsuccess.
	</div>
<?php
	}
?>
	</div>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('#alert').fadeOut();
			},1000);
		});
	</script>
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p>Confirm sales order</p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th>Name</th>
			<th></th>
		</tr>
<?php
	$sql_so = "SELECT * FROM code_salesorder WHERE isconfirm = '0'";
	$result_so = $conn->query($sql_so);
	while($so = $result_so->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($so['date'])) ?></td>
			<td style='text-align:left'><?php
				if($so['customer_id'] > 0){
					$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $so['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo '<p><strong>' . $customer['name'] . '</strong></p>';
					echo '<p>' . $customer['address'] . '</p>';
					echo $customer['city'];
				}
			?></td>
			<td><?= $so['name'] ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='submit(<?= $so['id'] ?>)'>Confirm SO</button>
				<button type='button' class='button_danger_dark' onclick='delete_sales_order(<?= $so['id'] ?>)'>Delete SO</button>
				<form action='confirmsalesorder_validation' method='POST' id='form<?= $so['id'] ?>'>
					<input type='hidden' value='<?= $so['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this sales order</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-delete' id='delete_sales_order_button'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>
<script>
	function delete_sales_order(n){
		$('#delete_notification').fadeIn();
		$('#delete_id').val(n);
	};
	
	$('.btn-back').click(function(){
		$('#delete_notification').fadeOut();
	});
	
	$('#delete_sales_order_button').click(function(){
		$.ajax({
			url		:"delete_salesorder.php",
			data	:{
				id 	: $('#delete_id').val(),
			},
			type	:"POST",
			success:function(){
				location.reload();
			},
		});
	});
	
	function submit(n){
		$('#form' + n).submit();
	}
</script>