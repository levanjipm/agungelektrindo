<?php
	include("../Codes/connect.php");
	$id = $_POST['user'];
	$term = $_POST['term'];
	$month = substr($term,0,2);
	$year = substr($term,2,4);
	$sql_count = "SELECT COUNT(*) AS absent FROM absentee_list WHERE user_id = '" . $id . "' AND month(date) = '" . $month . "' AND year(date) = '" . $year . "' AND isdelete = '0'";
	$result_count = $conn->query($sql_count);
	$i = 1;
	while($row_count = $result_count->fetch_object()){
		$function_result[$i]=$row_count;
		$counting = $row_count->absent;
		echo $counting;
	}
?>