<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/accounting_header.php');
?>
<head>
	<title>Confirm sales invoice</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales invoice</h2>
	<p style='font-family:museo'>Confirm sales invoice</p>
	<hr>
<?php	
	if(empty($_POST['id'])){
?>
	<script>
		window.location.href='confirm_invoice_dashboard';
	</script>
<?php
	} else {
		$invoice_id 	= $_POST['id'];
		$sql 			= "SELECT invoices.ongkir, invoices.name, code_delivery_order.tax, code_delivery_order.project_id, code_delivery_order.customer_id
							FROM invoices 
							JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE invoices.id = '" . $invoice_id . "'";
		
		$result 		= $conn->query($sql);
		$row 			= $result->fetch_assoc();
		
		$invoice_name 	= $row['name'];
		$ongkir 		= $row['ongkir'];
		$do_name 		= 'SJ-AE-' . substr($invoice_name,6,100);
		$customer_id 	= $row['customer_id'];
		
		$project_id 	= $row['project_id'];
		$taxing 		= $row['tax'];
?>
		<form method="POST" action='delete_invoice_input' id='delete_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
		</form>
		<form method="POST" action='confirm_invoice_input' id='confirm_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
			<input type='hidden' value='<?= $taxing ?>' name='taxing'>
<?php
			if($taxing == 1){
?>
			<label>Input nomor faktur pajak</label>
			<input type='text' class='form-control' id='piash' name='faktur' required />
<?php
			}
?>
		</form>
<?php
	if($project_id == NULL){
?>
		<table class='table table-bordered'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Price</th>
				
			</tr>
<?php	
				$sql_do 			= "SELECT id,so_id FROM code_delivery_order WHERE name = '" . $do_name . "'";
				$result_do 			= $conn->query($sql_do);
				$row_do 			= $result_do->fetch_assoc();
				$do_id 				= $row_do['id'];
				$so_id 				= $row_do['so_id'];
					
				$value				= 0;
				$sql_table 			= "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "'";
				$result_table		= $conn->query($sql_table);
				while($row_table 	= $result_table->fetch_assoc()){
					$reference 		= $row_table['reference'];
					$quantity 		= $row_table['quantity'];
					$billed_price	= $row_table['billed_price'];
					
					$sql_item 		= "SELECT description FROM itemlist WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "'";
					$result_item 	= $conn->query($sql_item);
					$row_item 		= $result_item->fetch_assoc();
					
					$description	= $row_item['description'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= $quantity ?></td>
				<td>
<?php
					if($taxing == 1){
						echo ('Rp. ' . number_format($billed_price * 10 / 11,2));
					} else {
						echo ('Rp. ' . number_format($billed_price,2)); 
					}
?>
				</td>
				<td>
<?php
					if($taxing == 1){
						echo ('Rp. ' . number_format(($quantity * $billed_price*10/11),2));
					} else {
						echo ('Rp. ' . number_format(($quantity * $billed_price),2));
					}
?>
				</td>
			</tr>
<?php
				$value += $quantity * $billed_price;
				}
				if($taxing == 1){
?>
			<tr>
				<td style='border-top:1px solid #ddd;background-color:white' colspan='3'></td>
				<td>Subtotal</td>
				<td><?= 'Rp. ' . number_format($value *10 / 11,2)?></td>
			</tr>
			<tr>
				<td style='border:none;background-color:white' colspan='3'></td>
				<td>PPn</td>
				<td><?= 'Rp. ' . number_format($value - $value *10 / 11,2)?></td>
			</tr>
<?php
				} else {
?>
			<tr>
				<td style='border-top:1px solid #ddd;background-color:white' colspan='3'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value)?></td>
			</tr>
<?php
			};
?>
			<tr>
				<td style='border:none;background-color:white' colspan='3'></td>
				<td>Ongkos kirim</td>
				<td><?= 'Rp. ' . number_format($ongkir,2);	?></td>
			</tr>
			<tr>
				<td style='border:none;background-color:white' colspan='3'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value + $ongkir,2)?></td>
			</tr>
		</table>
<?php
			} else {
				$sql_project = "SELECT * FROM code_project WHERE id = '" . $project_id . "'";
				$result_project = $conn->query($sql_project);
				$project = $result_project->fetch_assoc();
				
				$sql_invoice = "SELECT value FROM invoices WHERE id = '" . $invoice_id . "'";
				$result_invoice = $conn->query($sql_invoice);
				$invoice = $result_invoice->fetch_assoc();
				
				$value = $invoice['value'];
				
				$project_name			= $project['project_name'];
				$project_description	= $project['description'];
?>
		<table class='table table-bordered'>
			<tr>
				<th colspan='2'>Project</th>
				<th>Price</th>
			</tr>
			<tr>
				<td colspan='2'><?= $project_name . " - " . $project_description ?></td>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Total</td>
				<td>Rp. <?= number_format($value,2) ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Delivery Fee</td>
				<td><input type='number' class='form-control' name='delivery_fee'></td>
			</tr>
<?php
			}
?>
		</table>
		<br><br>
		<button type='button' class='button_danger_dark' id='cancel_button'>Cancel</button>
		<button type='button' class='button_default_dark' id='confirm_button'>Confirm</button>
	</div>
	<div class='full_screen_wrapper' id='confirm_notification'>
		<div class='full_screen_notif_bar'>
			<h1 style='font-size:2em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<p style='font-family:museo'>Are you sure to confirm this sales invoice?</p>
			<button type='button' class='button_danger_dark' id='button_close_confirm_notification'>Check again</button>
			<button type='button' class='button_success_dark' id='confirm_invoice_button'>Confirm</button>
		</div>
	</div>
	<div class='full_screen_wrapper' id='delete_notification'>
		<div class='full_screen_notif_bar'>
			<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
			<p style='font-family:museo'>Are you sure to delete this sales invoice?</p>
			<button type='button' class='button_danger_dark' id='button_close_delete_notification'>Check again</button>
			<button type='button' class='button_success_dark' id='delete_invoice_button'>Confirm</button>
		</div>
	</div>
<?php
	if($taxing == 1){
?>
	<button type='button' class='button_success_dark' onclick='lihat()'>Check</button>
	<script>
	$("#piash").inputmask("999.999-99.99999999");
	function lihat(){
		var faktur = $('#piash').val();
		var panjang = $('#piash').val().length;
		var first = faktur.substr(0,1);
		var second = faktur.substr(2,1);
		if(faktur == ''){
			alert('Please insert the corresponding taxing document');
			return false;
		} else if (first != 0){
			alert('Invalid number');
		} else if(second != '1' && second != '0'){
			alert('Invalid status');
			$('#piash').focus();
		} else {
			$('#input').submit();			
		}
	}
</script>
<?php
	} else {
?>
	<button type='submit' class='button_success_dark' onclick='submit_form()'>Check</button>
	<script>
		function submit_form(){
			$('#input').submit();
		}
	</script>
<?php
	}
?>
<script>
	$('#confirm_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#confirm_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#confirm_notification .full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#confirm_notification').fadeIn();
	});
	
	$('#cancel_button').click(function(){
		var window_height		= $(window).height();
		var notif_height		= $('#delete_notification .full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('#delete_notification .full_screen_notif_bar').css('top',0.7 * difference / 2)
		$('#delete_notification').fadeIn();
	});
	
	$('#button_close_delete_notification').click(function(){
		$('#delete_notification').fadeOut(300);
	});
	
	$('#button_close_confirm_notification').click(function(){
		$('#confirm_notification').fadeOut(300);
	});

	$('#confirm_invoice_button').click(function(){
<?php
	if($taxing == 1){
?>
		if($('#piash').val() == ''){
			$('#confirm_notification').fadeOut();
			alert('Please insert correct tax document');
			return false;
		} else {
<?php
	}
?>
			$('#confirm_invoice_form').submit();
<?php if($taxing == 1){ ?>
		}
<?php } ?>
	});
	
	$('#delete_invoice_button').click(function(){
		$('#delete_invoice_form').submit();
	});
</script>
<?php
	}
?>