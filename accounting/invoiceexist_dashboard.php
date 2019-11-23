<?php
	include("accountingheader.php")
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<div class="main">
	<h2 style='font-family:bebasneue'>Sales Invoice</h2>
	<p>Create sales invoice</p>
	<hr>
	<div class="row" style="padding:0px;height:100%;margin:0px">
		
		<table class='table table-bordered'>
			<tr>
				<th>Date</th>
				<th>DO name</th>
				<th>Customer name</th>
				<th colspan='2'></th>
			</tr>
<?php
	$sql_invoice = "SELECT sent, id, date, name, customer_id, project_id, so_id
	FROM code_delivery_order
	WHERE code_delivery_order.isinvoiced = '0' AND company = 'AE'";
	$result_invoice = $conn->query($sql_invoice);
	while($invoice = $result_invoice->fetch_assoc()){
		$sql_so = "SELECT type FROM code_salesorder WHERE id = '" . $invoice['so_id'] . "'";
		$result_so = $conn->query($sql_so);
		$so = $result_so->fetch_assoc();
		if($invoice['sent'] == 1){
?>
			<tr>
				<td><?= date('d M Y',strtotime($invoice['date'])) ?></td>
				<td><?= $invoice['name'] ?></td>
				<td><?php
					if($invoice['customer_id'] != 0){
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name'];
					} else {
						$sql_customer = "SELECT code_salesorder.retail_name 
						FROM code_salesorder
						JOIN code_delivery_order ON code_delivery_order.so_id = code_salesorder.id
						WHERE code_delivery_order.id = '" . $invoice['id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['retail_name'];
					}
				?></td>
				<td>
					<button type='button' class='button_default_dark' onclick='submiting(<?= $invoice['id'] ?>)'>Create Invoice</button>
				</td>
				<td><?php
					if($invoice['project_id'] != NULL){
						echo ('Project invoice');
?>
					<form style="padding:0px;margin:0px;width:100%" method="POST" action="build_invoice_project.php" id='do<?= $invoice['id'] ?>'>
						<input type='hidden' value='<?= $invoice['name'] ?>' name='sj'>
					</form>
<?php
					} else if($so['type'] == 'SRVC'){
						echo ('Service invoice');
?>
					<form style="padding:0px;margin:0px;width:100%" method="POST" action="build_invoice_service.php" id='do<?= $invoice['id'] ?>'>
						<input type='hidden' value='<?= $invoice['name'] ?>' name='sj'>
					</form>
<?php
					} else {
						echo ('Goods invoice');
?>
					<form style="padding:0px;margin:0px;width:100%" method="POST" action="build_invoice.php" id='do<?= $invoice['id'] ?>'>
						<input type='hidden' value='<?= $invoice['name'] ?>' name='sj'>
					</form>
<?php
					}
				?></td>
			</tr>
<?php
		} else {
?>
			<tr class='danger'>
				<td><?= date('d M Y',strtotime($invoice['date'])) ?></td>
				<td><?= $invoice['name'] ?></td>
				<td><?php
					if($invoice['customer_id'] != 0){
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name'];
					} else {
						$sql_customer = "SELECT code_salesorder.retail_name 
						FROM code_salesorder
						JOIN code_delivery_order ON code_delivery_order.so_id = code_salesorder.id
						WHERE code_delivery_order.id = '" . $invoice['id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['retail_name'];
					}
				?></td>
				<td>
				</td>
			</tr>
<?php
		}
	}
?>
		</table>
	</div>
</div>
<script>
	function submiting(n){
		$('#do' + n).submit();
	}
</script>