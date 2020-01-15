<?php
	include('../codes/connect.php');
	if(empty($_GET['page'])){
		$page		= 0;
	} else {
		$page		= $_GET['page'] - 1;
	}
	
	$offset			= $page * 25;
?>
	<table class='table table-bordered'>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th></th>
		</tr>
<?php
	$sql_count				= "SELECT id FROM customer";
	$result_count			= $conn->query($sql_count);
	$customer_count			= mysqli_num_rows($result_count);
	
	$max_page				= ceil($customer_count / 25);
	$sql_customer			= "SELECT * FROM customer ORDER BY name ASC LIMIT 25 OFFSET $offset";
	$result_customer		= $conn->query($sql_customer);
	while($customer			= $result_customer->fetch_assoc()){
		$customer_name		= $customer['name'];
		$customer_id		= $customer['id'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
		$blacklist			= $customer['is_blacklist'];
?>
		<tr <?php if($blacklist == 1){ echo "class='danger'"; } ?>>
			<td><?= $customer_name ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
				<a href='customer_view.php?id=<?= $customer_id ?>'>
					<button type='button' class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button>
				</a>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<p style='font-family:museo'>Total record: <?= number_format($customer_count) ?></p>
	<select class='form-control' id='page' style='width:100px;display:inline-block'>
<?php
	for($i = 1; $i <= $max_page; $i++){
?>
	<option value='<?= $i ?>' <?php if(!empty($_GET['page']) && $_GET['page'] == $i){ echo 'selected disabled'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
	<button type='button' class='button_default_dark' id='search_page' style='display:inline-block'><i class='fa fa-search'></i></button>
	<script>
		$('#search_page').click(function(){
			$.ajax({
				url: "customer_view_table.php",
				data: {
					page: $('#page').val(),
				},
				type: "GET",
				dataType: "html",
				beforeSend:function(){
					$('#customer_view_pane').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
				},
				success: function (data) {
					$('#customer_view_pane').html(data);
				},
			});
		});
	</script>