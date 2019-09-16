<?php
	//action return//
	include('salesheader.php');
	if(empty($_POST['return_id'])){
?>
	<script>
		window.history.back(1);
	</script>
<?php
	}
	$return_id 		= $_POST['return_id'];
	$status 		= $_POST['status'];
	
	$sql_initial 	= "SELECT do_id FROM code_sales_return WHERE id = '" . $return_id . "'";
	$result_initial = $conn->query($sql_initial);
	$initial 		= $result_initial->fetch_assoc();
	
	$do_id 			= $initial['do_id'];
	
	$sql_do 		= "SELECT name,customer_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_do 		= $conn->query($sql_do);
	$do 			= $result_do->fetch_assoc();
	
	$do_name		= $do['name'];
	
	$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $do['customer_id'] . "'";
	$result_customer 	= $conn->query($sql_customer);
	$customer 			= $result_customer->fetch_assoc();
	
	$customer_name		= $customer['name'];
	if($status == 1){
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
		<h2 style='font-family:bebasneue'><?= $do_name ?></h2>
		<p><?= $customer_name ?></p>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
		$sql_table = "SELECT * FROM sales_return WHERE return_code = '" . $return_id . "'";
		$result_table = $conn->query($sql_table);
		while($return = $result_table->fetch_assoc()){
			$delivery_order_id		= $return['delivery_order_id'];
			$sql_do					= "SELECT reference FROM delivery_order WHERE id = '$delivery_order_id'";
			$result_do				= $conn->query($sql_do);
			$delivery_order			= $result_do->fetch_assoc();
			
			$reference				= $delivery_order['reference'];
			$sql_item 				= 'SELECT description FROM itemlist WHERE reference = "' . mysqli_real_escape_string($conn,$reference) . '"';
			$result_item 			= $conn->query($sql_item);
			$item 					= $result_item->fetch_assoc();
			
			$description 			= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $return['quantity'] ?></td>
			</tr>
<?php
		}
?>
		</table>
		<br>
		<button type='button' class='button_default_dark' id='submit_return_button'>Submit</button>
	</div>
	<div class='notification_large' style='display:none' id='confirm_notification'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to confirm this return?</h2>
			<br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
			<form action='action_return_input' method='POST' id='return_form'>
				<input type='hidden' value='<?= $return_id ?>' name='return_id'>
			</form>
		</div>
	</div>
	<script>
		$('#submit_return_button').click(function(){
			$('#confirm_notification').fadeIn();
		});
		
		$('.btn-back').click(function(){
			$('#confirm_notification').fadeOut();
		});
		
		$('#confirm_button').click(function(){
			$('#return_form').submit();
		});
		
		
	</script>
<?php
	}
?>