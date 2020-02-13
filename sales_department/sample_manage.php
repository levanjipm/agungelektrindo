<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$id					= $_POST['id'];
	$sql				= "SELECT customer.name, customer.address, customer.city, code_sample.date
							FROM code_sample
							JOIN customer ON code_sample.customer_id = customer.id
							WHERE code_sample.id = '$id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	$customer_name		= $row['name'];
	$customer_address	= $row['address'];
	$customer_city		= $row['city'];
	$date				= $row['date'];
	
	$sql				= "SELECT sample.id, sample.reference, itemlist.description, sample.quantity, sample.sent
							FROM sample
							JOIN itemlist ON sample.reference = itemlist.reference
							WHERE sample.code_id = '$id'";
	$result				= $conn->query($sql);
?>
<head>
	<title>Manage sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Manage sample</p>
	<hr>
	
	<label>Customer</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<button type='button' class='button_default_dark' id='add_item_button'>Add item</button>
	<br><br>
	<table class='table table-bordered'>
		<tr>
			<th>Reference</th>
			<th>Description</th>
			<th>Quantity</th>
			<th>Pending</th>
			<th>Action</th>
		</tr>
		<tbody id='sample_table'>
<?php
	while($row	= $result->fetch_assoc()){
		$id					= $row['id'];
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sent				= $row['sent'];
		
		$pending			= $quantity - $sent;
?>
		<tr id='item-<?= $id ?>'>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td>
				<input type='number' class='form-control' name='quantity[<?= $id ?>]' value='<?= $quantity ?>' min='<?= $sent ?>'>
			</td>
			<td><?= number_format($pending) ?></td>
			<td>
<?php
	if($sent == 0){
?>
				<button type='button' class='button_danger_dark' onclick='remove_item(<?= $id ?>)'><i class='fa fa-trash'></i></button>
<?php
	} else {
?>
				<button type='button' class='button_danger_dark'><i class='fa fa-trash'></i></button>
<?php
	}
?>
			</td>
		</tr>
<?php
	}
?>
		</tbody>
	</table>
	
	<div class='full_screen_wrapper' id='delete_notif_wrapper'>
		<div class='full_screen_notif_bar'>
			<h2 style='font-size:3em;color:red'><i class='fa fa-exclamation'></i></h2>
			<p style='font-family:museo'>Are you sure to delete this item?</p>
			<button type='button' class='button_danger_dark' id='close_notif_bar_button'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_button'>Confirm</button>
			
			<input type='hidden' id='item_id'>
		</div>
	</div>
	<script>
		function remove_item(n){
			var window_height = $(window).height();
			var notif_height	= $('#delete_notif_wrapper .full_screen_notif_bar').height();
			var difference		= window_height - notif_height;
			$('#item_id').val(n);
			$('#delete_notif_wrapper .full_screen_notif_bar').css('top', 0.7 * difference / 2);
			$('#delete_notif_wrapper').fadeIn();
		}
		
		$('#close_notif_bar_button').click(function(){
			$('#delete_notif_wrapper').fadeOut();
		});
		
		$('#confirm_button').click(function(){
			var item_id = $('#item_id').val();
			$.ajax({
				url:'sample_delete_item',
				data:{
					id:$('#item_id').val()
				},
				type:'GET',
				success:function(response){
					if(response == 1){
						$('#item-' + item_id).remove();
					} else if(response == 2){
						window.location.href='sample_manage_dashboard';
					}
				}
			})
		});
		
		$('#add_item_button').click(function(){
		});
	</script>