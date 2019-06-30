<?php	
	include('../codes/connect.php');
	$customer_id = $_POST['customer'];
	$sql = "SELECT * FROM invoices WHERE customer_id = '" . $customer_id . "' AND isdone = '0' AND counter_id IS NULL";
?>
	<div class='input-group'>
		<input type='text' class='form-control' name='counter_bill_name' placeholder='Document name' style='width:80%'>
		<div class="input-group-append">
			<button type='button' class='btn btn-success' id='input_counter_bill_button'>
				Go
			</button>
		</div>
	</div>
	<br>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Value</th>
			<th>Delivery charge</th>
			<th></th>
		</tr>
<?php
	$x = 0;
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['name'] ?></td>
			<td>Rp. <?= number_format($row['value'],2) ?></td>
			<td>Rp. <?= number_format($row['ongkir'],2) ?></td>
			<td>
				<div class="checkbox">
					<label><input type="checkbox" value='<?= $row['id'] ?>' name='invoices[<?= $x ?>]'></label>
				</div>
			</td>
		</tr>
<?php
	$x++;
	}
?>
	</table>
	<script>
	$('#input_counter_bill_button').click(function(){
		if($( "input:checked" ).length == 0){
			alert('Please choose an invoice!');
		} else {
			submiting_form();
		}
	})
	</script>