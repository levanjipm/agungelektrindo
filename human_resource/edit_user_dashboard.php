<head>
<title>Account Control</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="user_dashboard.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<?php
include('../codes/connect.php');
session_start();
$sql_user = "SELECT * FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
$result_user = $conn->query($sql_user);
while($row_user = $result_user->fetch_assoc()){
	$user_id = $row_user['id'];
	$mail = $row_user['mail'];
	$name = $row_user['name'];
	$bank = $row_user['bank'];
	$address = $row_user['address'];
	$city = $row_user['city'];
};
if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
?>
<body style='overflow-x:hidden'>
<div class="sidenav">
		<div class='row'>
			<div class='col-sm-12 col-md-6'>
				<img src='images/users/users.png' style='width:100%; border-radius:50%'>
			</div>
			<div class='col-sm-12 col-md-6' style='color:white'>
				<strong>Welcome</strong>
				<p><?= $name ?></p>
			</div>
		</div>				
		<hr>
		<style>
			.btn-badge{
				background-color:transparent;
				color:white;
				width:100%;
				text-align:left;
			}
			.dropdown-container {
				display: none;
				background-color: #262626;
				padding-left: 8px;
				line-height:2.5;
			}
		</style>
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-id-badge" aria-hidden="true"></i>
			Departments
		</button>
		<div class="dropdown-container">
		<?php
		$sql_super = "SELECT * FROM otorisasi WHERE user_id = '" . $user_id . "'";
		$result_super = $conn->query($sql_super);
		while($row_super = $result_super->fetch_assoc()){
			$department = $row_super['department_id'];
			$sql_dept = "SELECT department FROM departments WHERE id = '" . $department . "'";
			$result_dept = $conn->query($sql_dept);
			while($row_dept = $result_dept->fetch_assoc()){
				$department = $row_dept['department'];
			}
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
	<div id="myModal" class="modal">
			<div class="modal-content">
			<span class="close" id='close_anon'>&times;</span>
			<form action='create_announcement.php' method='POST'>
				<h2>Create new Announcement</h2>
				<label>Date</label>
				<input type='date' class='form-control' name='announcement_date' required min='<?= date('Y-m-d') ?>'>
				<label>Event name</label>
				<input type='text' class='form-control' name='event' required>
				<br><br>
				<button type='submit' class='btn btn-success'>Submit</button>
			</form>
			</div>
		</div>
		<div id="modal_events" class="modal">
			<div class="modal-content">
			<span class="close" id='close_remind'>&times;</span>
			<form action='add_calendar.php' method='POST' id='form_calendar'>
				<h2>Create reminder</h2>
				<input type='hidden' value="<?= $_SESSION['user_id'] ?>" name='maker'>
				<label>Date</label>
				<input type='date' class='form-control' required min='<?= date('Y-m-d') ?>' name='event_date'>
				<label>Event name</label>
				<input type='text' class='form-control' required name='event_name'>
				<label>Event Description</label>
				<textarea id="form7" class="md-textarea form-control" rows="3" name='description'></textarea>
				<br><br>
				<button type='submit' class='btn btn-success'>Submit</button>
			</form>
			</div>
		</div>
	<script>
		var modal = document.getElementById('myModal');
		var btn = document.getElementById("create_anon");
		var span_modal = document.getElementById("close_anon");
		btn.onclick = function() {
		  modal.style.display = "block";
		}
		span_modal.onclick = function() {
		  modal.style.display = "none";
		}
		window.onclick = function(event) {
		  if (event.target == modal) {
			modal.style.display = "none";
		  }
		}
		var modalbaru = document.getElementById('modal_events');
		var tombol = document.getElementById("create_events");
		var silang = document.getElementById("close_remind");
		tombol.onclick = function() {
		  modalbaru.style.display = "block";
		}
		silang.onclick = function() {
		  modalbaru.style.display = "none";
		}
		window.onclick = function(event) {
		  if (event.target == modalbaru) {
			modalbaru.style.display = "none";
		  }
		}
	</script>
	<style>
	.container {
	padding:0px 0px 25px;
	  position: relative;
	  width: 100%;
	}
	.container img {
	  width: 100%;
	  height: auto;
	  opacity:0.3
	}

	.container .btn {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		-ms-transform: translate(-50%, -50%);
		background-color: transparent;
		border:2px #333 solid;
		color: black;
		font-size: 16px;
		padding: 12px 24px;
		cursor: pointer;
		border-radius: 5px;
		text-align: center;
		transition:0.3s all ease;
	}
	.container .btn:hover {
		color:white;
		background-color: black;
	}
	</style>
	<div class="main">
		<div class="row" style='margin-top:0;padding-top:0;box-shadow: 5px 10px 3px #888888;border:1px solid #eee'>
			<br><br>
				<div class='col-sm-12' style='padding:0px'>
					<div class='container'>
						<img src='../universal/images/profile.jpg' style='width:100%'>
						<button class="btn" onclick='submitform()'>Submit changes</button>
					</div>
				</div>
				<script>
					function submitform(){
						$('#edituser').submit();
					}
				</script>
				<div class='container'>
					<div class='col-sm-6'>
					<form action='edit_user.php' method='POST' id='edituser'>
						<input type='hidden' value='<?= $_SESSION['user_id']; ?>' name='id'>
						<label>Name</label>
						<input type='text' class='form-control' name='name' value='<?= $name ?>'>
						<label>Email</label>
						<?php
						if(empty($_GET['email'])){
						?>
						<input type='text' class='form-control' value='<?= $mail ?>' name='mail'>
						<?php
						} else {
						?>
						<div class="form-group has-error has-feedback">
							<input type="text" class="form-control" id="inputError" name='mail'>
							<span class="glyphicon glyphicon-remove form-control-feedback"></span>
						</div>
						<?php
						}
						?>
						<label>Password</label>
						<?php
						if(empty($_GET['password'])){
						?>
						<input type='password' class='form-control' name='pwd'>
						<?php
						} else {
						?>
						<div class="form-group has-error has-feedback">
							<input type='password' class='form-control' name='pwd' id="inputError">
							<span class="glyphicon glyphicon-remove form-control-feedback"></span>
						</div>
						<?php
						}
						?>
					</div>
					<div class='col-sm-6'>
						<label>Nomor rekening</label>
						<?php
						if(empty($_GET['bank'])){
						?>
						<input type='text' class='form-control' value='<?= $bank ?>' name='bank'>
						<?php
						} else {
						?>
						<div class="form-group has-error has-feedback">
							<input type="text" class="form-control" id="inputError" name='bank'>
							<span class="glyphicon glyphicon-remove form-control-feedback"></span>
						</div>
						<?php
						}
						?>
						<label>Address</label>
						<input type='text' class='form-control' value='<?= $address ?>' name='address' required>
						<label>City</label>
						<input type='text' class='form-control' value='<?= $city ?>' name='city'>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		.btn-edit-user{
			background-color:transparent;
			border:2px #333 solid;
			transition:0.3 all ease;
		}
		.btn-edit-user:hover{
			background-color:#111;
		}
	</style>
