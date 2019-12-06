<h3 style='font-family:bebasneue'>Available to send</h3>
<div class='row'>
<?php
	include('../codes/connect.php');
	
	$sql 					= "SELECT id,name,customer_id,po_number FROM code_salesorder WHERE isconfirm = '1' AND type='GOOD'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$nilai 				= 1;
		$sql_detail 		= "SELECT reference	FROM sales_order WHERE so_id = '" . $row['id'] . "' AND status = '0'";
		$result_detail 		= $conn->query($sql_detail);
		while($detail 		= $result_detail->fetch_assoc()){
			$sql_stock 		= "SELECT stock FROM stock WHERE reference = '" . $detail['reference'] . "' ORDER BY id DESC LIMIT 1";
			$result_stock 	= $conn->query($sql_stock);
			$stock 			= $result_stock->fetch_assoc();
			if($stock['stock'] != 0 || $stock['stock'] == NULL){ $nilai++; }
		}
		
		if($nilai > 1){			
?>
	<div class='col-sm-4' style='margin-top:30px;text-align:center'>
		<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
			<h3 style='font-family:bebasneue'><?= $row['name'] ?></h3>
			<p><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></p>
			<p><?= $row['po_number'] ?></p>
			<button type='button' class='button_default_dark' onclick='view(<?= $row['id'] ?>)'>View</button>
			<button type='button' class='button_success_dark' onclick='send(<?= $row['id'] ?>)'>Send</button>
		</div>
	</div>
<?php
		}
	}
?>
</div>
<form id='delivery_order_form' method='POST' action='delivery_order_create'>
	<input type='hidden' id='sales_order_id' name='id'>
</form>