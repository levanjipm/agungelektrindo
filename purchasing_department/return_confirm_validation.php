<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
	$return_id				= $_POST['id'];
	$sql					= "SELECT id FROM code_purchase_return WHERE id = '$return_id' AND isconfirm = '0'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
<script>
	window.location.href='return_confirm_dashboard';
</script>
<?php
	}
	
	$sql_code				= "SELECT code_purchase_return.submission_date,  supplier.name, 
								supplier.address, supplier.city, users.name as creator_name FROM code_purchase_return
								JOIN supplier ON code_purchase_return.supplier_id = supplier.id
								JOIN users ON code_purchase_return.created_by = users.id
								WHERE code_purchase_return.id = '$return_id'";
	$result_code 			= $conn->query($sql_code);
	$code					= $result_code->fetch_assoc();
	$supplier_name			= $code['name'];
	$supplier_address		= $code['address'];
	$supplier_city			= $code['city'];
	$return_date			= $code['submission_date'];
	$creator				= $code['creator_name'];
?>	
<head>
	<title>Confirm purchasing return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name	?></p>	
	<p style='font-family:museo'><?= $supplier_address	?></p>
	<p style='font-family:museo'><?= $supplier_city	?></p>
	<label>Return data</label>
	<p style='font-family:museo'>Submited on <?= date('d M Y',strtotime($return_date)) ?></p>
	<p style='font-family:museo'>Created by <?= $creator ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Total price</th>
		</tr>
<?php
	$total_return		= 0;
	$sql				= "SELECT purchase_return.price, purchase_return.reference, purchase_return.quantity, itemlist.description
							FROM purchase_return 
							JOIN itemlist ON purchase_return.reference = itemlist.reference
							WHERE code_id = '$return_id'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$reference		= $row['reference'];
		$description	= $row['description'];
		$quantity		= $row['quantity'];
		$price			= $row['price'];
		$total_price	= $price * $quantity;
?>
		<tr>
			<td><?= $reference		 ?></td>
			<td><?= $description	 ?></td>
			<td><?= $quantity		 ?></td>
			<td>Rp. <?= number_format($price,2)			 ?></td>
			<td>Rp. <?= number_format($total_price,2)	 ?></td>
		</tr>
<?php
		$total_return	+= $total_price;
	}
?>
		<tr>
			<td colspan='2'></td>
			<td colspan='2'>Total</td>
			<td>Rp. <?= number_format($total_return,2) ?></td>
		</tr>
	</table>
	<button class='button_danger_dark' id='delete_return_button'>Delete</button>
	<button class='button_success_dark' id='confirm_return_button'>Submit</button>
</div>
<div class='full_screen_wrapper' id='delete_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this return?</p>
		<button class='button_danger_dark' id='close_delete_notif_button'>Check again</button>
		<button class='button_success_dark' id='confirm_delete_button'>Confirm</button>
	</div>
</div>
<div class='full_screen_wrapper' id='confirm_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:green'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to confirm this return?</p>
		<button class='button_danger_dark' id='close_confirm_notif_button'>Check again</button>
		<button class='button_success_dark' id='confirm_confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#delete_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#delete_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#delete_notification .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#delete_notification').fadeIn(300);
	});
	
	$('#close_delete_notif_button').click(function(){
		$('#delete_notification').fadeOut(300);
	});
	
	$('#confirm_delete_button').click(function(){
		$.ajax({
			url:'return_confirm_delete.php',
			data:{
				return_id:<?= $return_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				location.href='return_confirm_dashboard';
			}
		});
	});
	
	$('#confirm_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#confirm_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#confirm_notification .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#confirm_notification').fadeIn(300);
	});
	
	$('#close_confirm_notif_button').click(function(){
		$('#confirm_notification').fadeOut(300);
	});
	
	$('#confirm_confirm_button').click(function(){
		$.ajax({
			url:'return_confirm_confirm.php',
			data:{
				return_id:<?= $return_id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				location.href='return_confirm_dashboard';
			}
		});
	});
</script>
	