<script src='../universal/jquery/jquery-3.3.0.min.js'></script>
<?php
	include('../codes/connect.php');
	if(empty($_POST['today']) && empty($_POST['value']) && empty($_POST['class'])){
?>
	<form action='petty_dashboard' method='POST' id='form_failed'>
		<input type='hidden' value='failed' name='status'>
	</form>
	<script>
		$('#form_failed').submit();
	</script>
<?php
} else {	
	$types 			= $_POST['types'];
	$date 			= $_POST['today'];
	$value 			= $_POST['value'];
	$class 			= $_POST['class'];
	if($types == 1){
		$sql_insert = "INSERT INTO petty_cash (date,value,class) VALUES ('$date','$value','25')";
	} else {
		$info = $_POST['info'];
		$saldo = $balance_total - $value;
		if(!empty($_POST['sub'])){
			$sub = $_POST['sub'];
			$sql_insert = "INSERT INTO petty_cash (date,info,value,class) VALUES ('$date','$info','$value','$sub')";
		} else {
			$sql_insert = "INSERT INTO petty_cash (date,info,value,class) VALUES ('$date','$info','$value','$class')";
		}
	}
	$result_insert = $conn->query($sql_insert);
?>
	<form action='petty_dashboard' method='POST' id='form_success'>
		<input type='hidden' value='success' name='status'>
	</form>
	<script>
		$('#form_success').submit();
	</script>
<?php
}
?>