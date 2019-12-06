<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	$sql_so 		= "SELECT * FROM code_salesorder WHERE isconfirm = '0'";
	$result_so 		= $conn->query($sql_so);
?>
<head>
	<title>Confirm sales order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales order</h2>
	<p>Confirm sales order</p>
	<hr>
<?php
	if(mysqli_num_rows($result_so) == 0){
		echo ('There are no sales order to be confirm');
	} else {
?>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th>Name</th>
			<th></th>
		</tr>
<?php
		while($so 		= $result_so->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($so['date'])) ?></td>
			<td style='text-align:left'><?php
				if($so['customer_id'] > 0){
					$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $so['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo '<p><strong>' . $customer['name'] . '</strong></p>';
					echo '<p>' . $customer['address'] . '</p>';
					echo $customer['city'];
				}
			?></td>
			<td><?= $so['name'] ?></td>
			<td>
				<button type='button' class='button_default_dark' onclick='submit(<?= $so['id'] ?>)'>
					<i class="fa fa-eye" aria-hidden="true"></i>
				</button>
				
				<form action='sales_order_confirm_validation' method='POST' id='form<?= $so['id'] ?>'>
					<input type='hidden' value='<?= $so['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
		}
?>
	</table>
<?php
	}
?>
</div>
<script>
	function submit(n){
		$('#form' + n).submit();
	}
</script>