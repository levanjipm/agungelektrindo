<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$sql	= "SELECT DISTINCT(code_id) as id, customer.name, customer.address, customer.city, code_sample.date
				FROM sample
				INNER JOIN code_sample ON sample.code_id = code_sample.id
				JOIN customer ON code_sample.customer_id = customer.id
				WHERE sample.status = '0'";
	$result	= $conn->query($sql);
?>
<head>
	<title>Manage sample data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Manage sample data</p>
	<hr>

<?php
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There are no sample to manage</p>
<?php
	} else{
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th>Action</th>
		</tr>
<?php
	while($row	= $result->fetch_assoc()){
		$id					= $row['id'];
		$customer_name		= $row['name'];
		$customer_address	= $row['address'];
		$customer_city		= $row['city'];
		$date				= $row['date'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_name ?></p>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
				<button type='button' class='button_success_dark' onclick='view_sample(<?= $id ?>)'><i class='fa fa-eye'></i></button>
			</td>
		</tr>
<?php
	}
?>	
	</table>
	<div class='full_screen_wrapper' id='sample_view_wrapper'>
		<button type='button' class='full_screen_close_button'>&times </button>
		<div class='full_screen_box'></div>
	</div>
	
	<script>
		function view_sample(n){
			$.ajax({
				url:'sample_manage_view',
				data:{
					id:n
				},
				success:function(response){
					$('#sample_view_wrapper .full_screen_box').html(response);
					$('#sample_view_wrapper').fadeIn();
				}
			})
		}
		
		$('.full_screen_close_button').click(function(){
			$(this).parent().fadeOut();
		});
	</script>
<?php
	}
?>
</div>