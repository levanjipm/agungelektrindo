<?php
	include('salesheader.php');
?>
<div class='main'>
	<h2>Project</h2>
	<p>Edit project</p>
	<hr>
	<div class='row'>
		<div class='col-sm-10'>
			<label>Project</label>
			<select class='form-control' id='project_id' onchange='view_project()'>
				<option value='0'>Please pick a project</option>
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
		</div>
		<div class='col-sm-2'>
			<label>Properties</label><br>
			<button type='button' class='btn btn-default' id='major_button'>View Major</button>
		</div>
		<form action='project_major_view.php' method='POST' id='project_major_form'>
			<input type='hidden' id='major_id' name='major_id'>
		</form>
		<script>
			$('#major_button').click(function(){
				$('#major_id').val($('#project_id').val());
				$('#project_major_form').submit();
			});
		</script>
	</div>
	<br><br>
	<div class='col-sm-8' id='project_minor'>
	</div>
</div>
<script>
	function view_project(){
		$.ajax({
			url:"view_project.php",
			data:{
				project_major : $('#project_id').val(),
			},
			type:"POST",
			success:function(response){
				$('#project_minor').html(response);
			},
		})
	};
</script>