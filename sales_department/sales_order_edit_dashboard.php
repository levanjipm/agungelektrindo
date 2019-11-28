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
	<input type="text" id="search" name="search" class="form-control" placeholder="Search here">
	<br>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th>Note</th>
<?php
	if($role == 'superadmin'){
?>
			<th></th>
<?php
	}
?>
		</tr>
		<tbody id='edit_sales_order_table'>
<?php
	$sql_initial 			= "SELECT DISTINCT(so_id) AS so_id FROM sales_order WHERE status = '0'";
	$result_initial			= $conn->query($sql_initial);
	if(mysqli_num_rows($result_initial) > 0){
		while($initial 		= $result_initial->fetch_assoc()){
			$sql_code 		= "SELECT * FROM code_salesorder WHERE id = '" . $initial['so_id'] . "'";
			$result_code 	= $conn->query($sql_code);
			$code 			= $result_code->fetch_assoc();
			if($code['customer_id'] == 0){
				$customer_name	= $code['retail_name'];
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
				<td><?= $code['note'] ?></td>
<?php
	if($role == 'superadmin'){
?>
				<td><button type='button' class='button_danger_dark' onclick='submit_form_edit(<?= $initial['so_id'] ?>)'>Edit</button></td>
				<form id='form_edit_sales_order-<?= $initial['so_id'] ?>' action='sales_order_edit' method='POST'>
					<input type='hidden' value='<?= $initial['so_id'] ?>' name='id'>
				</form>
<?php
	}
?>		
			</tr>
<?php
		}
?>
		</tbody>
	</table>
</div>
</body>
<script>
function submit_form_edit(n){
	$('#form_edit_sales_order-' + n).submit();
};

function search_quotation(){
	if(($('#search')).val() == ''){
		alert('Please insert a keyword!');
		return false;
	} else {
		$.ajax({
			url: "sales_order_seach.php",
			data: {
				term: $('#search').val()
			},
			type: "POST",
			dataType: "html",
			success: function (data) {
				$('#quotation_result').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
			}
		});
	}
};
</script>
<?php
	} else {
		echo ('There is no sales order to be seen');
	}
?>