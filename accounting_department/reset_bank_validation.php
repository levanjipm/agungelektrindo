<?php
	include('../codes/connect.php');
	$bank_id		= $_POST['bank_id'];
	$sql			= "SELECT value, bank_opponent_id, label FROM code_bank WHERE id = '$bank_id'";
	$result			= $conn->query($sql);
	$row			= $result->fetch_assoc();
	$value			= $row['value'];
	$label			= $row['label'];
	switch($label){
		case 'CUSTOMER':
		$customer_id		= $row['bank_opponent_id'];
		$sql_customer		= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		
		$child_array		= [];
		
		$sql_child			= "SELECT * FROM code_bank WHERE major_id = '$bank_id'";
		$result_child		= $conn->query($sql_child);
		$number_of_child	= mysqli_num_rows($result_child);
		while($child		= $result_child->fetch_assoc()){
			array_push($child_array, $child['id']);
		}
		$where				= implode(',', $child_array);
?>
	<h2 style='font-family:bebasneue'>Reset transaction</h2>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<hr>
	<label>Bank data</label>
	<p style='font-family:museo'>Input value: Rp. <?= number_format($value,2) ?></p>
	<p style='font-family:museo'>Assigned to <?= $number_of_child ?> bank data</p>
	<table class='table table-bordered'>
		<tr>
			<th>Invoice name</th>
			<th>Value assigned</th>
		</tr>
<?php
		$sql_receivable		= "SELECT receivable.value, invoices.name
								FROM receivable 
								JOIN invoices ON receivable.invoice_id = invoices.id
								WHERE receivable.bank_id IN ($where) OR receivable.bank_id = '$bank_id'";
		$result_receivable	= $conn->query($sql_receivable);
		while($receivable	= $result_receivable->fetch_assoc()){
?>
		<tr>
			<td><?= $receivable['name'] ?></td>
			<td>Rp. <?= number_format($receivable['value'],2) ?></td>
		</tr>
<?php
		}
?>
	</table>
	<button class='button_success_dark' id='reset_button'>Submit</button>
	<script>
		$('#reset_button').click(function(){
			$.ajax({
				url:'reset_bank_input.php',
				data:{
					bank_id:<?= $bank_id ?>,
					type:1,
				},
				type:'POST',
				beforeSend:function(){
					$('#reset_button').attr('disabled',true);
				},
				success:function(){
					$('.full_screen_close_button').click();
				}
			})
		});
	</script>
<?php
		break;
	
		case 'SUPPLIER':
		$supplier_id		= $row['bank_opponent_id'];
		$sql_supplier		= "SELECT name FROM supplier WHERE id = '$supplier_id'";
		$result_supplier	= $conn->query($sql_supplier);
		$supplier			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
		
		$child_array		= [];
		
		$sql_child			= "SELECT * FROM code_bank WHERE major_id = '$bank_id'";
		$result_child		= $conn->query($sql_child);
		$number_of_child	= mysqli_num_rows($result_child);
		while($child		= $result_child->fetch_assoc()){
			array_push($child_array, $child['id']);
		}
		$where				= implode(',', $child_array);
?>
	<h2 style='font-family:bebasneue'>Reset transaction</h2>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<hr>
	<label>Bank data</label>
	<p style='font-family:museo'>Input value: Rp. <?= number_format($value,2) ?></p>
	<p style='font-family:museo'>Assigned to <?= $number_of_child ?> bank data</p>
	<table class='table table-bordered'>
		<tr>
			<th>Invoice name</th>
			<th>Value assigned</th>
		</tr>
<?php
		$sql_receivable		= "SELECT payable.value, purchases.name
								FROM payable 
								JOIN purchases ON payable.purchase_id = purchases.id
								WHERE payable.bank_id IN ($where) OR payable.bank_id = '$bank_id'";
		$result_receivable	= $conn->query($sql_receivable);
		while($receivable	= $result_receivable->fetch_assoc()){
?>
		<tr>
			<td><?= $receivable['name'] ?></td>
			<td>Rp. <?= number_format($receivable['value'],2) ?></td>
		</tr>
<?php
		}
?>
	</table>
	<button class='button_success_dark' id='reset_button'>Submit</button>
	<script>
		$('#reset_button').click(function(){
			$.ajax({
				url:'reset_bank_input.php',
				data:{
					bank_id:<?= $bank_id ?>,
					type:2
				},
				type:'POST',
				beforeSend:function(){
					$('#reset_button').attr('disabled',true);
				},
				success:function(){
					$('.full_screen_close_button').click();
				}
			})
		});
	</script>
<?php
		break;
	}
?>