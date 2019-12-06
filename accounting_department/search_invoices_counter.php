<?php	
	include('../codes/connect.php');
	$customer_id = $_POST['customer'];
	$sql = "SELECT * 
	FROM invoices 
	JOIN code_delivery_order
	ON code_delivery_order.id = invoices.do_id
	WHERE code_delivery_order.customer_id = '" . $customer_id . "' 
	AND invoices.isdone = '0' AND invoices.counter_id IS NULL";
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
		z-index:20;
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
	<input type='hidden' value='<?= $customer_id ?>' name='customer'>
	<div class='input-group'>
		<input type='text' class='form-control' name='counter_bill_name' placeholder='Document name' style='width:80%' id='counter_bill_name'>
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
	<div class='notification_large' style='display:none' id='confirm_notification'>
		<div class='notification_box'>
			<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
			<h2 style='font-family:bebasneue'>Are you sure to confirm this counter bill?</h2>
			<p>We detected that you did not input any counter bill number</p>
			<br>
			<button type='button' class='btn btn-back'>Back</button>
			<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
		</div>
	</div>
	<script>
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	$('#input_counter_bill_button').click(function(){
		if($( "input:checked" ).length == 0){
			alert('Please choose an invoice!');
		} else if($('#counter_bill_name').val() == ''){
			$('#confirm_notification').fadeIn();
		} else {
			submiting_form();
		}
	});
	$('#confirm_button').click(function(){
		submiting_form();
	});
	</script>