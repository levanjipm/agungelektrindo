<?php
	include("inventoryheader.php");
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
	<p>Confirm delivery order</p>
	<hr>
	<div class="row">
		<div class='col-sm-8'>
			<div class='row'>
<?php
	$sql = "SELECT * FROM code_delivery_order WHERE isdelete = '0' AND sent = '0'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do = $results->fetch_assoc()){
			$sql_sales_order = "SELECT type FROM code_salesorder WHERE id = '" . $row_do['so_id'] . "'";
			$result_sales_order = $conn->query($sql_sales_order);
			$sales_order = $result_sales_order ->fetch_assoc();
			$type = $sales_order['type'];
			
			$project_id = $row_do['project_id'];
			$customer_id = $row_do['customer_id'];
			if($customer_id != 0){
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
				$result_customer = $conn->query($sql_customer);
				$row_customer = $result_customer->fetch_assoc();
				$customer_name = $row_customer['name'];
			} else {
				$sql = "SELECT code_salesorder.retail_address, code_salesorder.retail_name, code_salesorder.retail_phone, code_salesorder.retail_phone
				FROM code_salesorder
				JOIN code_delivery_order ON code_salesorder.id = code_delivery_order.so_id
				WHERE code_delivery_order.id = '" . $row_do['id'] . "'";
				$result = $conn->query($sql);
				$customer = $result->fetch_assoc();
				$customer_name = $customer['retail_name'];
			}
?>
				<div class="col-sm-3">
					<button type='button' class='btn btn-x' onclick='<?php if($project_id != NULL){ echo('delete_do_project'); } else if($type == 'SRVC'){ echo ('delete_do_service'); } else  { echo ('delete_do'); } ?>(<?= $row_do['id'] ?>)'>X</button>
					<button type='button' onclick='view(<?= $row_do['id'] ?>)' style='background-color:transparent;border:none'>
						<img src="../universal/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
					</button>
					<br>
					<p style="text-align:center"><?= $row_do['name'];?></p>
					<p style="text-align:center"><b><?= $customer_name?></b></p>	
					<p style="text-align:center">
						<button type="button" class="btn btn-primary" onclick='<?php if($project_id != NULL){ echo('confirm_validate_project'); } else if($type == 'SRVC'){ echo ('confirm_validate_service'); } else  { echo ('confirm_validate'); } ?>(<?= $row_do['id'] ?>)'>Confirm</button>
					</p>
				</div>
<?php
		}
?>
			</div>
		</div>
		<input type='hidden' value='' name='id'>
		<div class='col-sm-4' id='daniel'>
		</div>
	</div>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
		<input type='hidden' value='0' id='confirm_id'>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete' id='delete_button'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>

<div class='notification_large' style='display:none' id='confirm_notification_project'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this project delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button_project'>Confirm</button>
		<input type='hidden' value='0' id='confirm_id_project'>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_notification_project'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this project delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete' id='delete_button_project'>Delete</button>
		<input type='hidden' value='0' id='delete_id_project'>
	</div>
</div>

<div class='notification_large' style='display:none' id='confirm_notification_service'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this service delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button_service'>Confirm</button>
		<input type='hidden' value='0' id='confirm_id_service'>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_notification_service'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this service delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_id_service'>
	</div>
</div>

<script>
	function view(n){
		var id = n;
		$.ajax({
			url: "Ajax/view_do.php",
			data: {term: id},
			success: function(result){
				$("#daniel").html(result);
			}
		});
	}
	
	function delete_do(x){
		$('#delete_id').val(x);
		$('#delete_notification').fadeIn();
	};
	
	$('#delete_button').click(function(){
		$.ajax({
			url:"delete_delivery_order.php",
			data:{
				id:$('#delete_id').val(),
			},
			success:function(){
				location.reload();
			},
			type:"POST",
		})
	});
	
	//Confirm reguler delivery order//
	function confirm_validate(n){
		$('#confirm_id').val(n);
		$('#confirm_notification').fadeIn();
	}
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'sent_delivery_order.php',
			data:{
				id:$('#confirm_id').val()
			},
			beforeSend: function(){
				$('#confirm_button').attr('disabled',true);
			},
			success: function(){
				location.reload();
			},
			type:'GET',
		})
	});
	
	//Confirm project delivery order//
	function confirm_validate_project(n){
		$('#confirm_id_project').val(n);
		$('#confirm_notification_project').fadeIn();
	}
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	
	$('#confirm_button_project').click(function(){
		$.ajax({
			url:'sent_delivery_order_project_main.php',
			data:{
				id:$('#confirm_id_project').val()
			},
			beforeSend: function(){
				$('#confirm_button_project').attr('disabled',true);
			},
			success: function(response){
				if(response == 0){
					alert('Failed confirming delivery order');
				} else {
					location.reload();
				}
			},
			type:'GET',
		})
	});
	
	function delete_do_project(x){
		$('#delete_id_project').val(x);
		$('#delete_notification_project').fadeIn();
	};
	
	$('#delete_button_project').click(function(){
		$.ajax({
			url:"delete_delivery_order_project_main.php",
			data:{
				id:$('#delete_id_project').val(),
			},
			success:function(){
				location.reload();
			},
			type:"POST",
		})
	});
	
	//Confirm service delivery order//
	function confirm_validate_service(n){
		$('#confirm_id_service').val(n);
		$('#confirm_notification_service').fadeIn();
	}
	
	$('#confirm_button_service').click(function(){
		$.ajax({
			url:'sent_delivery_order_service.php',
			data:{
				id:$('#confirm_id_service').val()
			},
			beforeSend: function(){
				$('#confirm_button_service').attr('disabled',true);
			},
			success: function(response){
				if(response == 0){
					alert('Failed confirming delivery order');
				} else {
					location.reload();
				}
			},
			type:'GET',
		})
	});
	
	function delete_do_service(x){
		$('#delete_id_service').val(x);
		$('#delete_notification_service').fadeIn();
	};
</script>
<?php
	} else {
?>
			<div class="col-sm-6 offset-lg-3" style="text-align:center">
<?php
		echo ('There are no delivery order need to be approved');
?>
			</div>	
<?php
	}
?>
	</div>
</div>