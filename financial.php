<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/financial_header.php');
?>
<head>
	<title>Financial department</title>
</head>
<div class='main'>
	<h3 style='font-family:bebasneue'>Overdues sales</h3>
	<hr>
<?php
	$sql		= "SELECT * FROM code_salesorder WHERE top = '0'";
	$result		= $conn->query($sql);
	print_r($result);
?>
</div>
