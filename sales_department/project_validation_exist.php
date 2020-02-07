<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
	
	$project				= $_POST['project'];
	$start_project			= $_POST['start_project'];
	$name_project			= mysqli_real_escape_string($conn,$_POST['name_project']);
	$description_project	= mysqli_real_escape_string($conn,$_POST['description_project']);
	
	$sql_code_project		= "SELECT * FROM code_project WHERE id = '$project'";
	$result_code_project	= $conn->query($sql_code_project);
	$code_project			= $result_code_project->fetch_assoc();
	
	$customer_id			= $code_project['customer_id'];
	$sql_customer			= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
	$result_customer		= $conn->query($sql_customer);
	
	$customer				= $result_customer->fetch_assoc();
	$customer_name			= $customer['name'];
	$customer_address		= $customer['address'];
	$customer_city			= $customer['city'];
	
	$major_project			= $code_project['project_name'];
	
	$taxing					= $code_project['taxing'];
	if($taxing == 1){
		$taxing_text	= "Taxable";
	} else {
		$taxing_text	= "Non - taxable";
	}
?>
<head>
	<title>Create project data</title>
</head>
<script>
	$('#project_side').click();
	$('#project_add_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p style='font-family:museo'>Add new project</p>
	<hr>
	<form action='project_input_existing' method='POST'>
		<label>Customer</label>
		<h4 style='font-family:museo'><?= $customer_name ?></h4>
		<p style='font-family:museo'><?= $customer_address ?></p>
		<p style='font-family:museo'><?= $customer_city ?></p>

		<input type='hidden' value='<?= $project ?>' name='project_major_id'>
		
		<label>Taxing</label>
		<p style='font-family:museo'><?= $taxing_text ?></p>
		<input type='hidden' value='<?= $taxing ?>' name='taxing'>
		
		<label>Project date</label>
		<p style='font-family:museo'><?= date('d M Y',strtotime($start_project)) ?></p>
		<input type='hidden' value='<?= $start_project ?>' name='start_project'>
		
		<label>Project name</label>
		<p style='font-family:museo'><?= $name_project ?></p>
		<input type='hidden' value='<?= $name_project ?>' name='name_project'>
		
		<label>Project description</label>
		<p style='font-family:museo'><?= $_POST['description_project'] ?></p>
		<input type='hidden' value='<?= $description_project ?>' name='description_project'>
		<button type='submit' class='button_success_dark'>Submit</button>
	</form>
</div>