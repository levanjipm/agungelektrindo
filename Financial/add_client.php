<?php
	include('financialheader.php');
?>
<div class='main'>
	<form action='add_client_input.php' method='POST' id='form_client'>
		<label>Name</label>
		<input type='text' class='form-control' id='nama' name='nama'>
		<br><br>
		<button type='button' class='btn btn-default' onclick='validate()'>Submit</button>
	</form>
</div>
<script>
function validate(){
	var input = document.getElementById('nama').value;
	var letters = /^[A-Za-z0-9]+$/;
	if (input == ''){
		alert('Please insert name!')
	} else if(input.match(letters)){
		$('#form_client').submit();
	} else {
		alert('Input does not met the pattern criteria');
	}
}
</script>