	<div class='row'>
<?php
	include('../codes/connect.php');
	$sql = "SELECT DISTINCT(so_id) AS so FROM service_sales_order WHERE isdone = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$nilai = 1;
		$sql_detail = "SELECT * FROM code_salesorder WHERE id = '" . $row['so'] . "'";
		$result_detail = $conn->query($sql_detail);	
		$detail = $result_detail->fetch_assoc();
?>
		<div class='col-sm-4' style='margin-top:30px;text-align:center'>
			<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
				<h3 style='font-family:bebasneue'><?= $detail['name'] ?></h3>
				<p><?php
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $detail['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo $customer['name'];
				?></p>
				<p><?= $detail['po_number'] ?></p>
				<button type='button' class='btn btn-default' onclick='service_view(<?= $detail['id'] ?>)'>View</button>
				<button type='button' class='btn btn-success' onclick='send_services(<?= $detail['id'] ?>)'>Send</button>
				<form method='POST' action='do_service_validation.php' id='service_form-<?= $detail['id'] ?>'>
					<input type='hidden' value='<?= $detail['id'] ?>' name='id'>
				</form>
			</div>
		</div>
<?php
	}
?>