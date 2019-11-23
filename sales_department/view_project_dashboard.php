<?php	
	include('salesheader.php');
?>
<div class='main'>
	<div class='container'>
		<h3>Project</h3>
		<p>View project</p>
		<hr>
	</div>
<?php
	$sql_code = "SELECT * FROM code_project WHERE isdone = '0'";
	$result_code = $conn->query($sql_code);
	if(mysqli_num_rows($result_code)){
?>
	<table class='table table-hover'>
		<tr>
			<th>Date Start</th>
			<th>Project name</th>
			<th>Project description</th>
			<th>Customer name</th>
			<th></th>
		</tr>
<?php
		while($code = $result_code->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['start_date'])) ?></td>
			<td><?= $code['project_name'] ?></td>
			<td><?= $code['description'] ?></td>
			<td><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td>
				<button type='button' class='btn btn-default'>+</button>
			</td>
		</tr>
<?php
		}
	} else {
?>
	<p>There is no project to view</p>
<?php
	}
?>