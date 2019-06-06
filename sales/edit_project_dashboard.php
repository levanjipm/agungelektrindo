<?php
	include('salesheader.php');
?>
<div class='main'>
	<h2>Project</h2>
	<p>Edit project</p>
	<hr>
	<label>Project</label>
	<select class='form-control' name='project'>
<?php
	$sql = "SELECT * FROM code_project WHERE major_id = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<option value='<?= $row['id'] ?>'><?= $row['project_name'] ?></option>
<?php
	}
?>
	</select>
	<div class='col-sm-2' style='padding:30px'>
		<button type='button' class='btn btn-default'>
			Add Assignment
		</button>
	</div>
	<div class='col-sm-8'>
		<table class='table table-hover'>
			<tr>
				<th>Assignment name</th>
				<th>Start date</th>
			</tr>
<?php
	$sql_table = "SELECT * FROM code_project WHERE major_id = '" . $row['id'] . "'";
	$result_table = $conn->query($sql_table);
	while($table = $result_table->fetch_assoc()){
?>
			<tr>
				<td><?= $table['project_name'] ?></td>
				<td><?= $table['start_date'] ?></td>
			</tr>
<?php
	}
?>
	</table>