<?php
	include('../codes/connect.php');
	$headers = "From: Agung Elektrindo - Human resource \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$user_id = $_POST['user_id'];
	$sql = "SELECT * FROM users WHERE id = '" . $user_id . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	
	$gender = $row['gender'];
	$email = $row['mail'];
	$name = $row['name'];
	$address = $row['address'];
	$city = $row['city'];
	$nik = $row['NIK'];
	
	if($gender == 1){
		$gender_name = 'Bapak';
	} else {
		$gender_name = 'Ibu';
	}
	
	$basic = mysqli_real_escape_string($conn,$_POST['basic']);
	$daily = mysqli_real_escape_string($conn,$_POST['daily']);
	$working = mysqli_real_escape_string($conn,$_POST['working']);
	$bonus = mysqli_real_escape_string($conn,$_POST['bonus']);
	$cut = mysqli_real_escape_string($conn,$_POST['potongan']);
	$month = mysqli_real_escape_string($conn,$_POST['bulan']);
	$year = mysqli_real_escape_string($conn,$_POST['tahun']);
	
	$sql_insert = "INSERT INTO salary (user_id,working,daily,basic,bonus,cut, month, year)
	VALUES ('$user_id','$working','$daily','$basic','$bonus','$cut','$month','$year')";
	$result_insert = $conn->query($sql_insert);
	$to = $email;
	$subject = "Slip Penerimaan Upah Masa" . ' ' . substr($_POST['bulan'],0,2) . ' - ' . $_POST['tahun'];
	$msg = "Kepada Yth. " . $gender_name . ' <strong>' . $name . '</strong><br>
			Bersama ini, kami ingin menginformasikan bahwa slip penerimaan upah masa ' . $_POST['bulan'] . ' tahun ' . $_POST['tahun'] .
			' telah diterbitkan dan dapat didownload secara langsung pada masing masing <i>Account control</i> ' . $gender_name . '.<br>
			Sekian informasi ini diberikan<br><strong>Best regards</strong><br>CV Agung Elektrindo';
	$sendtomail = mail($to,$subject,$msg,$headers);
	header('location:hr.php');
?>