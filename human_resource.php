<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Human resource department</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>This week attandance lsit</h2>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>User</th>
			<th>Attandance count</th>
		</tr>
<?php
	$sql_absentee_list			= "SELECT users.name, COUNT(absentee_list.id) as absent FROM absentee_list
									JOIN users ON users.id = absentee_list.user_id
									WHERE  YEARWEEK(absentee_list.date, 1) = YEARWEEK(CURDATE(), 1) AND absentee_list.isdelete = '0' GROUP BY absentee_list.user_id ORDER BY absentee_list.user_id";
	$result_absentee_list		= $conn->query($sql_absentee_list);
	while($absentee				= $result_absentee_list->fetch_assoc()){
		$user_absent			= $absentee['name'];
		$absent					= $absentee['absent'];
?>
		<tr>
			<td><?= $user_absent ?></td>
			<td><?= $absent ?></td>
		</tr>
<?php
	}
?>
</div>