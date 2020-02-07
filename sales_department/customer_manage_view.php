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
			<th>Action</th>
		</tr>
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
	
	$result_customer		= $conn->query($sql_customer);
	while($customer			= $result_customer->fetch_assoc()){
		$customer_name		= $customer['name'];
		$customer_id		= $customer['id'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
		$blacklist			= $customer['is_blacklist'];
		$pic				= $customer['pic'];
		$prefix				= $customer['prefix'];
		
		$sql_check 		= "SELECT
							(SELECT COUNT(id) FROM code_salesorder WHERE customer_id = '$customer_id') AS table1,
							(SELECT COUNT(id) FROM code_quotation WHERE customer_id = '$customer_id') AS table2,
							(SELECT COUNT(id) FROM code_bank WHERE bank_opponent_id = '$customer_id' AND label = 'CUSTOMER') AS table3,
							(SELECT COUNT(id) FROM code_delivery_order WHERE customer_id = '$customer_id') AS table4,
							(SELECT COUNT(id) FROM code_project WHERE customer_id = '$customer_id') AS table5";
		$result_check 	= $conn->query($sql_check);
		$check 			= $result_check ->fetch_assoc();
		$disabled 		= $check['table1'] + $check['table2'] + $check['table3'] + $check['table4'] + $check['table5'];
?>
		<tr <?php if($blacklist == 1){ echo "class='danger'"; } ?>>
			<td><?= $customer_name ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
				<p style='font-family:museo'><?= $prefix . ' ' . $pic ?></p>
			</td>
			<td>
				<button type="button" class="button_default_dark" onclick='open_edit_customer(<?= $customer_id ?>)'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</button>
				<a href='customer_view.php?id=<?= $customer_id ?>' style='text-decoration:none'>
					<button type='button' class='button_success_dark'><i class='fa fa-eye'></i></button>
				</a>
<?php
	if($disabled > 0){
?>		
				<button type='button' class='button_danger_dark' disabled>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
<?php
	} else {
?>
				<button type='button' class='button_warning_dark' onclick='delete_customer(<?= $customer_id ?>)' title='Delete <?= $customer_name ?>'>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
<?php
	}
?>		
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
	
	<div class='full_screen_wrapper' id='delete_wrapper'>
		<div class='full_screen_notif_bar'>
			<h1 style='font-size:3em;color:red'><i class="fa fa-trash-o"></i></h1>
			<p style='font-family:museo'>Are you sure to delete this customer?</p>
			<button type='button' class='button_danger_dark' id='close_notification_button'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_delete_customer'>Confirm</button>
		</div>
	</div>
	
	<div class='full_screen_wrapper' id='edit_wrapper'>
		<button type='button' class='full_screen_close_button'>&times </button>
		<div class='full_screen_box'>
		</div>
	</div>
	<input type='hidden' value='0' id='customer_id' name='id'>
	
	<script>
		function open_edit_customer(n){
			$.ajax({
				url:'customer_edit_form.php',
				data:{
					customer_id:n,
				},
				type:'POST',
				success:function(response){
					$('.full_screen_box').html(response);
					setTimeout(function(){
						$('#edit_wrapper').fadeIn();
					},100);
				}
			});
		};
		function submit(n){
			$('.full_screen_close_button').click();
			$.ajax({
				url:"customer_edit.php",
				data:{
					id : n,
					namaperusahaan : $('#namaperusahaan' + n).val(),
					address : $('#address' + n).val(),
					npwp: $('#npwp' + n).val(),
					prefix: $('#prefix' + n).val(),
					pic : $('#pic' + n).val(),
					phone: $('#phone' + n).val(),
					city: $('#city' + n).val(),
				},
				success:function(){
					location.reload();
				},
				type:"POST",
			})
		}
		
		$("input[id^=npwp]").inputmask("99.999.999.9-999.999");
	
		function delete_customer(n){
			$('#customer_id').val(n);
			var window_height			= $(window).height();
			var bar_height				= $('.full_screen_notif_bar').height();
			var difference				= window_height - bar_height;
			$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
			$('#delete_wrapper').fadeIn();
		}
		
		$('#close_notification_button').click(function(){
			$('#delete_wrapper').fadeOut(300);
		});
		
		$('.full_screen_close_button').click(function(){
			$('.full_screen_wrapper').fadeOut();
		});
		
		$('#confirm_delete_customer').click(function(){
			$.ajax({
				url:"customer_delete.php",
				data:{
					id: $('#customer_id').val()
				},
				type:"POST",
				beforeSend:function(){
					$('#confirm_delete_customer').attr('disabled',true);
				},
				success:function(){
					location.reload()
				},
			})
		});
	</script>
	<script>
<?php
	if(empty($_GET['term']) || $_GET['term'] == ''){
?>
		$('#page').change(function(){
			$.ajax({
				url: "customer_manage_view.php",
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
					$('#customer_view_pane').html(data);
				},
			});
		});
<?php
	} else {
?>
		$('#page').change(function(){
			$.ajax({
				url: "customer_manage_view.php",
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
					$('#customer_view_pane').html(data);
				},
			});
		});
<?php
	}
?>
	</script>