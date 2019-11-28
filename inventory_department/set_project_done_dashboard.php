<?php
	include('inventoryheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p>Set project done</p>
	<hr>
	<label>Project</label>
	<form action='set_project_done_validation.php' method='POST' id='set_project_done_form'>
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
	</form>
	<br>
	<button type='button' class='btn btn-default' id='done_button'>Set done</button>
</div>
<script>
	$('#done_button').click(function(){
		if($('#projects').val() == 0){
			alert('Please insert valid project!');
			return false;
		} else {
			$('#set_project_done_form').submit();
		}
	});
</script>
