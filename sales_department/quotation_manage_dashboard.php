<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Manage quotation</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Quotation</h2>
	<p style='font-family:museo'>Manage quotations</p>
	<hr>
	<a href='/agungelektrindo/sales_department/quotation_create_dashboard'><button class='button_default_dark'>Create quotation</button></a>
	<br><br>
	
	<input type="text" id='search_bar'><br><br>
	
	<div id='quotation_table'>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th>Action</th>
		</tr>
<?php
	$sql_quotation 			= "SELECT id FROM code_quotation";
	$result_quotation		= $conn->query($sql_quotation);
	$pages					= ceil(mysqli_num_rows($result_quotation) / 25);
	
	$sql_quotation 			= "SELECT code_quotation.id, code_quotation.date, code_quotation.name, customer.name as customer_name, customer.address, customer.city FROM code_quotation 
								JOIN customer ON code_quotation.customer_id = customer.id
								ORDER BY code_quotation.id DESC LIMIT 25";
	$result_quotation 		= $conn->query($sql_quotation);
	while($quotation 		= $result_quotation->fetch_assoc()){
		$customer_name		= $quotation['customer_name'];
		$customer_address	= $quotation['address'];
		$customer_city		= $quotation['city'];
		
		$quotation_id		= $quotation['id'];
		$quotation_name		= $quotation['name'];
		$quotation_date		= $quotation['date'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($quotation_date)) ?></td>
			<td><?= $quotation_name ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_name ?></p>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
				<button type='button' class='button_default_dark' onclick='view_quotation(<?= $quotation_id ?>)'><i class="fa fa-eye"></i></button>
				<button type='button' class='button_success_dark' onclick='edit_quotation(<?= $quotation_id ?>)'><i class="fa fa-pencil"></i></button>
			</td>
		</tr>
<?php
	}
?>
	</table>
	
	<select class='form-control' id='page' style='width:100px'>
<?php
	for($i = 1; $i <= $pages; $i++){
?>
		<option value='<?= $i ?>'><?= $i ?></option>
<?php
	}
?>
	</select>
	</div>
</div>
<form id='edit_quotation_form' action='quotation_edit' method='POST'>
	<input type='hidden' id='quotation_edit_id' name='id'>
</form>

<div class='full_screen_wrapper' id='view_quotation_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function edit_quotation(n){
		$('#quotation_edit_id').val(n);
		$('#edit_quotation_form').submit();
	}
	
	function view_quotation(n){
		$('.isactive').removeClass('isactive');
		$('#row-' + n).addClass('isactive');
		$.ajax({
			url: "quotation_view.php",
			data: {
				id: n
			},
			type: "POST",
			dataType: "html",
			success: function (response) {
				$('#view_quotation_wrapper').fadeIn();
				$('#view_quotation_wrapper .full_screen_box').html(response);
			},
		});
	}
	
	$('#view_quotation_wrapper .full_screen_close_button').click(function(){
		$('#view_quotation_wrapper').fadeOut();
	});
	
	$('#search_bar').change(function(){
		$.ajax({
			url:'quotation_manage_view',
			data:{
				term:$('#search_bar').val(),
			},
			type:'GET',
			beforeSend:function(){
				$('.loading_wrapper_initial').fadeIn();
				$('#search_bar').attr('disabled',true);
			},
			success:function(response){
				$('#quotation_table').html(response);
				$('.loading_wrapper_initial').fadeOut();
				$('#search_bar').attr('disabled',false);
			}
		});
	});
	
	$('#page').change(function(){
		$.ajax({
			url:'quotation_manage_view',
			data:{
				term:$('#search_bar').val(),
				page:$('#page').val()
			},
			type:'GET',
			beforeSend:function(){
				$('.loading_wrapper_initial').fadeIn();
				$('#search_bar').attr('disabled',true);
			},
			success:function(response){
				$('#quotation_table').html(response);
				$('.loading_wrapper_initial').fadeOut();
				$('#search_bar').attr('disabled',false);
			}
		});
	});
</script>