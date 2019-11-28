<?php
	include('../codes/connect.php');
	$supplier_id	= $_POST['supplier_id'];
	$sql_supplier	= "SELECT * FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier		= $result_supplier->fetch_assoc();
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<div class='container'>
	<h2 style='font-family:bebasneue'>Edit supplier data</h2>
	<hr>
	<label>Supplier name</label>
	<input type='text' class='form-control' id='supplier_name' value='<?= mysqli_real_escape_string($conn,$supplier['name']) ?>'>
	<label>Address</label>
	<textarea class='form-control' id='supplier_address' style='resize:none'><?= $supplier['address']; ?></textarea>
	<label>City</label>
	<input type='text' class='form-control' id='supplier_city' value='<?= mysqli_real_escape_string($conn,$supplier['city']) ?>'>
	<label>Phone number</label>
	<input type='text' class='form-control' id='supplier_phone' value='<?= mysqli_real_escape_string($conn,$supplier['phone']) ?>'>
	<label>NPWP</label>
	<input type='text' class='form-control' id='supplier_npwp' value='<?= mysqli_real_escape_string($conn,$supplier['npwp']) ?>'>
	<br>
	<button type='button' class='button_success_dark' id='submit_edit_supplier_form'>Submit</button>
</div>
<script>
	$("#supplier_npwp").inputmask("99.999.999.9-999.999");
	
	$('#submit_edit_supplier_form').click(function(){
		phone_expression = /[0-9][\s\./0-9]*$/;
		if($('#supplier_name').val() == ''){
			alert("Please insert supplier's name");
			$('#supplier_name').focus();
			return false;
		} else if($('#supplier_address').val() == ''){
			alert("Please insert supplier's address");
			$('#supplier_address').focus();
			return false;
		} else if($('#supplier_city').val() == ''){
			alert("Please insert supplier's city");
			$('#supplier_city').focus();
			return false;
		} else if(!phone_expression.test($('#supplier_phone').val())){
			alert('Incorrect format phone number');
			$('#supplier_phone').focus();
			return false;
		} else {
			$.ajax({
				url:'supplier_edit.php',
				data:{
					supplier_name		: $('#supplier_name').val(),
					supplier_address	: $('#supplier_address').val(),
					supplier_city		: $('#supplier_city').val(),
					supplier_phone		: $('#supplier_phone').val(),
					supplier_npwp		: $('#supplier_npwp').val(),
					supplier_id			: <?= $supplier_id ?>,
				},
				type:'POST',
				beforeSend:function(){
					$('#submit_edit_supplier_form').attr('disabled');
				},
				success:function(){
					$('#button_close_view').click();
					setTimeout(function(){
						location.reload();
					},200);
				},
			});
		}
	});
</script>