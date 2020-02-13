<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Manage promotion</title>
</head>
<style>
	#search {
		width: 130px;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
		padding:10px;
	}
	
	#search:focus {
		width: 100%;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Promotion</h2>
	<p style='font-family:museo'>Manage promotion</p>
	<hr>
	<a href='promotion_add_dashboard' style='text-decoration:none'>
		<button type='button' class='button_default_dark'>Add promotion</button>
	</a>
	<br><br>
	
	<input type='text' id='search'>
	
	<br><br>
	<label>Ongoing promotion</label>
<?php
	$sql_ongoing		= "SELECT * FROM promotion WHERE end_date > CURDATE() ORDER BY end_date ASC";
	$result_ongoing		= $conn->query($sql_ongoing);
	if(mysqli_num_rows($result_ongoing) == 0){
?>
	<p style='font-family:museo'>There is no promotion at the time</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<tr>
			<th>Promotion name</th>
			<th>End date</th>
			<th>Action</th>
		</tr>
<?php
	while($ongoing		= $result_ongoing->fetch_assoc()){
		$id				= $ongoing['id'];
		$name			= $ongoing['name'];
		$date			= $ongoing['end_date'];
?>
		<tr>
			<td><?= $name ?></td>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td>
				<a href='promotion_manage.php?id=<?= $id ?>'>
					<button type='button' class='button_success_dark'><i class="fa fa-pencil"></i></button>
				</a>
			</td>
		</tr>
<?php
	}
?>
	</table>
<?php
	}
?>
</div>