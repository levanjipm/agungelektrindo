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
	
	.view_delivery_order_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_delivery_order_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_delivery_order{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
<div class='view_delivery_order_wrapper'>
	<button id='button_close_delivery_order'>X</button>
	<div id='view_delivery_order_box'>
	</div>
</div>
<div class="main">
	<h2 style='font-family:bebasneue'>Project Delivery Order</h2>
	<p>Confirm project delivery order</p>
	<hr>
	<div class="row">
		<div class='col-sm-8'>
			<div class='row'>
<?php
	$sql = "SELECT * FROM project_delivery_order WHERE isconfirm = '0'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do 				= $results->fetch_assoc()){
			$project_id 			= $row_do['project_id'];
			$sql_code_project 		= "SELECT customer_id,project_name FROM code_project WHERE id = '" . $project_id . "'";
			$result_code_project 	= $conn->query($sql_code_project);
			$code_project 			= $result_code_project->fetch_assoc();
			
			$customer_id 			= $code_project['customer_id'];
			$sql_customer 			= "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer 		= $conn->query($sql_customer);
			$row_customer 			= $result_customer->fetch_assoc();
			$customer_name 			= $row_customer['name'];
?>
				<div class="col-sm-3">
					<button type='button' class='btn btn-x' onclick='tutup(<?= $row_do['id'] ?>)'>X</button>
					<img src="../universal/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
					<br>
					<p style="text-align:center"><?= $code_project['project_name'];?></p>
					<p style="text-align:center"><b><?= $customer_name?></b></p>	
					<p style="text-align:center">
						<button type="button" class="button_default_dark" onclick='confirm_validate(<?= $row_do['id'] ?>)'>Confirm</button>
					</p>
				</div>
<?php
		}
?>
			</div>
		</div>
		<input type='hidden' value='' name='id'>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this delivery order</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>
<script>
	function tutup(x){
		$('#delete_id').val(x);
		$('#delete_notification').fadeIn();
	};
	
	$('#button_close_delivery_order').click(function(){
		$('.view_delivery_order_wrapper').fadeOut();
		$('#view_delivery_order_box').html('');
	});
	
	function confirm_validate(n){
		$.ajax({
			url:'delivery_order_project_confirm_view.php',
			data:{
				delivery_order_id:n,
			},
			type:'POST',
			success:function(response){
				$('.view_delivery_order_wrapper').fadeIn();
				$('#view_delivery_order_box').html(response);
			},
		});
	}
	
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
		$('#delete_notification').fadeOut();
	});
	
	$('.btn-delete').click(function(){
		$.ajax({
			url:"delete_delivery_order_project.php",
			data:{
				id:$('#delete_id').val(),
			},
			success:function(){
				location.reload();
			},
			type:"POST",
		})
	});
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