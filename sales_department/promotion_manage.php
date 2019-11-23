<?php
	include('salesheader.php');
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Promotion</h2>
	<p>Manage promotion</p>
	<hr>
<?php
	$sql_ongoing		= "SELECT * FROM promotion WHERE end_date <= CURDATE()";
	$result_ongoin		= $conn->query($sql_ongoing);