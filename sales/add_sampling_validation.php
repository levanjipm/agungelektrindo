<?php	
	include('salesheader.php');
	for($i = 1; $i <= 3; $i++){
		if($_POST['reference1'] == '' || $_POST['quantity1'] == '' || $_POST['quantity1'] == 0){
?>
		<script>
			window.history.back();
		</script>			
<?php
		}
		if($_POST['reference' . $i] != ''){
			$sql_check = "SELECT COUNT(id) AS jumlah FROM itemlist WHERE reference = '" . $_POST['reference' . $i] . "'";
			$result_check = $conn->query($sql_check);
			$check = $result_check->fetch_assoc();
			if($check['jumlah'] == 0){
				break;
?>
		<script>
			window.history.back();
		</script>	
<?php
			}
		}
	}
?>
<div class='main'>
	<h2><?php 
		$sql_customer = "SELECT name,address FROM customer WHERE id = '" . $_POST['customer'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		echo $customer['name']
	?></h2>
	<p><?= $customer['address'] ?></p>
	<hr>
	<form action='add_sampling_input.php' method='POST' id='submit_form'>
	<input type='hidden' value='<?= $_POST['customer'] ?>' name='customer' readonly>
		<table class='table table-hover'>
			<tr>
				<th>No.</th>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
			</tr>
<?php
	for($i = 1; $i <= 3; $i++){
		if($_POST['reference' . $i] == ''){
?>
			<tr style='display:none'>
<?Php
		} else {
?>
			<tr>
<?php
		}
?>
		
				<td><?= $i ?></td>
				<td>
					<?= $_POST['reference' . $i ] ?>
					<input type='hidden' value='<?= $_POST['reference' . $i ] ?>' name='reference<?= $i ?>' readonly>
				</td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $_POST['reference' . $i] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td>
					<?= $_POST['quantity' . $i ] ?>
					<input type='hidden' value='<?= $_POST['quantity' . $i ] ?>' name='quantity<?= $i ?>' readonly'>
				</td>
			</tr>
<?php
	}
?>
		</table>
	</form>
	<hr>
	<button type='button' class='btn btn-default' onclick='submiting()'>
		Submit
	</button>
	<script>
		function submiting(){
			$('#submit_form').submit();
		}
	</script>