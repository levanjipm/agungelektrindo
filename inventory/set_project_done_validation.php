<?php
	include('inventoryheader.php');
	$code_project_id = $_POST['projects'];
	$sql_project = "SELECT * FROM code_project WHERE id = '" . $code_project_id . "'";
	$result_project = $conn->query($sql_project);
	$project = $result_project->fetch_assoc();
	
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p>Set project done</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<td>Project name</td>
			<td><?= $project['project_name'] ?></td>
			<td rowspan='3' style='text-align:justify'>
				<strong>Description</strong><br>
				<?= $project['description'] ?>
			</td>
		</tr>
		<tr>
			<td>Initiated by</td>
			<td><?php
				$sql_initiated = "SELECT name FROM users WHERE id = '" . $project['created_by'] . "'";
				$result_initiated = $conn->query($sql_initiated);
				$initiated = $result_initiated->fetch_assoc();
				echo $initiated['name'];
			?></td>
		</tr>
		<tr>
			<td>Initiated date</td>
			<td><?= date('d M Y',strtotime($project['start_date'])) ?></td>
		</tr>
		<tr>
			<td>Customer</td>
			<td colspan='2'><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $project['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
		</tr>
	</table>
	<div class='row'>
		<div class='col-sm-10'>
			<h3 style='font-family:bebasneue'>Corresponding Delivery Order -- project</h3>
		</div>
		<div class='col-sm-2'>
			<button type='button' class='btn btn-default' id='hide_button'>Hide</button>
		</div>
	</div>
	<hr>
	<div class='row'>
		<div class='col-sm-7'>
<?php
	$sql_do = "SELECT * FROM project_delivery_order WHERE project_id = '" . $code_project_id . "'";
	$result_do = $conn->query($sql_do);
	while($do = $result_do->fetch_assoc()){
?>
			<div class='col-sm-4' style='padding:10px;text-align:center'>
				<div style='cursor:pointer'>
					<h1 style='font-size:6em'><i class="fa fa-file-code-o" aria-hidden="true"></i></h1>
					<?= $do['name'] ?>
					<?= date('d M Y',strtotime($do['date'])) ?>
				</div>
			</div>
<?php
	}
?>
		</div>
		<div class='col-sm-5'>
		</div>
	</div>
</div>