<h3 style='font-family:bebasneue'>Available to send</h3>
<div class='row'>
<?php
	include('../codes/connect.php');
	
	
	$sql					= "SELECT DISTINCT(sales_order.so_id) as id, code_salesorder.name, code_salesorder.po_number, code_salesorder.retail_name, code_salesorder.customer_id FROM sales_order
								JOIN code_salesorder ON code_salesorder.id = sales_order.so_id
								WHERE code_salesorder.isconfirm = '1' AND sales_order.status = '0' AND code_salesorder.type = 'GOOD'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$sales_order_name	= $row['name'];
		$customer_id		= $row['customer_id'];
		$po_number			= $row['po_number'];
		$retail_name		= $row['retail_name'];
		
		if($customer_id == 0 || $customer_id == NULL || $customer_id == ''){
			$customer_name		= $retail_name;
		} else {
			$sql_customer 		= "SELECT name FROM customer WHERE id = '$customer_id'";
			$result_customer 	= $conn->query($sql_customer);
			$customer 			= $result_customer->fetch_assoc();
			$customer_name		= $customer['name'];
		}
?>
	<div class='col-sm-4' style='margin-top:30px;text-align:center'>
		<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
			<h3 style='font-family:bebasneue'><?= $row['name'] ?></h3>
			<p><?= $customer_name ?></p>
			<p><?= $po_number ?></p>
			<button type='button' class='button_default_dark' onclick='view(<?= $row['id'] ?>)'><i class='fa fa-eye'></i></button>
		</div>
	</div>
<?php
	}
?>
</div>