<?php
	include("../codes/connect.php");
	$user_name = $_POST['username'];
	$raw_password = $_POST['password'];
	$password = md5($raw_password);
	$date = $_POST['date'];
	$sql = "SELECT * FROM users WHERE username = '" . $user_name . "' AND password = '" . $password . "'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row = $results->fetch_assoc()){
			$user_id = $row['id'];
			echo $user_id;
		}
			$sql_insert = "INSERT INTO absentee_list (user_id,time,date) VALUES ('$user_id', NOW(),'$date')";
			$results = $conn->query($sql_insert);
?>
		<div class="container">
			<div class="row">
				<div class="col-6 offset-3" style="text-align:center">
					<h1>Log in success</h1>
					<br>
					<p>Welcome <?= $user_name ?></p>
				</div>
			</div>
		</div>
<?php
		header("Refresh:5; url=dashboard");
	} else {
		header("location:dashboard");
	};
?>
	