<!DOCTYPE html>
<html lang="en">
<head>
<title>Inventory Department</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<?php
	include('../codes/connect.php');
?>
<div class="container">
	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-6 offset-sm-3" style="text-align:center">
				<h1>Absentee List</h1>
			</div>
		</div>
		<br><br>
		<form method="POST" action="log_on_agungelektrindo.php">
			<input type="date" value="<?= date('Y-m-d')?>" readonly style="display:none" name="date">
			<div class="row">
				<div class="col-10 offset-1">
					<label for="name">Username:</label>
					<input type="text" class="form-control" placeholder="Please enter your registered username" required name="username">
				</div>
			</div>
			<div class="row">
				<div class="col-10 offset-1">
					<label for="name">Password</label>
					<input type="password" class="form-control" placeholder="Enter registered password" required name="password">
				</div>
			</div>
			<br><br>
			<div class="row">
				<div class="col-3 offset-1">
					<button type="submit" class="btn btn-success">Log in Now</button>
				</div>
			</div>
		</form>
	</div>
</div>