<?php
	include('hrheader.php');
?>	
<style>
	.box_user{
		padding:20px;
		margin-top:5px;
	}
	.inside_box{
		padding:10px;
		border:3px solid #eee;
		text-align:center;
		transition:0.3s all ease;
	}
	.inside_box:hover{
		background-color:#ddd;
	}
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:10%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
	.context_box{
		position:absolute;
		z-index:20;
		padding:10px;
		display:none;
		background-color:white;
		box-shadow: 3px 4px 3px 4px #888888;
	}
	.btn-context{
		width:100%;
		background-color:transparent;
		color:#333;
		padding:10px 20px;
	}
	.btn-context:hover{
		background-color:blue;
	}
</style>
<div class="main">
	<h2 style='font-family:bebasneue'>Users</h2>
	<hr>
<?php
	$sql_user = "SELECT * FROM users ORDER BY name ASC";
	$result_user = $conn->query($sql_user);
	while($user = $result_user->fetch_assoc()){
?>
	<div class='col-sm-3 box_user'>
		<div class='inside_box'>
			<h3 style='font-family:bebasneue'><?= $user['name'] ?></h3>
			<p><?= $user['username'] ?></p>
			<?= $user['role'] ?>
		</div>
	</div>
<?php
	}
?>
	<div class='context_box'>
		<button type='button' class='btn btn-context'>
			<span style='width:30%;float:left'>
				<i class="fa fa-eye" aria-hidden="true"></i>
			</span>
			<span style='width:70'>
				View
			</span>
		</button>
		<button type='button' class='btn btn-context'>
			<span style='width:30%;float:left'>
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</span>
			<span style='width:70'>
				Edit
			</span>
		</button>
	</div>
<script>
$('.box_user').contextmenu(function() {
	var currentMousePos = { x: -1, y: -1 };
	currentMousePos.x = event.pageX;
	currentMousePos.y = event.pageY;
	$('.context_box').css('left',currentMousePos.x);
	$('.context_box').css('top',currentMousePos.y);
	$('.context_box').fadeIn();
	event.preventDefault();
});
</script>
	<div class='col-sm-3 box_user' onclick='show_new_user_form()' style='cursor:pointer'>
		<div class='inside_box'>
			<h1><i class="fa fa-plus" aria-hidden="true"></i></h1>
		</div>
	</div>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-user-plus" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>New user</h2>
		<form id="input_user" method="POST" action="add_user_input.php" id='add_user_form'>
			<div class='row'>
				<div class='col-sm-8 col-sm-offset-2'>
					<div id='form1'>
						<input type='text' class='form-control' placeholder='Insert name' name='name' required>
						<br>
						<div class='input-group'>
							<input type='text' class='form-control' placeholder='Insert NIK' name='nik' required style='width:50%'>
							<input type='text' class='form-control' placeholder='Insert username' name='username' required style='width:50%'>
						</div>
						<br>
						<textarea class='form-control' placeholder='Insert address' name='address' rows='3' form='add_user_form' required></textarea>
						<br>
						<input type='text' class='form-control' placeholder='Insert city' name='city' required>
						<br>
						<button type='button' class='btn btn-back' id='back_button'>Back</button>
						<button type='button' class='btn btn-confirm' id='next_button'>Next</button>
					</div>
					<div id='form2' style='display:none'>
						<input type='text' class='form-control' placeholder='Insert bank account number' name='bank' required>
						<br>
						<input type='text' class='form-control' placeholder='Insert mail address' name='mail' required>
						<br>
						<input type='password' class='form-control' placeholder='Password' id='pwd' name='pwd' required minlength="8">
						<br>
						<button type='button' class='btn btn-back' id='prev_button'>Back</button>
						<button type='button' class='btn btn-confirm' id='submit_button'>Next</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
function show_new_user_form(){
	$('.notification_large').fadeIn();
};
$('#back_button').click(function(){
	$('.notification_large').fadeOut();
});
$('#next_button').click(function(){
	$('#form1').fadeOut(300);
	setTimeout(function(){
		$('#form2').fadeIn();
	},310);
});
$('#prev_button').click(function(){
	$('#form2').fadeOut(300);
	setTimeout(function(){
		$('#form1').fadeIn();
	},310);
});
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