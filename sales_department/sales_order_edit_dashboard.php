<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<style>
	input[type=text] {
		padding:10px;
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	input[type=text]:focus {
		width: 100%;
	}
</style>
<head>
	<title>Edit sales order</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p style='font-family:museo'>Edit or close Sales Order</p>
	<hr>
	<input type="text" id="search" class="form-control" placeholder="Search here">
	<br>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th></th>
		</tr>
		<tbody id='edit_sales_order_table'>
<?php
	$sql		 			= "SELECT DISTINCT(so_id) AS so_id FROM sales_order WHERE status = '0'";
	$result					= $conn->query($sql);
	if(mysqli_num_rows($result) > 0){
		while($row	 		= $result->fetch_assoc()){
			$sql_code 		= "SELECT * FROM code_salesorder WHERE id = '" . $row['so_id'] . "'";
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
				<a href='sales_order_edit.php?id=<?= $row['so_id'] ?>'>
					<button type='button' class='button_success_dark' onclick='submit_form_edit(<?= $row['so_id'] ?>)'><i class="fa fa-pencil" aria-hidden="true"></i></button>
				</a>
			</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
</div>
</body>
<script>
$('#search').change(function(){
	if(($('#search')).val() == ''){
		alert('Please insert a keyword!');
		return false;
	} else {
		$.ajax({
			url: "sales_order_search.php",
			data: {
				term: $('#search').val()
			},
			type: "GET",
			beforeSend:function(){
				$('#search').attr('disabled',true);
			},
			success: function (data) {
				$('#search').attr('disabled',false);
				$('#edit_sales_order_table').html(data);
			}
		});
	}
});
</script>
<?php
	} else {
		echo ('There is no sales order to be seen');
	}
?>