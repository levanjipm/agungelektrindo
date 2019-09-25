<?php
	include('../codes/connect.php');
?>
<form action='project_validation_new' method='POST' id='project_new_form'>
	<label>Customer</label>
	<select class='form-control' name='customer' id='customer'>
		<option value='0'>Please select a customer</option>
<?php
	$sql_customer 		= "SELECT id,name FROM customer ORDER BY name ASC";
	$result_customer 	= $conn->query($sql_customer);
	while($customer 	= $result_customer->fetch_assoc()){
?>
		<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
	}
?>
	</select>
	<label>Taxing option</label>
	<select class='form-control' name='taxing' id='taxing'>
		<option value=''>Please select taxing option</option>
		<option value='1'>Tax</option>
		<option value='0'>Non-tax</option>
	</select>
	<label>Purchase Order number</label>
	<input type='text' class='form-control' name='purchase_order'>
	<label>Start Date</label>
	<input type='date' class='form-control' name='start_project' id='start_project'>
	<label>Project name</label>
	<input type='text' class='form-control' name='name_project' id='name_project'>
	<br>
	<button type='button' class='button_success_dark' id='input_project_button'>Submit</button>
</form>
<script>
	$('#input_project_button').click(function(){
		if($('#customer').val() == '0'){
			alert('Please insert a customer');
			$('#customer').focus();
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
			$('#project_new_form').submit();
		}
	});
</script>