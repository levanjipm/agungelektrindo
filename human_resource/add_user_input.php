<?php
	include('../codes/connect.php');
	$user_name = $_POST['username'];
	$sql = "SELECT COUNT(*) AS jumlah FROM users WHERE username = '" . $user_name . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$jumlah = $row['jumlah'];
	if($jumlah != 0){
?>
		<script>
			history.go(-1);
		</script>
<?php
	} else {	
		$raw_password = $_POST['pwd'];
		$password = md5($raw_password);
		$nik = $_POST['nik'];
		$email = $_POST['mail'];
		$bank = $_POST['bank'];
		$name = $_POST['name'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$gender = $_POST['gender'];
		if($gender == 'Male' || $gender == 'Female'){
			if($gender == 'Male'){
				$gender_say = 1;
			} else {
				$gender_say = 2;
			}
			$sql = "INSERT INTO users (NIK, name, mail, username, password, address, city, bank, gender, date_in, isactive)
			VALUES ('$nik','$name','$email','$user_name','$password','$address','$city','$bank','$gender_say',CURDATE(),'1')";
			$results = $conn->query($sql);
			echo $sql;
			header ('location:add_user.php');
		} else {
?>
		<script>
			history.go(-1);
		</script>
<?php
		}
	}
?>