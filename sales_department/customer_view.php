<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$customer_id			= (int)$_GET['id'];
	$sql_customer			= "SELECT * FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	$customer				= $result_customer->fetch_assoc();
	
	if(mysqli_num_rows($result_customer) == 0){
?>
<head>
	<title>Customer not found!</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Customer data</p>
	<hr>
	<p style='font-family:museo'>Customer not found!</p>
</div>
<?php
	} else {
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
		$customer_phone		= $customer['phone'];
		
		$last_30			= date('Y-m-d',strtotime('-30 days'));
		$last_3				= date('Y-m-d',strtotime('-3 months'));
		$last_6				= date('Y-m-d',strtotime('-6 months'));
		
		$sql_invoices_1		= "SELECT SUM(invoices.value) as purchases FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.date > '$last_30'";
		$result_invoice_1	= $conn->query($sql_invoices_1);
		$invoice_1			= $result_invoice_1->fetch_assoc();
		$last_30			= $invoice_1['purchases'];
		
		$sql_invoices_2		= "SELECT SUM(invoices.value) AS purchases FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.date > '$last_3'";
		$result_invoice_2	= $conn->query($sql_invoices_2);
		$invoice_2			= $result_invoice_2->fetch_assoc();
		$last_3				= $invoice_2['purchases'];
		
		$sql_invoices_3		= "SELECT SUM(invoices.value) AS purchases FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id WHERE code_delivery_order.customer_id = '$customer_id' AND invoices.date > '$last_6'";
		$result_invoice_3	= $conn->query($sql_invoices_3);
		$invoice_3			= $result_invoice_3->fetch_assoc();
		$last_6				= $invoice_3['purchases'];
		
		$remaining_debt		= 0;
		
		$sql_debt			= "SELECT invoices.id,invoices.value, invoices.ongkir FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id WHERE invoices.isdone = '0' AND code_delivery_order.customer_id = '$customer_id'";
		$result_debt		= $conn->query($sql_debt);
		while($debt			= $result_debt->fetch_assoc()){
			$remaining_debt += $debt['value'] + $debt['ongkir'];
			$invoice_id		= $debt['id'];
			$sql_receive	= "SELECT SUM(value) as paid FROM receivable WHERE invoice_id = '$invoice_id'";
			$result_receive	= $conn->query($sql_receive);
			$receive		= $result_receive->fetch_assoc();
			
			$paid			= $receive['paid'];
			
			$remaining_debt -= $receive['paid'];
		}
?>
<head>
	<title>View <?= $customer_name ?></title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Customer data</p>
	<hr>
	<h3 style='font-family:museo'>General data</h3>
	<label>Name</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<label>Address</label>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<p style='font-family:museo'><?= $customer_phone ?></p>
	<h3 style='font-family:museo'>Purchase data</h3>
	<table class='table table-bordered'>
		<tr>
			<th>Last 30 days</th>
			<th>Last 3 months</th>
			<th>Last 6 month</th>
		</tr>
		<tr>
			<td>Rp. <?= number_format($last_30,2); ?></td>
			<td>Rp. <?= number_format($last_3,2); ?></td>
			<td>Rp. <?= number_format($last_6,2); ?></td>
		</tr>
	</table>
	<h3 style='font-family:museo'>Remaining debt</h3>
	<h4 style='font-family:museo'>Rp. <?= number_format($remaining_debt,2) ?></h4>
<?php
	}
?>