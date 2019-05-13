<?php
	//Add project dashboard//
	include('salesheader.php');
?>
<div class='main'>
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
	<form action='add_project_input.php' method='POST' id='myForm'>
		<div class='row'>
			<div class='col-sm-3'>
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
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-3'>
				<label>Start Date</label>
				<input type='date' class='form-control' name='start_project' id='start_project'>
			</div>
		</div>
		<div class='row'>
			<div class='col-sm-6'>
				<label>Project name</label>
				<input type='text' class='form-control' name='name_project' id='name_project'>
			</div>
		</div>
		<div class='row' style='padding-top:30px'>
			<div class='col-sm-6'>
				<button type='button' class='btn btn default' id='open_modal'>Proceed</button>
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
	</form>
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
	$('#open_modal').click(function(){
		if($('#customer').val() == 0){
			alert('Please insert a customer');
			$('#customer').focus();
			return false;
		} else if($('#start_project').val() == ''){
			alert('Please insert start date!');
			$('#start_project').focus();
			return false;
		} else if($('#name_project').val() == '' || $('#name_project').val().length < 10){
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
	function submiting(){
		$('#myForm').submit();
	}
</script>