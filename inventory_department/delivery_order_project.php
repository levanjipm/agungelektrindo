<h3 style='font-family:bebasneue'>Available to send</h3>
<div class='row'>
<?php
	include('../codes/connect.php');
	$sql 					= "SELECT id,customer_id,project_name FROM code_project WHERE isdone = '1' AND issent = '0'";
	$result 				= $conn->query($sql);
	while($row 				= $result->fetch_assoc()){
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $row['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
?>
	<div class='col-sm-4' style='margin-top:30px;text-align:center'>
		<div class='box' style='background-color:#eee;width:90%;text-align:center;padding:10px'>
			<h3 style='font-family:bebasneue'><?= $row['project_name'] ?></h3>
			<p><?= $customer_name ?></p>
			<button type='button' class='button_default_dark' onclick='send_project(<?= $row['id'] ?>)'><i class='fa fa-eye'></i></button>
			<form action='delivery_order_project_validation' method='POST' id='project_form-<?= $row['id'] ?>'>
				<input type='hidden' value='<?= $row['id'] ?>' name='project_id'>
			</form>
		</div>
	</div>
<?php
		}
?>
</div>
<hr>