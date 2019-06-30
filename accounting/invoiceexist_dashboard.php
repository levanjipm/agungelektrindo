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
		
		<table class='table table-hover'>
			<tr>
				<th>Date</th>
				<th>DO name</th>
				<th>Customer name</th>
				<th></th>
			</tr>
<?php
	$sql_invoice = "SELECT sent,id,date,name,customer_id FROM code_delivery_order WHERE isinvoiced = '0'";
	$result_invoice = $conn->query($sql_invoice);
	while($invoice = $result_invoice->fetch_assoc()){
		if($invoice['sent'] == 1){
?>
			<tr>
				<td><?= date('d M Y',strtotime($invoice['date'])) ?></td>
				<td><?= $invoice['name'] ?></td>
				<td><?php
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo $customer['name'];
				?></td>
				<td>
					<button type='button' class='btn btn-default' onclick='submiting(<?= $invoice['id'] ?>)'>Create Invoice</button>
					<form style="padding:0px;margin:0px;width:100%" method="POST" action="build_invoice.php" id='do<?= $invoice['id'] ?>'>
						<input type='hidden' value='<?= $invoice['name'] ?>' name='sj'>
					</form>
				</td>
			</tr>
<?php
		} else {
?>
			<tr class='danger'>
				<td><?= date('d M Y',strtotime($invoice['date'])) ?></td>
				<td><?= $invoice['name'] ?></td>
				<td><?php
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $invoice['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo $customer['name'];
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