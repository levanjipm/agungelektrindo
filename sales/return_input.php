<?php
	include('../codes/connect.php');
	$do_id = $_POST['do_id'];
	$x = $_POST['x'];
	//Check if the document is empty, don't mess with me, dude//
	$d = 1;
	$cek = 0;
	for($d = 1; $d <= $x; $d++){
		$cek = $cek + $_POST['return_quantity' . $d];
	}	
	if($cek == 0){
?>
		<script>
			window.location.replace('return_validation.php');
		</script>
<?php
	}
	$jumlah_total = 0;
	$point = 0;
	$y = 1;
	for($y = 1; $y <= $x; $y++){
		$sql_cek = "SELECT quantity FROM delivery_order WHERE do_id = '" . $do_id . "' AND reference = '" . $_POST['item' . $y] . "'";
		$result_cek = $conn->query($sql_cek);
		while($row_cek = $result_cek->fetch_assoc()){
			$quantity_sent = $row_cek['quantity'];
		}
		if($quantity_sent < $_POST['return_quantity' . $y]){
			break;
			header('location:return_dashboard.php');
		}
		$sql_cek2 = "SELECT * FROM sales_return WHERE reference = '" . $_POST['item' . $y] . "'";
		$result_cek2 = $conn->query($sql_cek2);
		while($row_cek2 = $result_cek2->fetch_assoc()){
			$return_code = $row_cek2['return_code'];
			$sql_get = "SELECT * FROM code_sales_return WHERE id = '" . $return_code . "' AND do_id = '" . $do_id . "'";
			$result_get = $conn->query($sql_get);
			if(mysqli_num_rows($result_get) == NULL || mysqli_num_rows($result_get) == 0){
			} else {
				$jumlah_total = $jumlah_total + $row_cek2['quantity'];
			}
		}
	}
	if($jumlah_total > $quantity_sent){
		header('location:return_dashboard.php');
	} else {
		$reason = $_POST['reason'];
		if($reason == 5 && $_POST['other'] == ''){
			header('location:return_dashboard.php?alert=2');
		} else {
			$sql_do = "SELECT * FROM code_delivery_order WHERE id = '" . $do_id . "' AND isdelete = '0' AND sent = '1'";
			$result_do = $conn->query($sql_do);
			while($row_do = $result_do->fetch_assoc()) {
				$customer_id = $row_do['customer_id'];
			}
			$sql_insert = "INSERT INTO code_sales_return (submission_date,customer_id,do_id,reason) VALUES (NOW(),'$customer_id','$do_id','$reason')";
			$result_insert = $conn->query($sql_insert);
			$sql_select = "SELECT * FROM code_sales_return ORDER BY ID DESC LIMIT 1";
			$result_select = $conn->query($sql_select);
			while($row_select = $result_select->fetch_assoc()) {
				$return_id = $row_select['id'];
			}
			$i = 1;
			for($i = 1; $i <= $x; $i++){
				$item = $_POST['item' . $i];
				$quantity = $_POST['return_quantity' . $i];	
				$sql_insert_detail = "INSERT INTO sales_return (reference,quantity,return_code) VALUES ('$item','$quantity','$return_id')";
				echo $sql_insert_detail;
				$result_insert_detail = $conn->query($sql_insert_detail);
			}
		}
		header('location:sales.php');
	}
?>	