<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="../jquery-ui.css">
	<script src="../jquery-ui.js"></script>
	<script>
		$( function() {
			$('#item').autocomplete({
				source: "search_item.php"
			 })
		});
	</script>
</head>
<?php
session_start();
if($_SESSION['user_id']){
	include('connect.php');
	$sql = "SELECT * FROM users WHERE id = '" . isset( $_SESSION['user_id'] ) . "'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	$name = $row['name'];
	$role = $row['role'];
}
?>
<body>
<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header" style="font-size:30px">
			Welcome, <b><a href="#" style="text-decoration:none;color:black"><?= $name ?></a></b>
		</div>
	</div>
</nav>
<div class="row">
	<div class="container-fluid">
		<div class="col-xs-6 col-sm-4 cards" style="background-color:#888">
			<button type="button" class='btn card' onclick="show_stock()"><h2>Check stock</h2></a>
		</div>
		<div class="col-xs-6 col-sm-4 cards" style="background-color:#eee">
			<button type="button" class='btn card'><h2>Documents</h2></a>
		</div>
		<div class="col-xs-6 col-sm-4 cards" style="background-color:#4da6ff">
			<button type="button" class='btn card'><h2>My performance</h2></a>
		</div>
	</div>
</div>
<?php
} else {
	header('location:../landing_page.php');
}
?>

	