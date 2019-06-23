<?php
	//Add project dashboard//
	include('salesheader.php');
?>
<div class='main'>
	<h2>Project</h2>
	<p>Add project</p>
	<hr>
<?php
	if(empty($_GET['alert'])){
		} else if($_GET['alert'] == 1){	
?>
	<div class="alert alert-success" style='position:absolute;z-index:100'>
		Input data success!
	</div>
<?php
		} else {
?>
	<div class="alert alert-danger" style='position:absolute;z-index:100'>
		Input data failed!
	</div>
<?php
		}
?>
	<div class='row'>
		<div class='col-sm-6' style='padding:30px'>
			<form action='add_project_input.php' method='POST' id='myForm'>
				<label>Customer</label>
				<select class='form-control' name='customer' id='customer'>
					<option value='0'>Please select a customer</option>
<?php
	$sql_customer = "SELECT id,name FROM customer ORDER BY name ASC";
	$result_customer = $conn->query($sql_customer);
	while($customer = $result_customer->fetch_assoc()){
?>
					<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
	}
?>
				</select>
				<label>Start Date</label>
				<input type='date' class='form-control' name='start_project' id='start_project'>
				<label>Project name</label>
				<input type='text' class='form-control' name='name_project' id='name_project'>
				<br>
				<button type='button' class='btn btn-default' id='open_modal'>Proceed</button>
			</form>
		</div>
		<div class='col-sm-6' style='padding:30px'>
			<form method='POST' action='add_project_minor.php' id='yourForm'>
				<label>Project</label>
				<select class='form-control' name='project_major' id='project_major'>
					<option value='0'>Please select an existing project</option>
<?php
	$sql_major = "SELECT * FROM code_project WHERE major_id = '0' AND isdone = '0'";
	$result_major = $conn->query($sql_major);
	while($major = $result_major->fetch_assoc()){
?>
					<option value='<?= $major['id'] ?>'><?= $major['project_name'] ?></option>
<?php
	}
?>
				</select>
				<label>Start date</label>
				<input type='date' class='form-control' name='date_exist_date' id='date_exist_date'>
				<label>Project name</label>
				<input type='text' class='form-control' name='name_exist_date' id='name_exist_date'>
				<br>
				<button type='button' class='btn btn-default' id='open_exist_modal'>Add project on existing</button>
			</form>
		</div>
	</div>		
</div>
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 id='project_name_modal'></h4>
				<p id='customer_name_modal'></p>
				<p id='date_start_modal'></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick='submiting()'>Proceed</button>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="exist_modal" tabindex="-1" role="dialog" aria-labelledby="exist_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 id='header_modal'></h4>
				<p id='project_name_exist_modal'></p>
				<p id='date_start_exist_modal'></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick='submiting_else()'>Proceed</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		setTimeout(function(){
			$('.alert').fadeOut();
		},1000)
	});
	document.getElementById("myForm").onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;     
		if (key == 13) {
			e.preventDefault();
		}
	}
	document.getElementById("yourForm").onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;     
		if (key == 13) {
			e.preventDefault();
		}
	}
	$('#open_modal').click(function(){
		if($('#customer').val() == 0){
			alert('Please insert a customer');
			$('#customer').focus();
			return false;
		} else if($('#start_project').val() == ''){
			alert('Please insert start date!');
			$('#start_project').focus();
			return false;
		} else if($('#name_project').val() == '' || $('#name_project').val().length < 8){
			alert('Please insert valid project name!');
			$('#name_project').focus();
		} else {
			var customer_name = $('#customer option:selected').text();
			var date_start = $('#start_project').val();
			var project_name = $('#name_project').val();
			$('#project_name_modal').html(project_name);
			$('#customer_name_modal').html(customer_name);
			$('#date_start_modal').html(date_start);
			$('#myModal').modal();
		}
	});
	$('#open_exist_modal').click(function(){
		if($('#project_major').val() == 0){
			alert('Please insert an existing project');
			$('#project_major').focus();
			return false;
		} else if($('#date_exist_date').val() == ''){
			alert('Please insert start date!');
			$('#date_exist_date').focus();
			return false;
		} else if($('#name_exist_date').val() == '' || $('#name_exist_date').val().length < 8){
			alert('Please insert valid project name!');
			$('#name_exist_date').focus();
		} else {
			var major_name = $('#project_major option:selected').text();
			var date_start_exist = $('#date_exist_date').val();
			var project_name_new = $('#name_exist_date').val();
			$('#project_name_exist_modal').html(project_name_new);
			$('#header_modal').html(major_name);
			$('#date_start_exist_modal').html(date_start_exist);
			$('#exist_modal').modal();
		}
	});
	function submiting_else(){
		$('#yourForm').submit();
	}
	function submiting(){
		$('#myForm').submit();
	}
</script>