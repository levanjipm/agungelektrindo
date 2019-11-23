<?php
	include('salesheader.php');
	$major_id = $_POST['major_id'];
	$sql_detail = "SELECT * FROM code_project WHERE id = '" . $major_id . "'";
	$result_detail = $conn->query($sql_detail);
	$detail = $result_detail->fetch_assoc();
	
	$customer_id = $detail['customer_id'];
	$project_name = $detail['project_name'];
	$start_date = $detail['start_date'];
	
	$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
	$customer_name = $customer['name'];
	$customer_address = $customer['address'];
	$customer_city = $customer['city'];
	
?>
<div class='main'>
	<h2><?= $project_name ?></h2>
	<p><strong><?= $customer_name ?></strong></p>
	<p><?= $customer_address ?></p>
	<p><?= $customer_city ?></p>
	<hr>
	<h3>Projects</h3>
	<div class='row'>
		<div class='col-sm-4'>
<?php
	$sql_minor = "SELECT * FROM code_project WHERE major_id = '" . $major_id . "'";
	$result_minor = $conn->query($sql_minor);
	if(mysqli_num_rows($result_minor)){
?>
			<table class='table'>
				<tr>
					<th>Project name</th>
					<th>Date start</th>
					<th></th>
				</tr>
<?php
		while($minor = $result_minor->fetch_assoc()){
?>
				<tr>
					<td><?= $minor['project_name'] ?></td>
					<td><?= date('d M Y',strtotime($minor['start_date'])) ?></td>
					<td><button type='button' class='btn btn-default'>View</button>
				</tr>
<?php
		}
?>
			</table>
<?php
	} else {
?>
			<p>There is no minor project to this project</p>
<?php
	}
?>
</div>
	