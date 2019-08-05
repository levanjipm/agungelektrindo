<head>
<title>Account Control</title>
<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<script src='../universal/jquery/typeahead.bundle.js'></script>
<link rel="stylesheet" href="../universal/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="../universal/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../universal/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../universal/bootstrap/3.3.7/css/bootstrap.min.css">
<script src='../universal/Jquery/jquery-tagsinput-revisited-master/src/jquery.tagsinput-revisited.js'></script>
<link rel="stylesheet" href="../universal/Jquery/jquery-tagsinput-revisited-master/src/jquery.tagsinput-revisited.css">
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<link rel="stylesheet" href="user_dashboard.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
<?php
	//User dashboard :D//
	include('../Codes/connect.php');
	session_start();
	$animation = $_GET['style'] ?? "";
	ini_set('date.timezone', 'Asia/Jakarta');
	
	$sql_user = "SELECT id,role,username,name,mail,privilege FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
	$result_user = $conn->query($sql_user);
	$row_user = $result_user->fetch_assoc();
	$user_id = $row_user['id'];
	$username = $row_user['username'];
	$name = $row_user['name'];
	$role = $row_user['role'];
	$privilege = $row_user['privilege'];
	if($_SESSION['user_id'] === NULL){
		header('location:../landing_page.php');
	}
	//Apabila pertama kali buka dari login, tampilkan animasi//
	if($animation == 'animate'){
?>
	<div class='welcome_wrapper'>
		<div class='welcome'>
			<h2 style='font-family:bebasneue;color:white'>Welcome <?= $name ?></h2>
		</div>
	</div>
	<script>
		function show_menu_user(){
			$('.dropdown-content').show();
		}
		function close_menu_user(){
			$('.dropdown-content').hide();
		}
		$(document).ready(function(){
			setTimeout(function() {
			$('.welcome_wrapper').fadeOut(1000);
			},1500);
		});
		$(document).ready(function(){
			setTimeout(function() {
			$('#dept').fadeIn(1000);
			},3000);
		});
	</script>
<?php
	//Apabila masuk dari department, tidak perlu tampilkan animasi//
	} else {
?>
	<script>
	function show_menu_user(){
		$('.dropdown-content').show();
	}
	function close_menu_user(){
		$('.dropdown-content').hide();
	}
	$(document).ready(function(){
		$('#dept').fadeIn(1000);
	});
</script>
<?php
	}
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
		display:none;
		z-index:20;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
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
</style>
	<!-- Side bar, user data -->
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
		<button type='button' class='btn btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-id-badge" aria-hidden="true"></i>
			Departments
		</button>
		<div class="dropdown-container">
		<?php
		$sql_super = "SELECT * FROM authorization WHERE user_id = '" . $user_id . "'";
		$result_super = $conn->query($sql_super);
		while($row_super = $result_super->fetch_assoc()){
			$department = $row_super['department_id'];
			$sql_dept = "SELECT department FROM departments WHERE id = '" . $department . "'";
			$result_dept = $conn->query($sql_dept);
			$row_dept = $result_dept->fetch_assoc();
			$department = $row_dept['department'];
			
		?>
			<a href='../<?= $department ?>/<?= $department ?>.php' style='color:white;text-decoration:none'>
				<?php $department_name = ($department == 'human_resource')? 'Human resource' : $department; echo $department_name; ?>
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
			<button type='button' style='background-color:transparent;border:none;color:white;text-decoration:none' id='create_news'>Create event</button>
			<br>
			<button type='button' style='background-color:transparent;border:none;color:white;text-decoration:none' id='create_anon'>Create announcement</button>
		</div>
		<a href='../guide/tutorial.php'>
			<button type='button' class='btn btn-badge' style='color:white'>
			<i class="fa fa-graduation-cap" aria-hidden="true"></i>
			Read Tutorial
			</button>
		</a>
		<a href='../codes/logout.php'>
			<button type='button' class='btn btn-badge' style='color:white'>
			<i class="fa fa-sign-out" aria-hidden="true"></i>
			Log Out
			</button>
		</a>
		<script>
		$('.dropdown-btn').click(function(){
			if($(this).next().is(':visible')){
				$(this).css('color','white');
			} else {
				$(this).css('color','#00ccff');
			}
			$(this).next().toggle(350);
		});
		</script>
	</div>
	<div class='notification_large' id='announcement_notification'>
		<div class='notification_box'>
			<h2 style='font-family:bebasneue'>Create new Announcement</h2>
			<label>Date</label>
			<input type='date' class='form-control' name='announcement_date' min='<?= date('Y-m-d') ?>'>
			<label>Event name</label>
			<input type='text' class='form-control' name='event' required>
			<br><br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button_announcement'>Confirm</button>
		</div>
	</div>
	<div class='notification_large' id='news_notification'>
		<div class='notification_box'>
			<h2 style='font-family:bebasneue'>Create new News</h2>
			<label>Date</label>
			<input type='date' class='form-control' name='announcement_date' min='<?= date('Y-m-d') ?>'>
			<label>News name</label>
			<input type='text' class='form-control' name='event' required>
			<br><br>
			<label>Tag</label>
			<input id="tag" name="example" type="text">
			<?php
				$tag = '';
				$sql_tag = "SELECT name FROM users";
				$result_tag = $conn->query($sql_tag);
				$row_tag = $result_tag->fetch_assoc();
				$tag = $tag . ',"' . $row_tag['name'] . '"';
			?>
			<input type='hidden' id='tags' name='tags'>
			<script>
			$('#tag').tagsInput({
				interactive: true,
				placeholder: 'Add a tag',
				minChars: 0,
				maxChars: null,
				limit: null,
				validationPattern: null,
				unique: true,
				'autocomplete': {
					source: [<?= substr($tag,1,1000) ?>]
				}
			});
			</script>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button_announcement'>Confirm</button>
			<input type='hidden' id='words' name='x'>
			<button type='button' class='btn btn-success' onclick='convert()'>Submit</button>
		</form>
		</div>
	</div>
	<script>
		$('#create_anon').click(function(){
			$('#announcement_notification').fadeIn();
		});
		$('#create_news').click(function(){
			$('#news_notification').fadeIn();
		});
		$('.btn-back').click(function(){
			$('.notification_large').fadeOut();
		});
		function convert(){
			$('#tags').val($('#tag').val());
			var value = $('#tag').val().replace(" ", "");
			var words = value.split(",");
			$('#words').val(words.length);
			$('#form_calendar').submit();
		}
		</script>
	<style>
		.departments{
			padding:20px;
			background-color:#666;
			margin:10px;
			border-radius:10px;
			transition:0.3s all ease;
			cursor:pointer;
		}
		.departments:hover{
			opacity:0.8;
			width:80%;
		}
	</style>
	<script>
	function buka_kal(){
		$('#calendar').fadeIn(500);
		$('#dept').fadeOut(200);
		$('#slip').fadeOut(200);
	}
	function bukaslip(){
		$('#dept').fadeOut(200);
		$('#calendar').fadeOut(200);
		$('#slip').fadeIn(500);
	}
	</script>
	<div class='main' id='slip' style='display:none'>
		<form action='show_salary_slip.php' method="POST" target="_blank">
			<input type='hidden' value='<?= $user_id ?>' name='user_salary'>
			<label>Month</label>
			<select class='form-control' name='month'>
<?php
		$month	 = 1; 
		for($month = 1; $month <= 12; $month++){
?>
				<option value='<?= $month ?>'><?= $month ?></option>
<?php
		}
?>
			</select>
			<label>Year</label>
			<select class='form-control' name='year'>
<?php
		$year = date('Y'); 
?>
				<option value='<?= $year ?>'><?= $year ?></option>
				<option value='<?= $year - 1 ?>'><?= $year - 1 ?></option>
			</select><br>
			<button type='submit' class='btn btn-primary'>View</button>
		</form>
	</div>
	<style>
		#menus{
			display:block;
		}
		#menus_small {
			top:0px;
			display:none;
			width: 100%;
			background-color: #555;
			overflow: auto;
		}
		#menus_small button {
			float: left;
			padding: 12px;
			color: white;
			text-decoration: none;
			font-size: 17px;
			width: 25%;
			text-align: center;
			background-color:transparent;
			transition:0.3s all ease;
			border:none;
		}
		#menus_small button:hover {
			background-color: #000;
		}
		@media only screen and (max-width:780px){
			#menus{
				display:none;
			}
			#menus_small{
				display:block;
			}
		}
	</style>
	<div class='main' id='dept' style='display:none'>
	<?php
	if(empty($_GET['alert'])){
	} else if($_GET['alert'] == 'changetrue'){
	?>
		<div style='position:fixed;top:20px;z-index:200'>
			<div class="alert alert-success" id='alert'>
				<strong>Success!</strong>Changes has been made to your account!
			</div>
		</div>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('#alert').fadeOut();
			},2000)
		});
	</script>
	<?php
		} else {
	?>
		<div style='position:fixed;top:20px;z-index:200'>
			<div class="alert alert-warning" id='alert'>
				<strong>Warning!</strong>No changes were made
			</div>
		</div>
		<script>
			$(document).ready(function(){
				setTimeout(function(){
					$('#alert').fadeOut();
				},2000)
			});
		</script>
	<?php
		}
	?>
	<div class='row' id='menus'>
		<div class='col-sm-6 col-lg-6 col-xl-3' style='margin-top:20px'>
			<div class='row box_notif'>
				<div class='col-md-5 col-lg-4 col-xl-4' style='background-color:#00ccff;padding-top:20px'>
					<img src='../universal/images/bullhorn.png' style='width:100%'>
				</div>
				<div class='col-sm-7 col-lg-8 col-xl-8'>
				<?php
					$sql_announcement = "SELECT COUNT(*) AS total_announcement FROM announcement WHERE date >= '" . date('Y-m-d') . "' AND date <= '" . date('Y-m-d',strtotime('+7day')) . "'";
					$result_announcement = $conn->query($sql_announcement);
					$announcement = $result_announcement->fetch_assoc();
					echo ('<h1>' . $announcement['total_announcement'] . '</h1>');
					echo ('<h3>News today</h3>');
				?>
				</div>
			</div>
		</div>
		<div class='col-sm-6 col-lg-6 col-xl-3' style='margin-top:20px'>
			<div class='row box_notif'>
				<div class='col-md-5 col-lg-4 col-xl-4' style='background-color:#00b8e6;padding-top:20px'>
					<img src='../universal/images/calendar.png' style='width:100%'>
				</div>
				<div class='col-md-7 col-lg-8 col-xl-8'>
				<?php
					if($role != 'superadmin'){
						$sql_calendar = "SELECT COUNT(*) AS total_calendar FROM calendar WHERE maker = '" . $user_id . "' AND date >= '" . date('Y-m-d') . "' AND date <= '" . date('Y-m-d',strtotime('+3day')) . "'";
					} else {
						$sql_calendar = "SELECT COUNT(*) AS total_calendar,maker FROM calendar WHERE date >= '" . date('Y-m-d') . "' AND date <= '" . date('Y-m-d',strtotime('+3day')) . "'";
					}
					$result_calendar = $conn->query($sql_calendar);
					$row = $result_calendar->fetch_assoc();
					echo ('<h1>' . $row['total_calendar'] . '</h1>');
					echo ('<h3>Events today</h3>');
				?>
				</div>
			</div>
		</div>
		<?php
			$sql_tagged = "SELECT user_id, calendar_id AS calendar_id FROM calendar_tag INNER JOIN calendar ON calendar_tag.calendar_id = calendar.id WHERE user_id = '" . $_SESSION['user_id'] . "' AND calendar.date >= '" . date('Y-m-d') . "' AND calendar.date <= '" . date('Y-m-d',strtotime('+3day')) . "'";
			$result_tagged = $conn->query($sql_tagged);
			$tagged = mysqli_num_rows($result_tagged);
			if($role != 'superadmin'){
		?>		
		<div class='col-sm-6 col-lg-6 col-xl-3' style='margin-top:20px'>
			<div class='row box_notif'>
				<div class='col-md-5 col-lg-4 col-xl-4' style='background-color:#00ccff;padding-top:20px'>
					<img src='../universal/images/tag.png' style='width:100%'>
				</div>
				<div class='col-sm-7 col-lg-8 col-xl-8'>
				<?php					
					echo ('<h1>' . $tagged . '</h1>');
					echo ('<h3>Tags</h3>');
				?>
				</div>
			</div>
		</div>
		<?php
			}
		?>
		<div class='col-sm-6 col-lg-6 col-xl-3' style='margin-top:20px'>
			<div class='box_notif'>
				<div style='width:100%;background-color:#ddd;padding:0px;margin-top:0px;padding:10px'>
					<h3><?= $name ?></h3>
				</div>
				<div class='row' style='padding:5px'>
					<div class='col-xs-6'>						
						<a href="edit_user_dashboard.php">
							<button type='button' class='btn btn_notif'>
								Edit profile
							</button>
						</a>
					</div>
					<div class='col-xs-6'>
						<button type='button' class='btn btn_notif' onclick='open_salary_side()'><p>Print salary <br>slilp</p></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class='row' id='menus_small' style='width:100%;background-color: #555;'>
		<button type='button' onclick='toggle_events()'>Events</button>
		<button type='button' onclick='toggle_news()'>News</button>
		<button type='button'>Profile</button>
		<button type='button' onclick='open_salary_side()'>Salary Slip</button>
	</div>
	<hr>
	<?php
		if($announcement['total_announcement'] > 0){
	?>
	<div class='row' id='news'>
		<div class='col-sm-12'>
			<h1>News!</h1>
		</div>
		<?php
			$sql_news = "SELECT date,event FROM announcement WHERE date >= '" . date('Y-m-d') . "' AND date <= '" . date('Y-m-d',strtotime('+7day')) . "'";
			$result_news = $conn->query($sql_news);
			while($news = $result_news->fetch_assoc()){
		?>
		<div class='col-md-3 col-sm-4'>
			<?= date('d M Y',strtotime($news['date'])); ?>
		</div>
		<div class='col-md-9 col-sm-8'>
			<strong><?= $news['event']; ?></strong>
		</div>
		<?php
			}
		?>
		<div class='col-md-12'>
			<hr>
		</div>
	</div>
	<?php
		}
		if($row['total_calendar'] > 0){
	?>
	<div class='row' id='events'>
		<div class='col-md-12'>
			<h1>Events</h1>
		</div>
		<?php
			$sql_events = "SELECT id,date,event,description FROM calendar WHERE date >= '" . date('Y-m-d') . "' AND date <= '" . date('Y-m-d',strtotime('+3day')) . "' 
			AND maker = '" . $_SESSION['user_id'] . "'";
			$result_events = $conn->query($sql_events);
			while($events = $result_events->fetch_assoc()){
		?>
		<div class='col-md-3 col-sm-4'>
			<?= date('d M Y',strtotime($events['date'])) ?>
		</div>
		<div class='col-md-7 col-sm-6'>
			<strong><?= $events['event']; ?></strong>
		</div>
		<div class='col-md-1 col-sm-1'>
			<button type='button' class='btn btn-default' onclick='showdetail(<?= $events['id'] ?>)' id='showdet<?= $events['id'] ?>'>+</button>
			<button type='button' class='btn btn-default' onclick='hidedetail(<?= $events['id'] ?>)' id='hidedet<?= $events['id'] ?>' style='display:none'>-</button>
		</div>
		<div class='col-md-12' id='detail<?= $events['id'] ?>' style='display:none'>
			<?= $events['description'] ?>
		</div>
		<br><br>
		<?php
			}
		?>
		<div class='col-md-12'>
			<hr>
		</div>
	</div>
	<?php
		}
	if($tagged > 0){
	?>
	<div class='row' id='tags'>
		<div class='col-sm-12'>
			<h1>Tags</h1>
		</div>
		<?php
			while($row_tagged = $result_tagged->fetch_assoc()){
		?>
		<div class='col-md-3 col-sm-4'>
			<?php
				$sqli = "SELECT id,date,event,description,maker FROM calendar WHERE id = '" . $row_tagged['calendar_id'] . "'";
				$resulti = $conn->query($sqli);
				$rowi = $resulti->fetch_assoc();
				echo date('d M Y',strtotime($rowi['date']));
			?>
		</div>
		<div class='col-md-5 col-sm-4'>
			<?= $rowi['event'] ?>
		</div>
		<div class='col-md-3'>
			<?php
				$myname = "SELECT name FROM users WHERE id = '" . $rowi['maker'] . "'";
				$yourname = $conn->query($myname);
				$ourname = $yourname->fetch_assoc();
			?>
			You are tagged by <strong><?= $ourname['name'] ?></strong>
		</div>
		<div class='col-md-1 col-sm-1'>
			<button type='button' class='btn btn-default' onclick='showi(<?= $rowi['id'] ?>)' id='show_tag<?= $rowi['id'] ?>'>+</button>
			<button type='button' class='btn btn-default' onclick='hidi(<?= $rowi['id'] ?>)' id='hide_tag<?= $rowi['id'] ?>' style='display:none'>-</button>
		</div>
		<div class='col-sm-12' id='detaili<?= $rowi['id'] ?>' style='display:none'>
			<?= $rowi['description']; ?>
		</div>
		<script>
		function showi(n){
			$('#detaili' + n).show();
			$('#hide_tag' + n).show();
			$('#show_tag' + n).hide();
		};
		function hidi(n){
			$('#detaili' + n).hide();
			$('#hide_tag' + n).hide();
			$('#show_tag' + n).show();
		}
		</script>
		<?php
			}
		?>
	</div>
	<?php
	}
	?>
	<div id="Salary_side" class="salary_side_nav">
		<div style='padding:20px'>
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
			<form action='show_salary_slip.php' method='POST' target='_blank'>
				<label style='color:white'>Month</label>
				<select class='form-control' name='month'>
				<?php
					$m = 1;
					for($m = 1; $m <= 12; $m++){
				?>
					<option value='<?= $m ?>'><?= $m ?></option>
				<?php
					}
				?>
				</select>
				<label style='color:white'>Year</label>
				<input type='hidden' value='<?= $_SESSION['user_id'] ?>' name='user_salary'>
				<select class='form-control' name='year'>
				<?php
					$sql_salary = 'SELECT DISTINCT(YEAR(date)) AS year FROM absentee_list';
					echo $sql_salary;
					$result_salary = $conn->query($sql_salary);
					while($row_salary = $result_salary->fetch_assoc()){
				?>	
					<option value='<?= $row_salary['year'] ?>'><?= $row_salary['year']; ?></option>
				<?php
					}
				?>
				</select>
				<br><br>
				<button type='submit' class='btn btn_submit_salary'>Submit</button>
			</form>
		</div>
	</div>
	<script>
		function open_salary_side() {
			$('#Salary_side').css('width',"250px");
		}
		function closeNav() {
			$("#Salary_side").css('width',"0px");
		}
	</script>
<?php
if($privilege == 1){
	include('calendar_absent.php');
}
?>
</div>