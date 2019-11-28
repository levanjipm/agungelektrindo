<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$reference_array		= $_POST['reference'];
	$quantity_array			= $_POST['quantity'];
	$customer_id			= $_POST['customer'];
	$sql_customer 			= "SELECT name,address,city FROM customer WHERE id = '$customer_id'";
	$result_customer 		= $conn->query($sql_customer);
	$customer 				= $result_customer->fetch_assoc();
	
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
?>
<head>
	<title>Add sample data</title>
	<link rel='stylesheet' href='css/create_sample.css'></script>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sampling</h2>
	<p style='font-family:museo'>Add sampling</p>
	<hr>
	<h3 style='font-family:museo'>Customer data</h3>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	<h3 style='font-family:museo'>Sample data</h3>
	<form action='sample_add_input.php' method='POST' id='sample_form'>
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
	<button type='button' class='button_success_dark' onclick='submiting()'>
		Submit
	</button>
	<script>
		function submiting(){
			$('#sample_form').submit();
		}
	</script>