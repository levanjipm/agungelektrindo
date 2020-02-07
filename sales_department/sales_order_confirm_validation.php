<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$sales_order_id		= $_POST['id'];
	$sql				= "SELECT * FROM code_salesorder WHERE id = '$sales_order_id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$file_type			= $row['document_type'];
	$guid				= $row['guid'];
	$sales_order_name	= $row['name'];
	
	if($row['customer_id'] == 0){
		$customer_name		= $row['retail_name'];
		$customer_address	= $row['retail_address'];
		$customer_city		= $row['retail_city'];
	} else {
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '" . $row['customer_id'] . "'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
	}
	
	$sales_order_type		= $row['type'];
	
	if($sales_order_type == "SRVC"){
		$type_text			= "Service sales order";
	} else {
		$type_text			= "Goods sales order";
	}
	
	$note					= $row['note'];
?>
<head>
	<title>Confirm sales order <?= $sales_order_name ?></title>
</head>
<script>
	$('#sales_order_side').click();
	$('#sales_order_confirm_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p style='font-family:museo'>Confirm sales order</p>
	<hr>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Sales order</label>
	<p style='font-family:museo'><?= $row['name']; ?></p>
	<p style='font-family:museo'><?= $type_text ?></p>
<?php
	if(!empty($row['document_type'])){
?>
	<a href='/agungelektrindo/sales_department/sales_order_images/<?= $guid . '.' . $file_type ?>' target='blank'>
		<button type='button' class='button_default_dark'><i class='fa fa-cloud-download'></i> Download</button>
	</a>
	<br><br>
<?php
	}
?>
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

	$sql_goods			= "SELECT * FROM sales_order WHERE so_id = '$sales_order_id'";
	$result_goods		= $conn->query($sql_goods);
	while($goods		= $result_goods->fetch_assoc()){
		$goods_total 	+= $goods['price'] * $goods['quantity'];
		$sql_item		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$goods['reference']) . "'";
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
	<p style='font-family:museo'><?= $note ?></p>
	<button type='button' class='button_danger_dark' id='delete_sales_order_button'>Delete</button>
	<button type='button' class='button_default_dark' id='submit_button'>Submit</button>
	
	<form action='sales_order_confirm' method='POST' id='form_confirm'>
		<input type='hidden' value='<?= $sales_order_id ?>' name='id'>
	</form>
</div>
<div class='full_screen_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-times" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this sales order?</p>
		<br>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Delete</button>
	</div>
</div>
<script>
	$('#submit_button').click(function(){
		$('#form_confirm').submit();
	});
	
	$('#delete_sales_order_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('.full_screen_wrapper').fadeIn();
	});
	
	$('#close_notif_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
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