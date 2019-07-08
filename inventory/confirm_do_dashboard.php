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
			$customer_id = $row_do['customer_id'];
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer = $conn->query($sql_customer);
			while($row_customer = $result_customer->fetch_assoc()){
				$customer_name = $row_customer['name'];
			}
?>
				<div class="col-sm-3">
					<button type='button' class='btn btn-x' onclick='tutup(<?= $row_do['id'] ?>)'>X</button>
					<button type='button' onclick='view(<?= $row_do['id'] ?>)' style='background-color:transparent;border:none'>
						<img src="../universal/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
					</button>
					<br>
					<p style="text-align:center"><?= $row_do['name'];?></p>
					<p style="text-align:center"><b><?= $customer_name?></b></p>	
					<p style="text-align:center">
						<button type="button" class="btn btn-primary" onclick='confirm_validate(<?= $row_do['id'] ?>)'>Confirm</button>
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
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>
<script>
	function tutup(x){
		$('#delete_id').val(x);
		$('#delete_notification').fadeIn();
	};
	
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
	function confirm_validate(n){
		$('#confirm_id').val(n);
		$('#confirm_notification').fadeIn();
	}
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
		$('#delete_notification').fadeOut();
	});
	$('#confirm_button').click(function(){
		$.ajax({
			url:'sent_delivery_order.php',
			data:{
				id:$('#confirm_id').val()
			},
			success: function(){
				location.reload();
			},
			type:'GET',
		})
	});
	$('.btn-delete').click(function(){
		$.ajax({
			url:"delete_delivery_order.php",
			data:{
				id:$('#delete_id').val(),
			},
			success:function(){
				// window.location.href = 'inventory.php';
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