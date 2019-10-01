<DOCTYPE html>
<?php
	include('inventoryheader.php');
?>
<div class="main">
	<h2 style='font-family:bebasneue'>Delivery Order</h2>
	<p>Edit delivery order<p>
	<hr>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Delivery order number</th>
			<th>Customer</th>
			<th></th>
		</tr>
<?php
	//Can only edit the delivery order which is not delivered, or not confirmed//
	$sql = "SELECT * FROM code_delivery_order WHERE sent = '0' AND isdelete = '0'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		$row_do 			= $results->fetch_assoc();
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row_do['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
?>
			<tr>
				<td><?= date('d M Y',strtotime($row_do['date'])) ?></td>
				<td><?= $row_do['name'] ?></td>
				<td><?= $customer_name ?></td>
				<td>
					<button type='button' class='button_default_dark' onclick='testform(<?= $row_do['id'] ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
				</td>
				
				<form id='form<?= $row_do['id'] ?>' method='POST' action='delivery_order_edit'>
					<input type='hidden' value='<?= $row_do['id'] ?>' name='id'>
				</form>
			</tr>
<?php
		}
?>
	<script>
		function testform(n){
			var id = n;
			$('#form' + id).submit();
		}
	</script>
<?php	
	} else {
?>
			<div class="col-lg-6 offset-lg-3" style="text-align:center">
<?php
		echo ('There are no delivery order need to be approved');
	};
?>
			</div>	
		</div>
	</div>
</div>	