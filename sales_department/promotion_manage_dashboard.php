<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Manage promotion</title>
</head>
<script>
	$('#promotion_side').click();
	$('#promotion_manage_dashboard').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Promotion</h2>
	<p style='font-family:museo'>Manage promotion</p>
	<hr>
	<h3 style='font-family:museo'>Ongoing promotion</h3>
	<table class='table table-bordered'>
		<tr>
			<th>Promotion name</th>
			<th>End date</th>
			<th></th>
		</tr>
<?php
	$sql_ongoing		= "SELECT * FROM promotion WHERE end_date > CURDATE() ORDER BY end_date ASC";
	$result_ongoing		= $conn->query($sql_ongoing);
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
					<button type='button' class='button_success_dark'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				</a>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>