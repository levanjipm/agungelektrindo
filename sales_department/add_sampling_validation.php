<?php	
	include('../universal/header/salesheader.php');
	$reference_array	= $_POST['reference'];
	$quantity_array		= $_POST['quantity'];
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sampling</h2>
	<p>Add sampling</p>
	<hr>
	<h2><?php 
		$sql_customer = "SELECT name,address FROM customer WHERE id = '" . $_POST['customer'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name']
	?></h2>
	<p><?= $customer['address'] ?></p>
	<form action='add_sampling_input.php' method='POST' id='submit_form'>
	<input type='hidden' value='<?= $_POST['customer'] ?>' name='customer' readonly>
		<table class='table table-bordered'>
			<tr>
				<th>No.</th>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
		$i = 1;
		foreach($reference_array as $reference){
			$key		= key($reference_array);
			$quantity	= $quantity_array[$key];
?>
			<tr>
				<td><?= $i ?></td>
				<td>
					<?= $reference ?>
					<input type='hidden' value='<?= mysqli_real_escape_string($conn,$reference) ?>' name='reference[<?= $i ?>]' readonly>
				</td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td>
					<?= $quantity ?>
					<input type='hidden' value='<?= $quantity ?>' name='quantity[<?= $i ?>]' readonly'>
				</td>
			</tr>
<?php
			$i++;
			next($reference_array);
		}
?>
		</table>
	</form>
	<hr>
	<button type='button' class='button_default_dark' onclick='submiting()'>
		Submit
	</button>
	<script>
		function submiting(){
			$('#submit_form').submit();
		}
	</script>