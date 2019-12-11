<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Manage customers</title>
</head>
<style>
	.search_bar {
		padding:10px;
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
	}
	.search_bar:focus {
		width: 100%;
	}
</style>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p style='font-family:museo'>Edit customer data</p>
	<hr>
	<label>Search</label>
	<br>
	<input type='text' id='customer_filter' placeholder='Search customer here' class='search_bar'>
	<br><br>
	<table  class='table table-bordered'>
		<tr>
			<th style="text-align:center"><strong>Name</strong></th>
			<th style="text-align:center"><strong>Address</strong></th>
			<th colspan='3'></th>
		</tr>
		<tbody  id="edititemtable">
<?php
	$sql 		= "SELECT id,name,address FROM customer ORDER BY name";
	$result 	= $conn->query($sql);
	while($row 	= mysqli_fetch_array($result)) {
?>
		<tr>
			<td><?= $row['name']?></td>
			<td><?= $row['address']?></td>
			<td>
				<button type="button" class="button_default_dark" onclick='open_edit_customer(<?= $row['id'] ?>)'>
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</button>
			</td>
			<td>
				<a  href='/agungelektrindo/sales_department/customer_view.php?id=<?= $row['id'] ?>'>
				<button class='button_success_dark'><i class="fa fa-eye" aria-hidden="true"></i></button>
				</a>
			</td>
<?php
		$sql_check 		= "SELECT
							(SELECT COUNT(id) FROM code_salesorder WHERE customer_id = '" . $row['id'] . "') AS table1,
							(SELECT COUNT(id) FROM code_quotation WHERE customer_id = '" . $row['id'] . "') AS table2,
							(SELECT COUNT(id) FROM code_bank WHERE bank_opponent_id = '" . $row['id'] . "' AND label = 'CUSTOMER') AS table3,
							(SELECT COUNT(id) FROM code_delivery_order WHERE customer_id = '" . $row['id'] . "') AS table4,
							(SELECT COUNT(id) FROM code_project WHERE customer_id = '" . $row['id'] . "') AS table5";
		$result_check 	= $conn->query($sql_check);
		$check 			= $result_check ->fetch_assoc();
		$disabled 		= $check['table1'] + $check['table2'] + $check['table3'] + $check['table4'] + $check['table5'];
		if($disabled > 0){
?>		
			<td>
				<button type='button' class='button_danger_dark' disabled>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
			</td>
<?php
		} else {
?>
			<td>
				<button type='button' class='button_warning_dark' onclick='delete_customer(<?= $row['id'] ?>)' <?php if($disabled > 0){ echo ('disabled'); } ?>>
					<i class="fa fa-trash-o" aria-hidden="true"></i>
				</button>
			</td>
			
			<form action='customer_view.php' method='POST' id='view_customer_form<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='customer' readonly>
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
<div class='full_screen_wrapper' id='delete_wrapper'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-trash-o" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this customer?</p>
		<button type='button' class='button_danger_dark' id='close_notification_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_delete_customer'>Confirm</button>
	</div>
</div>
<div class='full_screen_wrapper' id='edit_wrapper'>
	<button type='button' class='full_screen_close_button'>X</button>
	<div class='full_screen_box'>
	</div>
</div>
<input type='hidden' value='0' id='customer_id' name='id'>
</body>
</html>
<script>
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
	
	$(document).ready(function(){
		$("#customer_filter").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#edititemtable tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
	
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
</script>
