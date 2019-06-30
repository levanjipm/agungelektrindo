<?php
	include('hrheader.php');
?>
<style>
	.forming{
		border:none;
		border-bottom:2px solid #777;
		background-color:transparent;
	}
	.forming:focus{
		outline-width: 0;
	}
	.btn-form{
		width:100%;
		background-color:transparent;
		border:none;
	}
</style>	
<div class="main">
	<form id="input_user" method="POST" action="add_user_input.php">
		<div class='container' style='border-radius:20px;background-color:#eee;padding:0px'>
			<div class='row'>
				<div class='col-sm-6'>
					<h3 id="demo"></h3>
					<input type='text' class='forming' placeholder='Insert name' name='name' required>
					<div class='col-sm-6' style='padding:0px'>
						<input type='text' class='forming' placeholder='Insert NIK' name='nik' required>
					</div>
					<div class='col-sm-6'>
						<input type='text' class='forming' placeholder='Insert username' name='username' required>
					</div>
					<input type='text' class='forming' placeholder='Insert address' name='address' required>
					<input type='text' class='forming' placeholder='Insert city' name='city' required>
					<input type='text' class='forming' placeholder='Insert bank account number' name='bank' required>
					<input type='text' class='forming' placeholder='Insert mail address' name='mail' required>
					<div class="groups">
						<input type='password' class='forming' placeholder='Password' style='width:90%' id='pwd' name='pwd' required minlength="8">
						<span style='width:10%'>
							<button type='button' class='btn-form' onmouseover='show_pwd()' onmouseout='hide_pwd()'><i class="fa fa-eye" aria-hidden="true"></i></button>
						</span>
					</div>
					<script>
						function show_pwd(){
							$('#pwd').attr('type', 'text');
						}
						function hide_pwd(){
							$('#pwd').attr('type','password');
						}
					</script>
					<style>
						.btn-submit{
							padding:10px;
							background-color:transparent;
							border:2px solid #555;
							border-radius:5px;
							transition:0.3s all ease;
						}
						.btn-submit:hover{
							background-color:rgba(115,115,115,0.3);
						}
					</style>
					<div class='col-sm-12' style='padding-top:30px'>
						<button type='submit' class='btn-submit'>Submit</button>
					</div>
				</div>
			</div>
			
		</div>
		
	</form>
</div>
<script>
$(document).ready(function(){
	typeWriter();
});
var i = 0;
var txt = 'Add new user'; /* The text */
var speed = 50; /* The speed/duration of the effect in milliseconds */
function typeWriter() {
  if (i < txt.length) {
    document.getElementById("demo").innerHTML += txt.charAt(i);
    i++;
    setTimeout(typeWriter, speed);
  }
}
function validate_password(){
	var pas1 = $('#password1').val();
	var pas2 = $('#password2').val();
	if (pas1 == pas2){
		$('#input_user').submit();
	} else {
		alert('please check the password');
	}
};
</script>