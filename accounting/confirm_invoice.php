<?php
	include('accountingheader.php');
?>
<script type='text/javascript' src="../universal/Jquery/jquery.inputmask.bundle.js"></script>
<style>
input {
  font-family: monospace;
}
</style>
	<div class='main'>
<?php	
	if(empty($_POST['id'])){
		header('confirm_invoice_dashboard.php');
	} else {
		$invoice_id = $_POST['id'];
		$sql = "SELECT name FROM invoices WHERE id = '" . $invoice_id . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$invoice_name = $row['name'];
		}
		$do_name = 'SJ-AE-' . substr($invoice_name,6,100);
		$sql_initial = "SELECT tax FROM code_delivery_order WHERE name = '" . $do_name . "'";
		$result_initial = $conn->query($sql_initial);
		while($row_initial = $result_initial->fetch_assoc()){
			$taxing = $row_initial['tax'];
		}
?>
		<form method="POST" action='confirm_invoice_input.php' id='input'>
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
					while($row_item = $result_item->fetch_assoc()){
						echo $row_item['description'];
					}
					?>
				</td>
				<td><?= $quantity ?></td>
				<td>
					<?php
					$sql_so = "SELECT * FROM sales_order WHERE so_id = '" . $so_id . "' AND reference = '" . $reference  . "'";
					$result_so = $conn->query($sql_so);
					while($row_so = $result_so->fetch_assoc()){
						$price = $row_so['price'];
					}
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
?>
			<tr>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<td style='border-top:1px solid #ddd;background-color:white'></td>
				<?php
					$sql_invoice = "SELECT value,ongkir FROM invoices WHERE name = '" . $invoice_name . "'";
					$result_invoice = $conn->query($sql_invoice);
					$row_invoice = $result_invoice->fetch_assoc();
					$value = $row_invoice['value'];
					$ongkir = $row_invoice['ongkir'];
					if($taxing == 1){
				?>
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
					<td>Total</td>
					<td><?= 'Rp. ' . number_format($value,2)?> </td>
				</tr>
				<?php
					}
				?>
			</tr>
			<?php
				if($ongkir == 0){
			?>
			<tr>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td style='border:none;background-color:white'></td>
				<td>Total</td>
				<td><?= 'Rp. ' . number_format($value,2)?></td>
			</tr>
			<?php
				} else {
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
				<td>Grand Total</td>
				<td><?= 'Rp. ' . number_format($value + $ongkir,2)?></td>
			</tr>
			<?php
				}
			?>
<?php
	}
?>
		</table>
<?php
	if($taxing == 1){
?>
	<button type='button' class='btn btn-primary' onclick='lihat()'>Check</button>
	<script>
	$("#piash").inputmask("999.999.99-99999999");
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
	</div>