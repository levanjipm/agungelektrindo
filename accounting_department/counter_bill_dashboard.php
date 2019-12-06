<?php
	include('accountingheader.php');
?>
<div class='main'>
	<script>
		function submiting_form(){
			$('#counter_bill_form').submit();
		}
	</script>
	<h2 style='font-family:bebasneue'>Counter Bill</h2>
	<p>Create counter bill</p>
	<hr>
		<div class='input-group'>
			<select class='form-control' style='width:80%' id='customer_select'>
				<option value='0'>Please select a customer</option>
<?php
	$sql = "SELECT id,name FROM customer ORDER BY name ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
				<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
	}
?>
			</select>
			<div class="input-group-append">
				<button type='button' class='btn btn-secondary' id='search_cusutomer_button'>
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<br><br>
	<form action='counter_bill_validation.php' method='POST' id='counter_bill_form'>
		<div id='invoices_input'></div>
	</form>
</div>
<script>
	$('#search_cusutomer_button').click(function(){
		if($('#customer_select').val() == 0){
			alert('Please insert a customer');
			return false;
		} else {
			$.ajax({
				url:'search_invoices_counter.php',
				data:{
					customer : $('#customer_select').val()
				},
				type:'POST',
				success: function(response){
					$('#invoices_input').html(response);
				},
			})
		}
	});
</script>
