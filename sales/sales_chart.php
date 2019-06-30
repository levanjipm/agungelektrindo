<?php
	include('salesheader.php');
	$maximum = 0;
	for($i = 1; $i <= 14; $i++){
		$sql = "SELECT sum(value) AS daily_sales FROM invoices WHERE isconfirm = '1' AND date = '" . date('Y-m-d',strtotime('2018-12-10 -' . $i . " days")) . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if($row['daily_sales'] > $maximum){
			$maximum = $row['daily_sales'];
		}
	}
?>
<style>
	.batangan{
		background-color:#333;
		position:absolute;
		bottom:0;
	}
</style>
<div class='main'>
	<div class='row' style='min-height:300px'>
<?php
	for($i = 1; $i <= 14; $i++){
		$sql = "SELECT sum(value) AS daily_sales FROM invoices WHERE isconfirm = '1' AND date = '" . date('Y-m-d',strtotime('2018-12-10 -' . $i . " days")) . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if($row['daily_sales'] == NULL){
?>
			<div class='batangan' style='height:10px;width:50px;left:<?= $i * 50?>px'></div>
<?php
		} else {
?>
			<div class='batangan' style='height:<?= $row['daily_sales'] * 200 / $maximum ?>px;width:50px;left:<?= $i * 50?>px'></div>
<?php
		}
	}
	
?>