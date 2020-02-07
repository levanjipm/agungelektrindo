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
		<thead>
			<tr>
				<th>Customer name</th>
				<th>Address</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
<?php
	if(empty($_GET['term']) || $_GET['term'] == ''){
		$sql_count				= "SELECT id FROM customer";
	} else {
		$term					= mysqli_real_escape_string($conn,$_GET['term']);
		$sql_count				= "SELECT id FROM customer WHERE name LIKE '%$term%' OR pic LIKE '%$term%' OR address LIKE '%$term%' OR city LIKE '%$term'";
	}
	
	$result_count			= $conn->query($sql_count);
	$customer_count			= mysqli_num_rows($result_count);
	
	$max_page				= ceil($customer_count / 25);
	
	if(empty($_GET['term']) || $_GET['term'] == ''){
		$sql_customer			= "SELECT * FROM customer ORDER BY name ASC LIMIT 25 OFFSET $offset";
	} else {
		$sql_customer			= "SELECT * FROM customer WHERE name LIKE '%$term%' OR pic LIKE '%$term%' OR address LIKE '%$term%' OR city LIKE '%$term%' LIMIT 25 OFFSET $offset";
	}
	
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
	<select class='form-control' id='page' style='width:100px;display:inline-block'>
<?php
	for($i = 1; $i <= $max_page; $i++){
?>
		<option value='<?= $i ?>' <?php if(!empty($_GET['page']) && $_GET['page'] == $i){ echo 'selected disabled'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
<script>
<?php
	if(empty($_GET['term']) || $_GET['term'] == ''){
?>
		$('#page').change(function(){
			$.ajax({
				url: "customer_black_list_view.php",
				data: {
					page: $('#page').val(),
				},
				type: "GET",
				dataType: "html",
				beforeSend:function(){
					$('.loading_wrapper_initial').show();
				},
				success: function (data) {
					$('.loading_wrapper_initial').fadeOut(300);
					$('#customer_black_list_view').html(data);
				},
			});
		});
<?php
	} else {
?>
		$('#page').change(function(){
			$.ajax({
				url: "customer_black_list_view.php",
				data: {
					page: $('#page').val(),
					term:$('#search_bar').val()
				},
				type: "GET",
				dataType: "html",
				beforeSend:function(){
					$('.loading_wrapper_initial').show();
				},
				success: function (data) {
					$('.loading_wrapper_initial').fadeOut(300);
					$('#customer_black_list_view').html(data);
				},
			});
		});
<?php
	}
?>
	</script>