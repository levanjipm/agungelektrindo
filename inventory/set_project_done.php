<?php
	include('inventoryheader.php');
?>
<div class='main'>
	<label>Project</label>
	<select class='form-control' id='projects' name='projects'>
		<option value='0'>Please select a project</option>
<?php
	$sql_project = "SELECT * FROM code_project WHERE isdone = '0'";
	$result_project = $conn->query($sql_project);
	while($project = $result_project->fetch_assoc()){
?>
		<option value='<?= $project['id'] ?>'><?= $project['project_name'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<button type='button' class='btn btn-warning' id='done_button'>Set done</button>
</div>