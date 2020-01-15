<?php
	include('../codes/connect.php');
	if(empty($_POST['project_id']) || empty($_POST['project_send_date'])){
?>
<script>
	window.location.href='/agungelektrindo/inventory';
</script>
<?php
	} else {
		
	$guid			= $_POST['guid'];
	$project_id 	= $_POST['project_id'];
	$date 			= $_POST['project_send_date'];
	session_start();
	$creator = $_SESSION['user_id'];
	
	switch (date('m',strtotime($date))) {
	case "01" :
		$month = 'I';
		break;
	case "02" :
		$month = 'II';
		break;
	case "03" :
		$month = 'III';
		break;
	case "04" :
		$month = 'IV';
		break;
	case "05" :
		$month = 'V';
		break;
	case "06" :
		$month = 'VI';
		break;
	case "07" :
		$month = 'VII';
		break;
	case "08" :
		$month = 'VIII';
		break;
	case "09" :
		$month = 'IX';
		break;
	case "10" :
		$month = 'X';
		break;
	case "11" :
		$month = 'XI';
		break;
	case "12" :
		$month = 'XII';
		break;		
	}
	
	$sql_check		= "SELECT id FROM code_delivery_order WHERE guid = '$guid'";
	$result_check	= $conn->query($sql_check);
	$check			= mysqli_num_rows($result_check);
	
	if($check		== 0){
		$sql_code 		= "SELECT * FROM code_project WHERE id = '" . $project_id . "'";
		$result_code 	= $conn->query($sql_code);
		$code			= $result_code->fetch_assoc();
		
		$customer_id = $code['customer_id'];
		$taxing = $code['taxing'];
		
		$sql_number = "SELECT * FROM code_delivery_order 
		WHERE MONTH(date) = MONTH('" . $date . "') AND YEAR(date) = YEAR('" . $date . "') 
		AND isdelete = '0' AND company = 'AE' ORDER BY number ASC";
		$results = $conn->query($sql_number);
		if ($results->num_rows > 0){
			$i = 1;
			while($row_do = $results->fetch_assoc()){
				if ($i == $row_do['number']){
					$i++;
					$nomor = $i;
				} else {
					break;
				}
			}
		} else {
			$nomor = 1;
		};
		if ($taxing){
			$tax_preview = 'P';
		} else {
			$tax_preview = 'N';
		};
		
		$do_number_preview 	= "SJ-AE-" . str_pad($nomor,2,"0",STR_PAD_LEFT) . $tax_preview . "." . date("d",strtotime($date)). "-" . $month. "-" . date("y",strtotime($date));
		$sql 				= "UPDATE code_project SET issent = '1' WHERE id = '" . $project_id . "'";
		$result 			= $conn->query($sql);
		
		$sql 				= "INSERT INTO code_delivery_order (date,number,tax,name,customer_id,project_id,created_by,created_date, guid)
								VALUES ('$date','$nomor','$taxing','$do_number_preview','$customer_id','$project_id','$creator',CURDATE(), '$guid')";
		$result 			= $conn->query($sql);
		
		$sql 				= "SELECT id FROM code_delivery_order WHERE name = '" . $do_number_preview . "'";
		$result				= $conn->query($sql);
		$row 				= $result->fetch_assoc();
?>
	<form method='POST' action='delivery_project_print' id='do_print_form' target='_blank'>
		<input type='hidden' value='<?= $row['id'] ?>' name='id'>
	</form>
	<script>
		document.getElementById('do_print_form').submit();
		window.location.href='/agungelektrindo/inventory';
	</script>
<?php
		}
	}
?>