<?php
	include('../codes/connect.php');
	$id					= $_GET['id'];
	$sql				= "SELECT sample.code_id, sample.sent
							FROM sample
							WHERE code_id = '$id'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	$code_id			= $row['code_id'];
	$sent				= $row['sent'];
	
	if($sent == 0){
		$sql	= "UPDATE sample SET status = '1' WHERE id = '$id'";
		$result	= $conn->query($sql);
		
		$sql_count	= "SELECT id FROM sample WHERE code_id = '$code_id'";
		$result_count	= $conn->query($sql_count);
		$sample_count	= mysqli_num_rows($result_count);
		
		$sql_count		= "SELECT id FROM sample WHERE code_id = '$code_id' AND status = '1'";
		$result_count	= $conn->query($sql_count);
		$sample_done	= mysqli_num_rows($result_count);
		
		if($sample_count == $sample_done && $result){
			echo '2';
		} else if($sample_count != $sample_done && $result){
			echo '1';
		} else {
			echo '3';
		}
	} else {
		echo '3';
	}
?>