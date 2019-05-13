<?php
	include('../../codes/connect.php');
?>
<div class='row'>
	<div class='col-sm-4'>
<?php
	$term = $_POST['term'];
	$sql = "(SELECT code_quotation.id
	FROM code_quotation
	INNER JOIN customer 
	ON customer.id = code_quotation.customer_id
	WHERE customer.name LIKE '%" . $term . "%')
	UNION
	(SELECT DISTINCT(quotation_code) AS id FROM quotation WHERE reference LIKE '%" . $term . "%')
	UNION
	(SELECT id FROM code_quotation WHERE name LIKE '%" . $term . "%') ORDER BY id DESC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_quotation = "SELECT * FROM code_quotation WHERE id = '" . $row['id'] . "'";
		$result_quotation = $conn->query($sql_quotation);
		$quotation = $result_quotation->fetch_assoc();
?>
			<div class='row' style='padding:20px;background-color:#ddd;margin-top:5px' id='row-<?= $quotation['id'] ?>'>
				<div class='col-sm-6'>
					<strong><?= $quotation['name'] ?></strong><br>
					<p><?php
						$sql_customer = "SELECT name FROM customer WHERE id = '" . $quotation['customer_id'] . "'";
						$result_customer = $conn->query($sql_customer);
						$customer = $result_customer->fetch_assoc();
						echo $customer['name'];
					?></p>
				</div>
				<div class='col-sm-6'>
					<button type='button' class='btn btn-default' style='border:none;background-color:transparent' onclick='view_pane(<?= $quotation['id'] ?>)'>
						<i class="fa fa-eye" aria-hidden="true"></i>
					</button>
					<br>
					<a href="editquotation.php?id=<?= $row['id']?>" style="text-decoration:none;color:black">
						<button type='button' class='btn btn-success'>
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</button>
					</a>
					<button type='button' class='btn btn-warning' onclick='submit_form(<?= $row['id']?>)'>
						<i class="fa fa-print" aria-hidden="true"></i>
						<form id='<?= $row['id'] ?>' action='createquotation_print.php' method='POST'>
							<input type='hidden' value='<?= $row['id'] ?>' name='id'>
						</form>
					</button>
					<button type="button" class="btn btn-copy" data-toggle="modal" data-target="#myModal-<?=$quotation['id']?>">
						<i class="fa fa-clone" aria-hidden="true"></i>
					</button>
				</div>
				<hr>
			</div>
<?php
	}
?>
	</div>
	<div class='col-sm-8' id='viewpane'>
	</div>
</div>