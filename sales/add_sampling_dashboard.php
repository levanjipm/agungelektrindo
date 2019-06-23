<?php
	include('salesheader.php');
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<script>
$( function() {
	$('input[id^="reference"]').autocomplete({
		source: "ajax/search_item.php"
	 })
});
</script>
<div class='main'>
	<h2>Sample</h2>
	<p>Add sampling</p>
	<hr>
	<form action='add_sampling_validation.php' method='POST' id='add_sample_form'>
	<label>Customer</label>
	<select class='form-control' name='customer' id='customer'>
		<option value='0'>Please pick a customer</option>
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
	<hr>
	<div class='row'>
		<div class='col-sm-1'>
			No.
		</div>
		<div class='col-sm-3'>
			Reference
		</div>
		<div class='col-sm-3'>
			Quantity
		</div>
	</div>
	<hr>
<?php
	for($i=  1; $i <= 3; $i++){
?>
	<div class='row'>
		<div class='col-sm-1'>
			<?= $i ?>
		</div>
		<div class='col-sm-3'>
			<input type='text' class='form-control' id='reference<?= $i ?>' name='reference<?= $i ?>'>
		</div>
		<div class='col-sm-3'>
			<input type='number' class='form-control' name='quantity<?= $i ?>'>
		</div>
		<div class='col-sm-2' id='checking<?= $i ?>'>
		</div>
	</div>
	<br>
<?php
	}
?>
	</form>
	<hr>
	<button type='button' class='btn btn-default' onclick='submiting()'>
		Submit
	</button>
</div>
<script>
	function submiting(){
		if($('#customer').val() == 0){
			alert('Please insert a customer!');
			$('#customer').focus();
			return false;
		} else {
			$('#add_sample_form').submit();
		}
	}
</script>