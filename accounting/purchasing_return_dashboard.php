<?php
	include('accountingheader.php');
?>
<div class='main'>
	<h2>Return</h2>
	<p>Purchasing return</p>
	<hr>
	<table class='table'>
		<tr>
			<th>Customer name</th>
			<th>DO Number</th>
			<th></th>
		</tr>
<?php
	$sql_return = "SELECT * FROM code_purchase_return WHERE send_date <> 'NULL'";
	$result_return = $conn->query($sql_return);
	while($return = $result_return->fetch_assoc()){
?>
		<tr>
			<td><?php
				$sql_customer = "SELECT name FROM supplier WHERE id = '" . $return['supplier_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer =  $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td>Rp. <?= number_format($return['value'],2) ?></td>
			<td>
				<button type='button' class='btn btn-default' onclick='submiting(<?= $return['id'] ?>)'>Next</button>
				<form action='purchase_return_validation.php' method='POST' id='form<?= $return['id'] ?>'>
					<input type='hidden' value='<?= $return['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
	}
?>
<script>
	function submiting(n){
		$('#form' + n).submit();
	}
</script>
</div>