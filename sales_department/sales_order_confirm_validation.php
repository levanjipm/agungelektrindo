<?php
	include('salesheader.php');
	$sales_order_id		= $_POST['id'];
	$sql				= "SELECT * FROM code_salesorder WHERE id = '$sales_order_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	if($row['customer_id'] == 0){
		$customer_name		= $row['retail_name'];
	} else {
		$sql_customer		= "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		$customer_name		= $customer['name'];
	}
	
	$sales_order_type		= $row['type'];
	if($sales_order_type == "SRVC"){
		$type_text			= "Service sales order";
	} else {
		$type_text			= "Goods sales order";
	}
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
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p>Confirm sales order</p>
	<hr>
	<h3 style='font-family:bebasneue'><?= $customer_name ?></h3>
	<label>Number</label>
	<p><?= $row['name']; ?></p>
	<label>Type</label>
	<p><?= $type_text ?></p>
	<label>Unique GUID</label>
	<p><?= $row['guid'] ?></p>
	
	<table class='table table-bordered'>
<?php
	if($sales_order_type == "SRVC"){
?>
		<tr>
			<th>Service name</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total</th>
		</tr>
<?php
	$service_total		= 0;
	
	$sql_service		= "SELECT * FROM service_sales_order WHERE so_id = '$sales_order_id'";
	$result_service		= $conn->query($sql_service);
	while($service		= $result_service->fetch_assoc()){
		$service_total 	+= $service['unitprice'] * $service['quantity'];
?>
		<tr>
			<td><?= $service['description'] ?></td>
			<td><?= $service['quantity'] . $service['unit'] ?></td>
			<td>Rp. <?= number_format($service['unitprice'],2) ?></td>
			<td>Rp. <?= number_format($service['unitprice'] * $service['quantity'],2) ?></td>
		</tr>
<?php
		}
?>
		<tr>
			<td colspan='2'></td>
			<td>Total</td>
			<td>Rp. <?= number_format($service_total,2) ?></td>
		</tr>
<?php
	} else {
?>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Price_list</th>
			<th>Discount</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
		</tr>
<?php
	$goods_total	= 0;

	$sql_goods		= "SELECT * FROM sales_order WHERE so_id = '$sales_order_id'";
	$result_goods	= $conn->query($sql_goods);
	while($goods	= $result_goods->fetch_assoc()){
		$goods_total += $goods['price'] * $goods['quantity'];
		$sql_item	= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$goods['reference']) . "'";
		$result_item	= $conn->query($sql_item);
		$item			= $result_item->fetch_assoc();
		
		$description	= $item['description'];
?>
		<tr>
			<td><?= $goods['reference'] ?></td>
			<td><?= $description ?></td>
			<td>Rp. <?= number_format($goods['price_list'],2) ?></td>
			<td><?= number_format($goods['discount'],2) ?>%</td>
			<td>Rp. <?= number_format($goods['price'],2) ?></td>
			<td><?= number_format($goods['quantity'],0) ?></td>
			<td>Rp. <?= number_format($goods['quantity'] * $goods['price'],2) ?></td>
		</tr>
<?php
	}
?>
		<tr>
			<td colspan='4'></td>
			<td colspan='2'>Total</td>
			<td>Rp. <?= number_format($goods_total,2) ?></td>
		</tr>
<?php
	}
?>
	</table>
	<button type='button' class='button_danger_dark' id='delete_sales_order_button'>Delete</button>
	<button type='button' class='button_default_dark' id='submit_button'>Submit</button>
	
	<form action='sales_order_confirm' method='POST' id='form_confirm'>
		<input type='hidden' value='<?= $sales_order_id ?>' name='id'>
	</form>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-times" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this sales order?</h2>
		<br>
		<button type='button' class='btn-back'>Back</button>
		<button type='button' class='btn-delete' id='confirm_button'>Delete</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		$('#form_confirm').submit();
	});
	
	$('#delete_sales_order_button').click(function(){
		$('#confirm_notification').fadeIn();
	});
	
	$('.btn-back').click(function(){
		$('#confirm_notification').fadeOut();
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'sales_order_delete.php',
			data:{
				sales_order_id: <?= $sales_order_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('#confirm_button').attr('disabled');
			},
			success:function(){
				location.href='sales_order_confirm_dashboard'
			}
		})
	});
</script>