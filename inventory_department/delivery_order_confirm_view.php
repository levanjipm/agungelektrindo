<?php
	include('../codes/connect.php');
	$delivery_order_id			= (int)$_POST['delivery_order_id'];
	$sql						= "SELECT code_delivery_order.project_id, code_salesorder.type FROM code_delivery_order
								JOIN code_salesorder ON code_delivery_order.so_id = code_salesorder.id
								WHERE code_delivery_order.id = '$delivery_order_id'";
	$result						= $conn->query($sql);
	$row						= $result->fetch_assoc();
	
	$project_id					= $row['project_id'];
	$type						= $row['type'];
	
	if($project_id == NULL && $type == 'GOOD'){
		$case					= 'good';
	} else if($project_id == NULL && $type == 'SRVC'){
		$case					= 'service';
	} else {
		$case					= 'project';
	}
	
	switch ($case) {
		case 'good':
		$sql					= "SELECT date, name, customer_id, so_id FROM code_delivery_order WHERE id = '$delivery_order_id'";
		$result					= $conn->query($sql);
		$row					= $result->fetch_assoc();
		
		$customer_id			= $row['customer_id'];
		$delivery_order_name	= $row['name'];
		$delivery_order_date	= $row['date'];
		$sales_order_id			= $row['so_id'];
		
		if($customer_id != 0 || $customer_id != NULL){
			$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
			$result_customer		= $conn->query($sql_customer);
			
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['name'];
			$customer_address		= $customer['address'];
			$customer_city			= $customer['city'];
		} else {
			$sql_customer			= "SELECT retail_name, retail_address, retail_city FROM code_salesorder WHERE id = '$sales_order_id'";
			$result_customer		= $conn->query($sql_customer);
			$customer				= $result_customer->fetch_assoc();
			
			$customer_name			= $customer['retail_name'];
			$customer_address		= $customer['retail_address'];
			$customer_city			= $customer['retail_city'];
		}
?>
		<h2 style='font-family:bebasneue'>Confirm delivery order</h2>
		<label>Delivery order</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($delivery_order_date)) ?></p>
		<p style='font-family:museo'><?= $delivery_order_name ?></p>
		
		<label>Customer</label>
		<p style='font-family:museo'><?= $customer_name ?></p>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>
		<hr>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
		$sql_detail				= "SELECT * FROM delivery_order WHERE do_id = '$delivery_order_id'";
		$result_detail			= $conn->query($sql_detail);
		while($detail			= $result_detail->fetch_assoc()){
			$reference			= $detail['reference'];
			$quantity			= $detail['quantity'];
			
			$sql_item			= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
			$result_item		= $conn->query($sql_item);
			$item				= $result_item->fetch_assoc();
			
			$description		= $item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity,0) ?></td>
			</tr>
<?php
		}
?>
		</table>
		<button type='button' class='button_danger_dark' id='cancel_delivery_order_button'>Cancel</button>
		<button type='button' class='button_success_dark' id='confirm_delivery_order_button'>Submit</button>
		<script>
			$('#cancel_delivery_order_button').click(function(){
				$.ajax({
					url:'delivery_order_delete.php',
					data:{
						do_id:<?= $delivery_order_id ?>
					},
					type:'POST',
					beforeSend:function(){
						$('#confirm_delivery_order_button').attr('disabled',true);
						$('#cancel_delivery_order_button').attr('disabled',true);
						$('.full_screen_box_loader_wrapper').show();
					},
					success:function(){
						location.reload();
					}
				});
			});
			
			$('#confirm_delivery_order_button').click(function(){
				$.ajax({
					url:'delivery_order_confirm.php',
					data:{
						do_id:<?= $delivery_order_id ?>
					},
					type:'POST',
					beforeSend:function(){
						$('#confirm_delivery_order_button').attr('disabled',true);
						$('#cancel_delivery_order_button').attr('disabled',true);
						$('.full_screen_box_loader_wrapper').show();
					},
					success:function(){
						location.reload();
					}
				});
			});
		</script>
<?php
		break;
		case 'service':
		break;
	}			
?>