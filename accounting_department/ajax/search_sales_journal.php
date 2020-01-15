<?php
	include('../../codes/connect.php');
	$month 				= $_POST['month'];
	$year 				= $_POST['year'];
	$company			= $_POST['company'];
	
	if($company			== ''){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '" . $month . "' AND YEAR(invoices.date) = '" . $year . "' AND isconfirm = '1'
							ORDER BY code_delivery_order.number ASC, date, name ASC";
	} else if($company	== 'AE'){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '" . $month . "' AND YEAR(invoices.date) = '" . $year . "' AND isconfirm = '1' AND code_delivery_order.company = 'AE'
							ORDER BY code_delivery_order.number ASC, date, name ASC";
	} else if($company	== 'DSE'){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '" . $month . "' AND YEAR(invoices.date) = '" . $year . "' AND isconfirm = '1' AND code_delivery_order.company = 'DSE'
							ORDER BY code_delivery_order.number ASC, date, name ASC";
	};
	
	$result_search 		= $conn->query($sql_search);
	$x 					= 1;
	while($row_search 	= $result_search->fetch_assoc()){
?>
	<tr>
		<td><?= date('d M Y',strtotime($row_search['date'])); ?></td>
		<td><?php
			if($row_search['faktur'] == ''){
				echo ('Non pajak');
			} else {
				echo ($row_search['faktur']); 
			}?></td>
		<td><?= $row_search['name']; ?></td>
		<td><?php
			if($row_search['customer_id'] != 0){
				$sql_customer 		= "SELECT customer.name FROM customer WHERE id = '" . $row_search['customer_id'] . "'";
				$result_customer 	= $conn->query($sql_customer);
				$customer 			= $result_customer->fetch_assoc();
				echo $customer['name'];
			} else {
				$sql_sales_order	= "SELECT so_id FROM code_delivery_order WHERE id = '" . $row_search['id'] . "'";
				$result_sales_order	= $conn->query($sql_sales_order);
				$sales_order		= $result_sales_order->fetch_assoc();
				
				$so_id				= $sales_order['so_id'];
				
				$sql_customer		= "SELECT retail_name FROM code_salesorder WHERE id = '$so_id'";
				$result_customer	= $conn->query($sql_customer);
				$customer			= $result_customer->fetch_assoc();
				echo $customer['retail_name'];
			}
		?></td>
		<td>Rp. <?= number_format($row_search['value'],2) ?></td>
		<input type='hidden' value='<?= $row_search['value'] ?>' id='value<?= $x ?>'>
	</tr>
<?php
	$x ++;
	}
?>