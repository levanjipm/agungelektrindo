<?php
	include('../codes/connect.php');
?>
<form action='project_validation_exist' method='POST' id='project_existing_form'>
	<label>Project</label>
	<select class='form-control' name='project' id='project'>
		<option value='0'>Please select a project</option>
<?php
	$sql_project 		= "SELECT id,project_name FROM code_project WHERE major_id = '0'  AND isdone = '0' ORDER BY project_name ASC";
	$result_project 	= $conn->query($sql_project);
	while($project	 	= $result_project->fetch_assoc()){
?>
		<option value='<?= $project['id'] ?>'><?= $project['project_name'] ?></option>
<?php
	}
?>
	</select>
	<label>Start Date</label>
	<input type='date' class='form-control' name='start_project' id='start_project'>
	<label>Project name</label>
	<input type='text' class='form-control' name='name_project' id='name_project'>
	<label>Project description</label>
	<textarea class='form-control' style='resize:none' rows='5' name='description_project'></textarea>
	<br>
	<button type='button' class='button_success_dark' id='input_project_button'>Proceed</button>
</form>
<script>
	$('#input_project_button').click(function(){
		if($('#project').val() == '0'){
			alert('Please insert an existing project');
			$('#project').focus();
			return false;
		} else if($('#taxing').val() == ''){
			alert('Please insert a taxing option');
			$('#taxing').focus();
			return false;
		} else if($('#start_project').val() == ''){
			alert('Please insert start date');
			$('#start_project').focus();
			return false;
		} else if($('#name_project').val() == ''){
			alert('Please insert project name');
			$('#name_project').focus();
			return false;
		} else {
			$('#project_existing_form').submit();
		}
	});
</script>