<?php
	include('salesheader.php');
?>
<div class='main'>
<?php
	$reference_array = $_POST['reference'];
	print_r($reference_array);
	foreach($reference_array as $reference){
		echo $reference;
	}
?>