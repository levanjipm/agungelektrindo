<?php
	include('../codes/connect.php');
	$quotation_showed		= $_POST['quotation_showed'];
	$quotation_to_be_showed	= $_POST['quotation_to_be_showed'];
	$sql_quotation 			= "SELECT * FROM code_quotation ORDER BY id DESC LIMIT 30 OFFSET " . $quotation_showed;
	$result_quotation 		= $conn->query($sql_quotation);
	while($quotation 		= $result_quotation->fetch_assoc()){
		$sql_customer 		= "SELECT name FROM customer WHERE id = '" . $quotation['customer_id'] . "'";
		$result_customer 	= $conn->query($sql_customer);
		$customer 			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		
		$quotation_name		= $quotation['name'];
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
					<form id='editing<?= $quotation['id'] ?>' action='editquotation.php' method='POST'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
					<button type='button' class='button_warning_dark' style='width:100%' onclick='submit_form(<?= $quotation['id']?>)'>
						<i class="fa fa-print" aria-hidden="true"></i>
					</button>
					
					<form id='<?= $quotation['id'] ?>' action='createquotation_print.php' method='POST' target='_blank'>
						<input type='hidden' value='<?= $quotation['id'] ?>' name='id'>
					</form>
				</div>
				<hr>
			</div>
		</div>
<?php
	}
?>