<?php
	include('salesheader.php');
?>
<div class="main" style="padding:20px">
	<h3>Pending Sales Order</h3>
	<div class="row" style="padding:20px;background-color:#eee">
		<div class="col-lg-1" style="text-align:center"><b>Date</b></div>
		<div class="col-lg-3" style="text-align:center"><b>Sales order name</b></div>
		<div class="col-lg-3" style="text-align:center"><b>Customer</b></div>
		<div class="col-lg-1" style="text-align:center"></div>
		<div class="col-lg-3" style="text-align:center"><b>Pending items</b></div>
	</div>
<?php
	$sql = "SELECT DISTINCT(so_id) FROM sales_order_sent WHERE status = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$so_id = $row['so_id'];
		$sql_name = "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "'";
		$result_name = $conn->query($sql_name);
		while($row_name = $result_name->fetch_assoc()){
			$so_name = $row_name['name'];
			$customer_id = $row_name['customer_id'];
			$so_date = $row_name['date'];
		}
		$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
		$result_customer = $conn->query($sql_customer);
		while($row_customer = $result_customer->fetch_assoc()){
			$customer_name = $row_customer['name'];
		}
?>
			<div class="row" style="padding:10px">	
				<div class="col-lg-1" style="text-align:center"><?= date('j M Y',strtotime($so_date)) ?></div>
				<div class="col-lg-3" style="text-align:center"><?= $so_name ?></div>
				<div class="col-lg-3" style="text-align:center"><?= $customer_name ?></div>
				<div class='col-lg-4'>
<?php
			$sql_child = "SELECT sales_order.id, sales_order_sent.id, sales_order.quantity AS quantity_ordered,sales_order_sent.reference, sales_order_sent.status, sales_order.reference, sales_order_sent.quantity AS quantity_sent 
			FROM sales_order_sent
			INNER JOIN sales_order ON sales_order.id = sales_order_sent.id
			WHERE sales_order_sent.status = '0' AND sales_order_sent.so_id = '" . $so_id . "'";
			$result_child = $conn->query($sql_child);
			$i = 1;
			while($row_child = $result_child->fetch_assoc()){
			$reference = $row_child['reference'];
			$quantity_sent = $row_child['quantity_sent'];
			$quantity_ordered = $row_child['quantity_ordered'];
			$quantity = $quantity_ordered - $quantity_sent;
?>
					<?= $reference . '( ' . $quantity . ' )' ?><br>
<?php
		}
?>
				</div>
			</div>
<?php
	}
?>
</div>	