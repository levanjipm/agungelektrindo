<?php
	include('../codes/connect.php');
	$month			= $_POST['month'];
	$year			= $_POST['year'];
	
	if($month		== 1){
		$prev_month		= 12;
		$prev_year		= $year - 1;
	} else {
		$prev_month		= $month - 1;
		$prev_year		= $year;
	}
		
	
	$date			= date('Y-m-t',mktime('0','0','0',$prev_month,1,$prev_year));
	$end_of_date	= date('Y-m-t',mktime('0','0','0',$month,1,$year));

	
	$sql_invoice		= "SELECT SUM(value) as value, sum(ongkir) as delivery_fee FROM invoices WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
	$result_invoice		= $conn->query($sql_invoice);
	$invoice			= $result_invoice->fetch_assoc();
		
	$invoice_value		= $invoice['value'];
	$invoice_delivery	= $invoice['delivery_fee'];
	
	$sql_purchases		= "SELECT SUM(value) as value FROM purchases WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
	$result_purchases	= $conn->query($sql_purchases);
	$purchases			= $result_purchases->fetch_assoc();
	
	$purchase_value		= $purchases['value'];
	
	$sql_code_bank		= "SELECT SUM(code_bank.value) as expense_bank FROM code_bank_other JOIN code_bank ON code_bank.id = code_bank_other.bank_id
							WHERE code_bank_other.class != '25' AND month(code_bank.date) = '$month' AND YEAR(code_bank.date) = '$year'";
	$result_code_bank	= $conn->query($sql_code_bank);
	$code_bank			= $result_code_bank->fetch_assoc();
	
	$bank				= $code_bank['expense_bank'];
	
	$sql_code_bank		= "SELECT SUM(code_bank.value) as income_bank FROM code_bank_other JOIN code_bank ON code_bank.id = code_bank_other.bank_id
							WHERE code_bank_other.class = '25' AND month(code_bank.date) = '$month' AND YEAR(code_bank.date) = '$year'";
	$result_code_bank	= $conn->query($sql_code_bank);
	$code_bank			= $result_code_bank->fetch_assoc();
	
	$bank_income		= $code_bank['income_bank'];
	
	$total_start 		= 0;
	$sql_in 			= "SELECT id,quantity,price FROM stock_value_in WHERE date <= '$date'";
	$result_in 			= $conn->query($sql_in);
	while($in 			= $result_in->fetch_assoc()){
		$sql_out 		= "SELECT SUM(quantity) AS quantity_out FROM stock_value_out WHERE date <= '$date' AND in_id = '" . $in['id'] . "'";
		$result_out 	= $conn->query($sql_out);
		$out 			= $result_out->fetch_assoc();
		$quantity 		= $in['quantity'] - $out['quantity_out'];
		$total_start	+= $quantity * $in['price'];
	};
	
	$total_end	 		= 0;
	$sql_in 			= "SELECT id,quantity,price FROM stock_value_in WHERE date <= '$end_of_date'";
	$result_in 			= $conn->query($sql_in);
	while($in 			= $result_in->fetch_assoc()){
		$sql_out 		= "SELECT SUM(quantity) AS quantity_out FROM stock_value_out WHERE date <= '$end_of_date' AND in_id = '" . $in['id'] . "'";
		$result_out 	= $conn->query($sql_out);
		$out 			= $result_out->fetch_assoc();
		$quantity 		= $in['quantity'] - $out['quantity_out'];
		$total_end		+= $quantity * $in['price'];
	};
	
	$sql_petty_cash		= "SELECT SUM(value) as petty_cash FROM petty_cash WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
	$result_petty_cash	= $conn->query($sql_petty_cash);
	$petty_cash			= $result_petty_cash->fetch_assoc();
	
	$petty_value		= $petty_cash['petty_cash'];
	
	$stock_value_difference	= $total_start - $total_end;
	
?>
<table class='table table-bordered'>
	<tr>
		<td>Sales</td>
		<td>Rp. <?= number_format($invoice_value,2) ?></td>
	</tr>
	<tr>
		<td>Purchases</td>
		<td>Rp. <?= number_format($purchase_value,2) ?></td>
	</tr>
	<tr>
		<td>Starting stock value</td>
		<td>Rp. <?= number_format($total_start,2) ?></td>
	</tr>
	<tr>
		<td>Closing stock value</td>
		<td>Rp. <?= number_format($total_end,2) ?></td>
	</tr>
	<tr>
		<td>Stock value difference</td>
		<td>Rp. <?= number_format($stock_value_difference,2) ?></td>
	</tr>
	<tr>
		<td>Delivery fee reimbursment</td>
		<td>Rp. <?= number_format($invoice_delivery,2) ?></td>
	</tr>
	<tr>
		<td>Gross income</td>
		<td>Rp. <?= number_format($invoice_value - $purchase_value - $stock_value_difference + $invoice_delivery,2) ?></td>
	</tr>
	<tr>
		<td>Petty cash expense</td>
		<td>Rp. <?= number_format($petty_value,2) ?></td>
	</tr>
	<tr>
		<td>Bank expense</td>
		<td>Rp. <?= number_format($bank,2) ?></td>
	</tr>
	<tr>
		<td>Other income</td>
		<td>Rp. <?= number_format($bank_income,2) ?></td>
	</tr>
	<tr>
		<td>Net income before tax</td>
		<td>Rp. <?= number_format($invoice_value - $purchase_value - $stock_value_difference - $petty_value - $bank + $invoice_delivery,2) ?></td>
	</tr>
</table>