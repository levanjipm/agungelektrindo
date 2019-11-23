<?php
	include('../../codes/connect.php');
	$term 		= mysqli_real_escape_string($conn,$_POST['term']);
	$sql 		= "(SELECT code_quotation.id FROM code_quotation
				INNER JOIN customer 
				ON customer.id = code_quotation.customer_id
				WHERE customer.name LIKE '%" . $term . "%')
				UNION
				(SELECT DISTINCT(quotation_code) AS id FROM quotation WHERE reference LIKE '%" . $term . "%')
				UNION
				(SELECT DISTINCT(quotation.quotation_code) AS id FROM quotation
				JOIN itemlist ON quotation.reference = itemlist.reference
				WHERE itemlist.description LIKE '%" . $term . "%')
				UNION
				(SELECT id FROM code_quotation WHERE name LIKE '%" . $term . "%')
				UNION
				(SELECT id FROM code_quotation WHERE note LIKE '%" . $term . "%') ORDER BY id DESC";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
		$sql_code_quotation	= "SELECT name,customer_id FROM code_quotation WHERE id = '" . $row['id'] . "'";
		$result_code_quotation	= $conn->query($sql_code_quotation);
		$code_quotation		= $result_code_quotation->fetch_assoc();
		
		$customer_id		= $code_quotation['customer_id'];
		
		$sql_customer 		= "SELECT name FROM customer WHERE id = '$customer_id'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		
		$quotation_name		= $code_quotation['name'];
		
		$sql_quotation 		= "SELECT * FROM code_quotation WHERE id = '" . $row['id'] . "'";
		$result_quotation 	= $conn->query($sql_quotation);
		$quotation 			= $result_quotation->fetch_assoc();
?>
		<div class='col-sm-4' style='padding:5px'>
			<div class='row box_edit_quotation' id='row-<?= $quotation['id'] ?>'>
				<div class='col-sm-8' style='padding:20px;background-color:#63767F;cursor:pointer' onclick='view_quotation(<?= $quotation['id'] ?>)'>
					<strong><?= $quotation_name ?></strong><br>
					<p><?= $customer_name ?></p>
				</div>
				<div class='col-sm-4' style='padding:20px'>
					<button type='button' class='button_default_dark' style='width:100%' onclick='view_quotation(<?= $quotation['id'] ?>)'>
						<i class="fa fa-eye" aria-hidden="true"></i>
					</button>
					<br>
					<button type='button' class='button_success_dark' style='width:100%'  onclick='edit_form(<?= $quotation['id'] ?>)'>
						<i class="fa fa-pencil" aria-hidden="true"></i>
					</button>
					<br>
					<form id='editing<?= $quotation['id'] ?>' action='quotation_edit' method='POST'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
					<button type='button' class='button_warning_dark' style='width:100%' onclick='submit_form(<?= $quotation['id']?>)'>
						<i class="fa fa-print" aria-hidden="true"></i>
					</button>
					
					<form id='<?= $quotation['id'] ?>' action='quotation_create_print' method='POST' target='_blank'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
				</div>
				<hr>
			</div>
		</div>
<?php
	}
?>