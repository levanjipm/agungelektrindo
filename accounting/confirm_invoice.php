<?php
	include('accountingheader.php');
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<style>
	input {
	  font-family: monospace;
	}
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
</style>
	<div class='main'>
		<h2 style='font-family:bebasneue'>Sales invoice</h2>
		<p>Confirm sales invoice</p>
		<hr>
<?php	
	if(empty($_POST['id'])){
		header('confirm_invoice_dashboard.php');
	} else {
		$invoice_id = $_POST['id'];
		$sql = "SELECT name FROM invoices WHERE id = '" . $invoice_id . "'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$invoice_name = $row['name'];
		$do_name = 'SJ-AE-' . substr($invoice_name,6,100);
		
		$sql_initial = "SELECT tax FROM code_delivery_order WHERE name = '" . $do_name . "'";
		$result_initial = $conn->query($sql_initial);
		$row_initial = $result_initial->fetch_assoc();
		$taxing = $row_initial['tax'];
?>
		<form method="POST" action='delete_invoice_input.php' id='delete_invoice_form'>
			<input type='hidden' value='<?= $invoice_id ?>' name='invoice_id'>
		</form>
		<form method="POST" action='confirm_invoice_input.php' id='confirm_invoice_form'>
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
		<table class='table'>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Price</th>
				
			</tr>
<?php
				$sql_do = "SELECT * FROM code_delivery_order WHERE name = '" . $do_name . "'";
				$result_do = $conn->query($sql_do);
				$row_do = $result_do->fetch_assoc();
				$do_id = $row_do['id'];
				$so_id = $row_do['so_id'];
				$customer_id = $row_do['customer_id'];
				$sql_table = "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "'";
				$result_table = $conn->query($sql_table);
				while($row_table = $result_table->fetch_assoc()){
					$reference = $row_table['reference'];
					$quantity = $row_table['quantity'];
?>
			<tr>
				<td><?= $reference ?></td>
				<td>
<?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $reference . "'";
					$result_item = $conn->query($sql_item);
					$row_item = $result_item->fetch_assoc();
					echo $row_item['description'];
?>
				</td>
				<td><?= $quantity ?></td>
				<td>
<?php
					$sql_so = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $reference  . "'";
					$result_so = $conn->query($sql_so);
					$row_so = $result_so->fetch_assoc();
					$price = $row_so['price'];
					if($taxing == 1){
						echo ('Rp. ' . number_format($price * 10 / 11,2));
					} else {
						echo ('Rp. ' . number_format($price,2)); 
					}
?>
				</td>
				<td>
<?php
					if($taxing == 1){
						echo ('Rp. ' . number_format(($quantity * $price*10/11),2));
					} else {
						echo ('Rp. ' . number_format(($quantity * $price),2));
					}
?>
				</td>
			</tr>
<?php
				}
				$sql_invoice = "SELECT value,ongkir FROM invoices WHERE name = '" . $invoice_name . "'";
				$result_invoice = $conn->query($sql_invoice);
				$row_invoice = $result_invoice->fetch_assoc();
				$value = $row_invoice['value'];
				$ongkir = $row_invoice['ongkir'];
				if($taxing == 1){
?>
			<tr>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td>Subtotal</td>
				<td><?= 'Rp. ' . number_format($value *10 / 11,2)?></td>
			</tr>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td>PPn</td>
				<td><?= 'Rp. ' . number_format($value - $value *10 / 11,2)?></td>
			</tr>
<?php
				} else {
?>
			<tr>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value *10 / 11,2)?></td>
			</tr>
<?php
			};
?>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td>Ongkos kirim</td>
				<td><?= 'Rp. ' . number_format($ongkir,2);	?></td>
			</tr>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value + $ongkir,2)?></td>
			</tr>
		</table>
		<br><br>
		<button type='button' class='btn btn-default' id='confirm_button'>Confirm</button>
		<button type='butotn' class='btn btn-danger' id='cancel_button'>Cancel</button>
	</div>
	<div class='notification_large' style='display:none' id='confirm_notification'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to confirm this sales invoice?</h2>
			<br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
		</div>
	</div>
	<div class='notification_large' style='display:none' id='delete_notification'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to confirm this sales invoice?</h2>
			<br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-delete'>Delete</button>
		</div>
	</div>
<?php
	if($taxing == 1){
?>
	<button type='button' class='btn btn-primary' onclick='lihat()'>Check</button>
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
	<button type='submit' class='btn btn-success' onclick='submit_form()'>Check</button>
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
		$('#confirm_notification').fadeIn();
	});
	$('#cancel_button').click(function(){
		$('#delete_notification').fadeIn();
	});
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	$('.btn-confirm').click(function(){
<?php
	if($taxing == 1){
?>
		if($('#piash').val() == ''){
			$('.notification_large').fadeOut();
			alert('Please insert correct tax document');
			return false;
		} else {
<?php
	}
?>
			$('#confirm_invoice_form').submit();
<?php
	if($taxing == 1){
?>
		}
<?php
	}
?>
	});
	$('.btn-delete').click(function(){
		$('#delete_invoice_form').submit();
	});
</script>
<?php
	}
?>