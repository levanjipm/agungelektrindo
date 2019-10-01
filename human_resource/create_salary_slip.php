<?php
	include('../codes/connect.php');
	$bonus 					= (int)$_POST['bonus'];
	$deduction 				= (int)$_POST['deduction'];
	$user_id 				= $_POST['user_salary'];
	$month					= $_POST['month'];
	$year					= $_POST['year'];
	$daily_wage				= (int)$_POST['daily'];
	$basic_wage				= (int)$_POST['basic'];
		
	$sql_absent				= "SELECT * FROM absentee_list WHERE user_id = '$user_id' AND MONTH(date) = '$month' AND YEAR(date) = '$year' AND isdelete = '0'";
	$result_absent			= $conn->query($sql_absent);
		
	$absentee				= mysqli_num_rows($result_absent);
		
	$sql_check				= "SELECT id FROM salary WHERE user_id = '$user_id', month = '$month', year = '$year'";
	$result_check			= $conn->query($sql_check);
	if(mysqli_num_rows($result_check) == 0){	
		$sql_insert 		= "INSERT INTO salary (user_id,working,daily,basic,bonus,deduction, month, year)
							VALUES ('$user_id','$absentee','$daily_wage','$basic_wage','$bonus','$deduction','$month','$year')";
		$conn->query($sql_insert);
		
		$headers 			= "From: Agung Elektrindo - Human resource \r\n";
		$headers 			.= "MIME-Version: 1.0\r\n";
		$headers 			.= "Content-Type: text/html; charset=UTF-8\r\n";
				
		$sql 				= "SELECT * FROM users WHERE id = '" . $user_id . "'";
		$result 			= $conn->query($sql);
		$row 				= $result->fetch_assoc();
				
		$gender 			= $row['gender'];
		$email 				= $row['mail'];
		$name 				= $row['name'];
		$address 			= $row['address'];
		$city 				= $row['city'];
		$nik 				= $row['NIK'];
	
		if($gender 		== 1){
			$gender_name = 'Bapak';
		} else {
			$gender_name = 'Ibu';
		}
		
		$to 			= $email;
		$subject 		= "Slip Penerimaan Upah Masa" . ' ' . substr($_POST['bulan'],0,2) . ' - ' . $_POST['tahun'];
		$msg 			= "Kepada Yth. " . $gender_name . ' <strong>' . $name . '</strong><br>
						Bersama ini, kami ingin menginformasikan bahwa slip penerimaan upah masa ' . $month . ' tahun ' . $year .
						' telah diterbitkan dan dapat didownload secara langsung pada masing masing <i>Account control</i> ' . $gender_name . '.<br>
						Sekian informasi ini diberikan<br><strong>Best regards</strong><br>CV Agung Elektrindo';
		$sendtomail 	= mail($to,$subject,$msg,$headers);
	}
?>