<?php
	include("../codes/Connect.php");
	session_start();
	$name= mysqli_real_escape_string($conn,$_POST['namaperusahaan']);
	$address = mysqli_real_escape_string($conn,$_POST['alamat']) . " Blok " . mysqli_real_escape_string($conn,$_POST['blok']) . " no." . mysqli_real_escape_string($conn,$_POST['nomor'])
	. ", RT" . mysqli_real_escape_string($conn,$_POST['rt']) . ", RW" . mysqli_real_escape_string($conn,$_POST['rw']);
	
	$sql_check = "SELECT COUNT(id) AS jumlah FROM customer WHERE name = '" . $name . "'";
	$result_check = $conn->query($sql_check);
	$check = $result_check->fetch_assoc();
	$jumlah_satu = $check['jumlah'];
	
	$npwp= mysqli_real_escape_string($conn,$_POST['npwp']);
	if($npwp != ''){
		$sql_daniel = "SELECT COUNT(id) AS jumlah FROM customer WHERE npwp = '" . $npwp . "'";
		$result_daniel = $conn->query($sql_daniel);
		$daniel = $result_daniel->fetch_assoc();
		$jumlah_dua = $daniel['jumlah'];
	} else {
		$jumlah_dua = 0;
	}
	
	$phone = mysqli_real_escape_string($conn,$_POST['phone']);
	$city = mysqli_real_escape_string($conn,$_POST['city']);
	$prefix = mysqli_real_escape_string($conn,$_POST['prefix']);
	$pic = mysqli_real_escape_string($conn,$_POST['pic']);
	
	if($jumlah_satu > 0 || $jumlah_dua > 0){
		echo ('0'); //Customer already exist//
	} else {
		$sql = "INSERT INTO customer (name, address, phone, npwp,city,prefix,pic,date_created,created_by) 
		VALUES ('$name','$address','$phone','$npwp','$city','$prefix','$pic',CURDATE(),'" . $_SESSION['user_id'] . "')";
		$result = $conn->query($sql);
		if($result){
			echo ('1'); //Input success//
		} else {
			echo ('2'); //input failed//
		}
	};
?>
