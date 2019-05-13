<?php
	if(empty($_POST['user_id'])){
		header('location:human_resource.php');
	}
	$user_id_edit = $_POST['user_id'];
	include('hrheader.php');
?>
<style>
.box__dragndrop,
.box__uploading,
.box__success,
.box__error {
  display: none;
}
.groups{
		width:100%;
		white-space: nowrap;
		display: inline-block;
	}
	.groups span, .groups input{
		display: inline-block;
	}
	.switch {
		position: relative;
		display: inline-block;
		width: 60px;
		height: 34px;
	}
	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}
	
	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>
<div class='main'>
	<form class="box" method="post" action="" enctype="multipart/form-data">
		<label>Change profile picture</label>
		<input type='file' class='form-control'>
		<table class='table table-hover'>
			<tr>
				<th style='width:30%'>Department</th>
				<th style='width:70%'>Authorization</th>
			</tr>
<?php
	$sql_department = "SELECT id,department FROM departments";
	$result_department = $conn->query($sql_department);
	while($department = $result_department->fetch_assoc()){
?>
			<tr>
				<td><?= $department['department']?></td>
				<td>
					<div class='groups'>
						<span style='width:10%'>
							<label class="switch">
<?php
	$sql_otorisasi = "SELECT * FROM otorisasi WHERE user_id = '" . $user_id_edit . "' AND department_id = '" . $department['id'] . "'";
	$result_otorisasi = $conn->query($sql_otorisasi);
	if($result_otorisasi){
?>
								<input type="checkbox" id='dept<?= $department['id'] ?>'>
								<span class="slider round"></span>
<?php
	} else {
?>
								<input type="checkbox" checked id='dept<?= $department['id'] ?>'>
								<span class="slider round"></span>
<?php
	}
?>		
							</label>
						</span>	
					</div>
				</td>
			</tr>
<?php
	}
?>
	</table>
	<button type='button' class='btn btn-default' onclick='otorisasi()'>Next</button>
	</form>
</div>
<script>
	function otorisasi(){
		$('input[id^=dept]').each(function(){
			console.log($(this).prop('checked'))
		})
	}
</script>