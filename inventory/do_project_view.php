<h3 style='font-family:bebasneue'>Available to send</h3>
<div class='row'>
<?php
	include('../codes/connect.php');
	$sql = "SELECT * FROM code_project WHERE isdone = '1' AND issent = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){			
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
			<button type='button' class='btn btn-default' onclick='view(<?= $row['id'] ?>)'>View</button>
			<button type='button' class='btn btn-success' onclick='send(<?= $row['id'] ?>)'>Send</button>
		</div>
	</div>
<?php
		}
?>
</div>
<hr>