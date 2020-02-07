<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Create payment</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Create payment</h2>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Supplier</th>
			<th>Overdue value</th>
			<th>Total debt</th>
			<th>Percentage</th>
		</tr>
<?php
	$overdue_array			= [];
	$total_overdue			= 0;
	$global_debt			= 0;
	$sql		= "SELECT supplier_id, sum(value) as sum_value FROM purchases WHERE isdone = '0' GROUP BY supplier_id ORDER BY sum_value DESC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$supplier_id		= $row['supplier_id'];
		$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
		$result_supplier	= $conn->query($sql_supplier);
		$supplier			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
		$supplier_address	= $supplier['address'];
		$supplier_city		= $supplier['city'];
		
		$sql_value			= "SELECT SUM(value) as total FROM purchases WHERE isdone = '0' AND supplier_id = '$supplier_id'";
		$result_value		= $conn->query($sql_value);
		$row_value			= $result_value->fetch_assoc();
		
		$debt_total			= $row_value['total'];
		
		$global_debt		+= $debt_total;
		
		$sql_cycle			= "SELECT id, value, date FROM purchases WHERE isdone = '0' AND supplier_id = '$supplier_id'";
		$result_cycle		= $conn->query($sql_cycle);
		$overdue			= 0;
		while($cycle		= $result_cycle->fetch_assoc()){
			$invoice		= $cycle['id'];
			$value			= $cycle['value'];
			$date			= $cycle['date'];
			
			$sql_payable	= "SELECT SUM(value) as paid FROM payable WHERE purchase_id = '$invoice'";
			$result_payable	= $conn->query($sql_payable);
			$row_payable	= $result_payable->fetch_assoc();
			
			$payable		= $row_payable['paid'];
			
			$sql_gr			= "SELECT code_purchaseorder.top FROM code_purchaseorder
								JOIN code_goodreceipt ON code_goodreceipt.po_id = code_purchaseorder.id
								WHERE invoice_id = '$invoice'";
			$result_gr		= $conn->query($sql_gr);
			$gr				= $result_gr->fetch_assoc();
			$top			= $gr['top'];
			
			if($top			== ''){
				$overdue_date	= date('Y-m-d', strtotime("+7 day", strtotime($date)));
			} else {
				$overdue_date	= date('Y-m-d', strtotime("+" . $top . " day", strtotime($date)));
				
			}
			
			if($overdue_date < date('Y-m-d')){
				$overdue			+= $value - $payable;;
				$total_overdue		+= $value - $payable;;
			}
		}
		
		$overdue_array[$supplier_id] = $overdue;
?>
		<tr>
			<td>
				<p style='font-family:museo'><?= $supplier_name	?></p>	
				<p style='font-family:museo'><?= $supplier_address	?></p>
				<p style='font-family:museo'><?= $supplier_city	?></p>
			</td>
			<td>Rp. <?= number_format($overdue,2) ?></td>
			<td>Rp. <?= number_format($debt_total,2) ?></td>
			<td id='percentage-<?= $supplier_id ?>'></td>
			<td>
				<a href='payment_detail.php?id=<?= $supplier_id ?>'><button class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button></a>
		</tr>
<?php
	}
	
	
	$json_array			= json_encode($overdue_array);
?>
		<tr>
			<td>Total overdue</td>
			<td><strong>Rp. <?= number_format($total_overdue,2) ?></strong></td>
			<td><strong>Rp. <?= number_format($global_debt,2) ?></strong></td>
		</tr>
	</table>
</div>
<script>
	var overdue_array		= <?= $json_array ?>;
	$(document).ready(function(){
		for (x in overdue_array) {
			var uid = x;
			var first_value = overdue_array[x];
			var final_value	= first_value / <?= $total_overdue ?>;
			
			$('#percentage-' + uid).html(numeral(final_value).format('0.00%'));
		}
	});
</script>