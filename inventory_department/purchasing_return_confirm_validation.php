<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$id					= $_POST['id'];
	$sql				= "SELECT code_purchase_return_sent.document, supplier.name, supplier.address, supplier.city
							FROM code_purchase_return_sent 
							JOIN code_purchase_return ON code_purchase_return_sent.code_purchase_return_id = code_purchase_return.id
							JOIN supplier ON code_purchase_return.supplier_id = supplier.id
							WHERE code_purchase_return_sent.id = '$id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
		
	$document			= $row['document'];
	$supplier_name		= $row['name'];
	$supplier_address	= $row['address'];
	$supplier_city		= $row['city'];
?>
<head>
	<title>Confirm purchase return</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p style='font-family:museo'>Purchasing return</p>
	<hr>
	<label>Supplier data</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<label>Purchasing return data</label>
	<p style='font-family:museo'><?= $document ?></p>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Referece</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
<?php
		$sql				= "SELECT purchase_return_sent.quantity, purchase_return.reference, itemlist.description 
								FROM purchase_return_sent 
								JOIN purchase_return ON purchase_return.id = purchase_return_sent.purchase_return_id
								JOIN itemlist ON purchase_return.reference = itemlist.reference
								WHERE sent_id = '$id'";
		$result				= $conn->query($sql);
		while($row			= $result->fetch_assoc()){
			$reference		= $row['reference'];
			$description	= $row['description'];
			$quantity		= $row['quantity'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $quantity ?></td>
			</tr>
<?php				
		}
?>
		</tbody>
	</table>
	<button type='button' class='button_danger_dark' id='delete_return_button'>Delete</button>
	<button type='button' class='button_success_dark' id='confirm_return_button'>Confirm</button>
</div>
<div class='full_screen_wrapper' id='delete_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class='fa fa-ban'></i></h1>
		<p style='font-familY:museo'>Are your sure to delete this purchasing return</p>
		<button type='button' class='button_danger_dark' id='close_delete_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_delete_return'>Confirm</button>
	</div>
</div>

<div class='full_screen_wrapper' id='confirm_notification'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:green'><i class='fa fa-check'></i></h1>
		<p style='font-familY:museo'>Are your sure to confirm this purchasing return</p>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#delete_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#delete_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		
		$('#delete_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#delete_notification').fadeIn(300);
	});
	
	$('#close_delete_button').click(function(){
		$('#delete_notification').fadeOut(300);
	});
	
	$('#confirm_return_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#confirm_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		
		$('#confirm_notification .full_screen_notif_bar').css('top', 0.7 * difference / 2);
		$('#confirm_notification').fadeIn(300);
	});
	
	$('#close_notif_button').click(function(){
		$('#confirm_notification').fadeOut(300);
	});
	
	$('#confirm_delete_return').click(function(){
		$.ajax({
			url:'purchasing_return_delete.php',
			data:{
				id:<?= $id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				window.location.href='/agungelektrindo/inventory_department/return_confirm_dashboard';
			}
		})
	});
	
	$('#confirm_button').click(function(){
		$.ajax({
			url:'purchasing_return_confirm.php',
			data:{
				id:<?= $id ?>,
			},
			type:'POST',
			beforeSend:function(){
				$('button').attr('disabled',true);
			},
			success:function(){
				window.location.href='/agungelektrindo/inventory_department/return_confirm_dashboard';
			}
		})
	});
</script>