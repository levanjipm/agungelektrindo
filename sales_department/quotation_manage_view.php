<?php
	include('../codes/connect.php');
	if(empty($_GET['page']) && (empty($_GET['term']) || $_GET['term'] == '')){
?>
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
				<button type='button' class='button_success_dark' onclick='edit_form(<?= $quotation_id ?>)'><i class="fa fa-pencil"></i></button>
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
<?php
	} else if(!empty($_GET['page']) && (empty($_GET['term']) || $_GET['term'] == '')){
	$page		= $_GET['page'];
	$offset		= ($page - 1) * 25;
?>
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
								ORDER BY code_quotation.id DESC LIMIT 25 OFFSET $offset";
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
				<button type='button' class='button_success_dark' onclick='edit_form(<?= $quotation_id ?>)'><i class="fa fa-pencil"></i></button>
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
		<option value='<?= $i ?>' <?php if($i == $page){ echo 'selected'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
<?php
	} else if(!empty($_GET['term']) && $_GET['term'] != '' && empty($_GET['page'])){
		$term				= mysqli_real_escape_string($conn,$_GET['term']);
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th>Action</th>
		</tr>
<?php
	$sql_quotation 			= "SELECT code_quotation.id FROM code_quotation INNER JOIN customer ON customer.id = code_quotation.customer_id WHERE customer.name LIKE '%$term%'
								UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation
									JOIN itemlist ON quotation.reference = itemlist.reference
									WHERE quotation.reference LIKE '%$term%' 
									OR itemlist.description LIKE '%$term%'
								UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation JOIN itemlist ON quotation.reference = itemlist.reference WHERE itemlist.description LIKE '$%term%' 
								UNION SELECT id FROM code_quotation WHERE name LIKE '%as%' OR note LIKE '%$term%'";
	$result_quotation		= $conn->query($sql_quotation);
	$pages					= ceil(mysqli_num_rows($result_quotation) / 25);
	
	$sql_quotation 			= "SELECT code_quotation.date, code_quotation.name, a.id, customer.name as customer_name, customer.address, customer.city 
								FROM
									(SELECT code_quotation.id FROM code_quotation INNER JOIN customer ON customer.id = code_quotation.customer_id WHERE customer.name LIKE '%$term%'
									UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation
										JOIN itemlist ON quotation.reference = itemlist.reference
										WHERE quotation.reference LIKE '%$term%' 
										OR itemlist.description LIKE '%$term%'
									UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation JOIN itemlist ON quotation.reference = itemlist.reference WHERE itemlist.description LIKE '$%term%' 
									UNION SELECT id FROM code_quotation WHERE name LIKE '%$term%' OR note LIKE '%$term%') as a
								JOIN code_quotation ON a.id = code_quotation.id
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
				<button type='button' class='button_success_dark' onclick='edit_form(<?= $quotation_id ?>)'><i class="fa fa-pencil"></i></button>
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
<?php
	} else {
	$term		= mysqli_real_escape_string($conn,$_GET['term']);
	$page		= $_GET['page'];
	$offset		= ($page - 1) * 25;
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th>Action</th>
		</tr>
<?php
	$sql_quotation 			= "SELECT code_quotation.id FROM code_quotation INNER JOIN customer ON customer.id = code_quotation.customer_id WHERE customer.name LIKE '%$term%'
								UNION SELECT DISTINCT(quotation_code) AS id FROM quotation WHERE reference LIKE '%$term%'
								UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation JOIN itemlist ON quotation.reference = itemlist.reference WHERE itemlist.description LIKE '$%term%' 
								UNION SELECT id FROM code_quotation WHERE name LIKE '%as%' OR note LIKE '%$term%'";
	$result_quotation		= $conn->query($sql_quotation);
	$pages					= ceil(mysqli_num_rows($result_quotation) / 25);
	
	$sql_quotation 			= "SELECT code_quotation.date, code_quotation.name, a.id, customer.name as customer_name, customer.address, customer.city 
								FROM
									(SELECT code_quotation.id FROM code_quotation INNER JOIN customer ON customer.id = code_quotation.customer_id WHERE customer.name LIKE '%$term%'
									UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation
										JOIN itemlist ON quotation.reference = itemlist.reference
										WHERE quotation.reference LIKE '%$term%' 
										OR itemlist.description LIKE '%$term%'
									UNION SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation JOIN itemlist ON quotation.reference = itemlist.reference WHERE itemlist.description LIKE '$%term%' 
									UNION SELECT id FROM code_quotation WHERE name LIKE '%as%' OR note LIKE '%$term%') as a
								JOIN code_quotation ON a.id = code_quotation.id
								JOIN customer ON code_quotation.customer_id = customer.id
								ORDER BY code_quotation.id DESC LIMIT 25 OFFSET $offset";
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
				<button type='button' class='button_success_dark' onclick='edit_form(<?= $quotation_id ?>)'><i class="fa fa-pencil"></i></button>
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
		<option value='<?= $i ?>' <?php if($page == $i){ echo 'selected'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
<?php
	}
?>
<form action='quotation_edit' method='POST' id='quotation_edit_form'>
	<input type='hidden' id='quotation_id' name='id'>
</form>
<script>
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
	
	function edit_form(n){
		$('#quotation_id').val(n);
		$('#quotation_edit_form').submit();
	};
</script>