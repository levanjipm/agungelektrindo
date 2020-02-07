<?php
	include('../codes/connect.php');
	$month 				= $_POST['month'];
	$year 				= $_POST['year'];
	$company			= $_POST['company'];
	if($company			== ''){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '$month' AND YEAR(invoices.date) = '$year' AND isconfirm = '1'
							ORDER BY code_delivery_order.company ASC, code_delivery_order.number ASC, date ASC, name ASC";
	} else if($company	== 'AE'){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '$month' AND YEAR(invoices.date) = '$year' AND isconfirm = '1' AND code_delivery_order.company = 'AE'
							ORDER BY code_delivery_order.company ASC, code_delivery_order.number ASC, date ASC, name ASC";
	} else if($company	== 'DSE'){
		$sql_search 		= "SELECT invoices.date, invoices.name, invoices.faktur, invoices.value, code_delivery_order.customer_id, code_delivery_order.id
							FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE MONTH(invoices.date) = '$month' AND YEAR(invoices.date) = '$year' AND isconfirm = '1' AND code_delivery_order.company = 'DSE'
							ORDER BY code_delivery_order.company ASC, code_delivery_order.number ASC, date ASC, name ASC";
	};
	
	$result_search 		= $conn->query($sql_search);
	if(mysqli_num_rows($result_search) == 0){
?>
	<p style='font-family:museo'>There is no data found</p>
<?php
	} else {
?>
	<h2 style='font-family:bebasneue'>Sales Report</h2>
	<p style='font-family:museo'><?= date('F Y',mktime(0,0,0,$month,1,$year)) ?></p>
	
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Date</th>
				<th>Tax document</th>
				<th>Invoice number</th>
				<th>Customer</th>
				<th>Value</th>
			</tr>
		</thead>
<?php
	$sales_journal_value		= 0;
	while($row_search 	= $result_search->fetch_assoc()){
		if($row_search['customer_id'] != NULL){
			$sql_customer 		= "SELECT customer.name FROM customer WHERE id = '" . $row_search['customer_id'] . "'";
			$result_customer 	= $conn->query($sql_customer);
			$customer 			= $result_customer->fetch_assoc();
			$customer_name		= $customer['name'];
		} else {
			$sql_sales_order	= "SELECT so_id FROM code_delivery_order WHERE id = '" . $row_search['id'] . "'";
			$result_sales_order	= $conn->query($sql_sales_order);
			$sales_order		= $result_sales_order->fetch_assoc();
			
			$so_id				= $sales_order['so_id'];
			
			$sql_customer		= "SELECT retail_name FROM code_salesorder WHERE id = '$so_id'";
			$result_customer	= $conn->query($sql_customer);
			$customer			= $result_customer->fetch_assoc();
			$customer_name		= $customer['retail_name'];
		}
		
		$value			= $row_search['value'];
		
		if($row_search['faktur'] == ''){
			$faktur		= 'Non pajak';
		} else {
			$faktur		= $row_search['faktur'];
		}
		
		$invoice_name	= $row_search['name'];
		
		$sales_journal_value += $value;
?>
		<tr>
			<td><?= date('d M Y',strtotime($row_search['date'])); ?></td>
			<td><?= $faktur ?></td>
			<td><?= $invoice_name ?></td>
			<td><?= $customer_name ?></td>
			<td>Rp. <?= number_format($value,2) ?></td>
		</tr>
<?php
	}
?>
		<tfoot>
			<tr>
				<td colspan='3'></td>
				<td><strong>Total</strong></td>
				<td>Rp. <?= number_format($sales_journal_value,2) ?></td>
			</tr>
		</tfoot>
	</table>
	<button type='button' class='button_success_dark hidden-print' onclick='window.print()'><i class='fa fa-print'></i></button>
<?php
	}
?>