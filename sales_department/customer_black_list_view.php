<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Customer name</th>
				<th>Address</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
	$sql_customer				= "SELECT * FROM customer";
	$result_customer			= $conn->query($sql_customer);
	while($customer				= $result_customer->fetch_assoc()){
		$customer_id			= $customer['id'];
		$customer_name			= $customer['name'];
		$customer_address		= $customer['address'];
		$customer_city			= $customer['city'];
		$customer_is_black_list	= $customer['is_blacklist'];
?>	
			<tr>
				<td><?= $customer_name ?></td>
				<td><?= $customer_address . " " . $customer_city ?></td>
				<td>
<?php
		if($customer_is_black_list == 0){
?>
					<button type='button' class='button_danger_dark' onclick='black_list_customer(<?= $customer_id ?>)'>
						<i class='fa fa-ban'></i>
					</button>
<?php
		} else {
?>
					<button type='button' class='button_success_dark' onclick='white_list_customer(<?= $customer_id ?>)'>
						<i class='fa fa-check'></i>
					</button>
<?php
		}
?>
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>