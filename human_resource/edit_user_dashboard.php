<head>
<title>Account Control</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="user_dashboard.css">
</head>
<?php
include('../codes/connect.php');
session_start();

$sql_user = "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
$result_user = $conn->query($sql_user);
$row_user 	= $result_user->fetch_assoc();
$user_id 	= $row_user['id'];
$mail 		= $row_user['mail'];
$name 		= $row_user['name'];
$bank 		= $row_user['bank'];
$address 	= $row_user['address'];
$city 		= $row_user['city'];
$user_name	= $row_user['username'];
$profile_pic	= $row_user['image_url'];
if($profile_pic == ''){
	$profile_pic = 'images/users/users.png';
} else {
	$profile_pic	= $row_user['image_url'];
}

if($_SESSION['user_id'] === NULL){
	header('location:../landing_page.php');
}
?>
<body style='overflow-x:hidden'>
<div class='top_navigation_bar'>
	<div class='col-lg-4 col-md-5 col-sm-6 col-xs-8'>
		<a href='../human_resource/user_dashboard.php' style='text-decoration:none'>
			<img src='../universal/images/agungelektrindo_header.png' style='height:50px;'>
		</a>
	</div>
	<div class='col-lg-2 col-md-3 col-sm-4 col-xs-4 col-lg-offset-6 col-md-offset-4 col-sm-offset-2 col-xs-offset-0' style='text-align:right'>
		<h3 style='font-family:Bebasneue'><?= $name ?> 
			<span style='display:inline-block'>
				<a href='../codes/logout.php' style='padding-left:10px;text-decoration:none;color:white;' title='log out'>
					 <i class="fa fa-sign-out" aria-hidden="true"></i>
				</a>
			</span>
		</h3>
	</div>
</div>
<div class="sidenav">
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-id-badge" aria-hidden="true"></i>
		Departments
	</button>
	<div class="dropdown-container">
	<?php
	$sql_super 			= "SELECT * FROM authorization WHERE user_id = '" . $user_id . "'";
	$result_super 		= $conn->query($sql_super);
	while($row_super 	= $result_super->fetch_assoc()){
		$department 	= $row_super['department_id'];
		$sql_dept 		= "SELECT department FROM departments WHERE id = '" . $department . "'";
		$result_dept	= $conn->query($sql_dept);
		$row_dept 		= $result_dept->fetch_assoc();
		$department 	= $row_dept['department'];
		?>
			<a href='../<?= $department ?>/<?= $department ?>.php' style='color:white;text-decoration:none'>
				<?= $department ?>
			</a>
			<br>
		<?php
			}
		?>
		</div>
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-plus-circle" aria-hidden="true"></i>
			Create
		</button>
		<div class='dropdown-container'>
			<button type='button' style='background-color:transparent;border:none;color:white;text-decoration:none' id='create_events'>Create event</button>
			<br>
			<button type='button' style='background-color:transparent;border:none;color:white;text-decoration:none' id='create_anon'>Create announcement</button>
		</div>
		<a href='../codes/logout.php'>
			<button type='button' class='btn btn-badge' style='color:white'>
			<i class="fa fa-sign-out" aria-hidden="true"></i>
			Log Out
			</button>
		</a>
		<script>
			var dropdown = document.getElementsByClassName("dropdown-btn");
			var i;

			for (i = 0; i < dropdown.length; i++) {
				dropdown[i].addEventListener("click", function() {
					this.classList.toggle("active");
					var dropdownContent = this.nextElementSibling;
					if (dropdownContent.style.display === "block") {
						dropdownContent.style.display = "none";
					} else {
						dropdownContent.style.display = "block";
					}
				});
			}
		</script>
</div>
<style>
	#profile_picture_input{
		width:0;
		height:0;
	}
	
	#profile_picture_button{
		text-align:center;
		width:100%;
		max-width:250px;
		cursor:pointer;
	}
</style>
<div class="main">
	<div class='row'>
		<div class='col-xs-12'>
			<h2 style='font-family:bebasneue'>User</h2>
			<p>Edit user</p>
			<hr>
		</div>
		<div class='col-sm-4 col-xs-4 col-sm-offset-1 col-xs-offset-4' style='text-align:center'>
			<img src='<?= $profile_pic ?>' style='width:100%;max-width:150px;border-radius:50%' id='profile_picture_image'>
			<br><br>
			<label class='button_default_dark' id='profile_picture_button'>
				<input type='file' name='profile_picture' id='profile_picture_input' accept="image/x-png,image/gif,image/jpeg">
				Upload Image
			</label>
		</div>
		<div class='col-sm-6 col-xs-10 col-sm-offset-0 col-xs-offset-1'>
			<form id='edit_user_form'>
				<h3 style='font-family:bebasneue'>Profile Information</h3>
				<label>Email</label>
				<input type='text' class='form-control' id='email' value='<?= $mail ?>'>
				<label>Address</label>
				<textarea class='form-control' style='resize:none' id='address'><?= $address ?></textarea>
				<label>City</label>
				<input type='text' class='form-control' id='city' value='<?= $city ?>'>
				<label>Bank</label>
				<input type='text' class='form-control' id='bank' value='<?= $bank ?>'>
				<label>Password</label>
				<input type='password' class='form-control' id='password'>
			</form>
		</div>
	</div>
	<div class='row' style='padding-top:40px'>
		<div class='col-xs-12' style='text-align:center'>
			<button type='button' class='button_default_dark' id='submit_profile_button'>Submit</button>
		</div>
	</div>
</div>
<script>
	$('#profile_picture_input').change(function(){
		formdata = new FormData();
		if($(this).prop('files').length > 0){
			file =$(this).prop('files')[0];
			formdata.append('<?= $user_id ?>', file);
			$.ajax({
				url: 'change_profile_picture.php',
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (result) {
					$('#profile_picture_image').attr('src',result);
				}
			})
		}
	});
	
	$('#submit_profile_button').click(function(){
		var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
		var email = $('#email').val();
		
		if(!pattern.test(email)){
			alert('Please insert a valid email');
			return false;
		} else {
			$.ajax({
				url:'edit_profile.php',
				data:{
					email: $('#email').val(),
					address: $('#address').val(),
					city: $('#city').val(),
					bank: $('#bank').val(),
					password: $('#password').val(),
				},
				type:'POST',
			});
		}
	});
</script>