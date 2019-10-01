<?php
	include('../codes/connect.php');
	$do_id					= $_POST['do_id'];
	$sql					= "SELECT name, customer_id FROM code_delivery_order WHERE id = '$do_id' AND sent = '0'";
	$result					= $conn->query($sql);
	if($result){	
		$row				= $result->fetch_assoc();
		$do_name			= $row['name'];
		$customer_id		= $row['customer_id'];
		
		$sql_customer		= "SELECT name, address FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
?>
	<h2 style='font-family:bebasneue'><?= $do_name ?></h2>
	<p><strong><?= $customer_name ?></strong></p>
	<p><?= $customer_address ?></p>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
		</thead>
<?php
	$sql_delivery_order		= "SELECT * FROM delivery_order WHERE do_id = '$do_id'";
	$result_delivery_order	= $conn->query($sql_delivery_order);
	while($delivery_order	= $result_delivery_order->fetch_assoc()){
		$reference			= $delivery_order['reference'];
		$quantity			= $delivery_order['quantity'];
		$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
		$result_item		= $conn->query($sql_item);
		$item				= $result_item->fetch_assoc();
		
		$description		= $item['description'];
?>
		<tr>
			<td><?= $reference ?></td>
			<td><?= $description ?></td>
			<td><?= $quantity ?></td>
		</tr>
<?php
	}
?>
	</table>
	<br>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	<script>
		$('#submit_button').click(function(){
			$.ajax({
				url:'delivery_order_confirm.php',
				data:{
					do_id:<?= $do_id ?>,
				},
				type:'POST',
				success:function(){
					$('.view_delivery_order_dashboard').fadeOut(300);
					setTimeout(function(){
						location.reload();
					},300);
				},
			});
		})
	</script>
<?php
	}
?>