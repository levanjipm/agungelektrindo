<?php
	include('salesheader.php');
	//Closing the uncompleted sales order//
	if($role != 'superadmin'){
		header('location:sales.php');
	}
?>
<div class='main'>
	<div class='container'>
		<h3>Sales Order</h3>
		<p>Close sales order</p>
		<hr>
	</div>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Sales order</th>
			<th>Customer</th>
			<th>PO Number</th>
			<th></th>
		</tr>
<?php
	$sql_table = "SELECT DISTINCT(so_id) AS so_id FROM sales_order_sent WHERE status = '0'";
	$result_table = $conn->query($sql_table);
	while($table = $result_table->fetch_assoc()){
		$sql_detail = "SELECT id,name,date,po_number,customer_id FROM code_salesorder WHERE id = '" . $table['so_id'] . "'";
		$result_detail = $conn->query($sql_detail);
		$detail = $result_detail->fetch_assoc();
?>
		<tr>
			<td><?= date('d M Y',strtotime($detail['date'])) ?></td>
			<td><?= $detail['name'] ?></td>
			<td><?php
				$sql_customer = 'SELECT name FROM customer WHERE id = "' . $detail['customer_id'] . '"';
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td><?= $detail['po_number'] ?></td>
			<td>
				<button type='button' class='btn btn-danger' onclick='submit(<?= $detail['id'] ?>)'>Close sales order</button>
				<form id='form<?= $detail['id'] ?>' method='POST' action='close_so_validation.php'>
					<input type='hidden' value='<?= $detail['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
	}
?>
<script>
	function submit(n){
		$('#form' + n).submit();
	}
</script>