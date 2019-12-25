<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Manage Projects</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h3>
	<p style='font-family:museo'>View project</p>
	<hr>
<?php
	$sql_code 		= "SELECT * FROM code_project WHERE isdone = '0'";
	$result_code 	= $conn->query($sql_code);
	if(mysqli_num_rows($result_code)){
?>
	<table class='table table-bordered'>
		<tr>
			<th>Date Start</th>
			<th>Project name</th>
			<th>Project description</th>
			<th>Customer name</th>
			<th></th>
		</tr>
<?php
		while($code 			= $result_code->fetch_assoc()){
			$project_id			= $code['id'];
			$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
			$result_customer 	= $conn->query($sql_customer);
			$customer 			= $result_customer->fetch_assoc();
			
			$customer_name		= $customer['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['start_date'])) ?></td>
			<td><?= $code['project_name'] ?></td>
			<td><?= $code['description'] ?></td>
			<td><?= $customer_name ?></td>
			<td>
				<button type='button' class='button_success_dark' onclick='view_project(<?= $project_id ?>)'><i class="fa fa-eye" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
		}
?>
	</table>
	<form action='project_manage' id='project_form' method='POST'>
		<input type='hidden' name='id' id='project_id'>
	</form>
	<script>
		function view_project(n){
			$('#project_id').val(n);
			$('#project_form').submit();
		}
	</script>
<?php
	} else {
?>
	<p>There is no project to view</p>
<?php
	}
?>
</div>