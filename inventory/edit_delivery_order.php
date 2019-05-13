<?php
	include('inventoryheader.php');
	if(empty($_POST['id'])){
?>
	<script>
		window.location.replace("edit_delivery_order_dashboard.php");
	</script>
<?php
	} else {
	$do_id = $_POST['id'];
	$sql_so = "SELECT so_id,name,customer_id FROM code_delivery_order WHERE id = '" . $do_id . "'";
	$result_so = $conn->query($sql_so);
	$row_so = $result_so->fetch_assoc();
	$so_id = $row_so['so_id'];
?>
<div class="main">
	<h3><?= $row_so['name'];?></h3>
	<p><?php
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $row_so['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name'];
	?></p>
	<form method='POST' action='edit_delivery_order_validation.php' id='myForm'>
	<table class='table'>
		<tr>
			<th style="width:40%">Item</th>
			<th style="width:20%">Sent item</th>
			<th style="width:20%">Quantity ordered</th>
			<th style="width:20%">Quantity to be sent</th>
		</tr>
<?php
	$tt = 1;
	$sql = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "'";
	$results = $conn->query($sql);
	if($results->num_rows > 0){
		while($row = $results->fetch_assoc()){
?>
		<tr>
			<td>
				<?= $row['reference'] ?>
				<input type='hidden' value='<?= $row['reference'] ?>' name='reference<?= $tt ?>'>
			</td>
			<td><?php
				$sql_detail = "SELECT quantity FROM sales_order_sent WHERE so_id = '" . $so_id . "' AND reference = '" . $row['reference'] . "'";
				$result_detail = $conn->query($sql_detail);
				$detail = $result_detail->fetch_assoc();
				$sql_do = "SELECT quantity FROM delivery_order WHERE do_id = '" . $do_id . "' AND reference = '" . $row['reference'] . "'";
				$result_do = $conn->query($sql_do);
				$do = $result_do->fetch_assoc();
				echo ($detail['quantity'] - $do['quantity']);
			?></td>
			<td>
				<?= $row['quantity'] ?>
			</td>
			<td>
				<input type='number' class='form-control' min ='0' name='quantity<?= $tt ?>' id='quantity<?= $tt ?>'>
			</td>
		</tr>
<?php
		$quantity[$tt] = $row['quantity'] + $do['quantity'] - $detail['quantity'];
		$tt++;
		
		}
?>
	</table>
	<br><br>
		<input type='hidden' value='<?= $do_id ?>' name='do_id'>
		<input type='hidden' value='<?= $tt ?>' name='i'>
		<button type='button' class='btn btn-success' onclick='check()'>Edit Delivery Order</button>
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
<?php
	}
?>
<script>
	function check(){
		var dd = 1;
		var nilai = 0;
		for(dd = 1; dd < <?= $tt ?>; dd++){
			var rencana = 0 + parseInt($('#quantity' + dd).val());
			var maximum = <?=json_encode($quantity)?>;
			if(rencana > maximum[dd]){
				alert('Cannot exceed sales order quantity');
				nilai ++;
				return false;
			}
		}
		console.log(nilai);
		if(nilai == 0){
			$('#myForm').submit();
		}
	}
</script>