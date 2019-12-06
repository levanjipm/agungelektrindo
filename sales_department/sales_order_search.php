<?php
	include('../codes/connect.php');
	$term			= mysqli_real_escape_string($conn,$_GET['term']);
	$sql			= "SELECT DISTINCT(code_salesorder.id) FROM sales_order
						JOIN code_salesorder ON sales_order.so_id = code_salesorder.id
						JOIN customer ON customer.id = code_salesorder.customer_id 
						WHERE (code_salesorder.retail_name LIKE '%$term%' OR customer.name LIKE '%$term%' OR code_salesorder.name LIKE '%$term%' OR sales_order.reference LIKE '%$term%') AND sales_order.status = '0'
						";
	$result			= $conn->query($sql);
	while($row	 		= $result->fetch_assoc()){
			$sql_code 		= "SELECT * FROM code_salesorder WHERE id = '" . $row['id'] . "'";
			$result_code 	= $conn->query($sql_code);
			$code 			= $result_code->fetch_assoc();
			
			if($code['customer_id'] == 0){
				$customer_name		= $code['retail_name'];
			} else {
				$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
				$result_customer	= $conn->query($sql_customer);
				$customer			= $result_customer->fetch_assoc();
				
				$customer_name		= $customer['name'];
			}
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?= $code['name'] ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<a href='sales_order_edit.php?id=<?= $row['id'] ?>'
					<button type='button' class='button_success_dark' onclick='submit_form_edit(<?= $row['so_id'] ?>)'><i class="fa fa-pencil" aria-hidden="true"></i></button>
				</a>
			</td>
		</tr>
<?php
	}
?>