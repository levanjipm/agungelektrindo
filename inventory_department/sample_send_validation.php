<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
	
	$id						= $_POST['id'];
	$sql					= "SELECT code_sample.id, customer.name, customer.address, customer.city
								FROM code_sample 
								JOIN customer ON code_sample.customer_id = customer.id
								WHERE code_sample.id = '$id'";
	$result					= $conn->query($sql);
	$row					= $result->fetch_assoc();
	$sample_id				= $row['id'];
	$customer_name			= $row['name'];
	$customer_address		= $row['address'];
	$customer_city			= $row['city'];
?>
<head>
	<title>Validate sample</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sample</h2>
	<p style='font-family:museo'>Validate sample</p>
	<hr>
	<label>Customer data</label>
	<p style='font-family:museo'><?= $customer_name ?></p>
	<p style='font-family:museo'><?= $customer_address ?></p>
	<p style='font-family:museo'><?= $customer_city ?></p>
	
	<label>Send date</label>
	<form action='sample_send_input.php' method='POST' id='sample_form'>
	<input type='date' class='form-control' id='date' name='send_sample_date'>
	<br>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Reference</th>
				<th>Description</th>
				<th>Quantity</th>
				<th>Send</th>
			</tr>
		</thead>
		<tbody>
<?php
	$validation				= TRUE;
	$sql					= "SELECT sample.id, sample.reference, itemlist.description, sample.quantity, sample.sent
								FROM sample 
								JOIN itemlist ON sample.reference = itemlist.reference
								WHERE sample.code_id = '$id'";
	$result					= $conn->query($sql);
	while($row				= $result->fetch_assoc()){
		
		$sample_id			= $row['id'];
		$reference			= $row['reference'];
		$description		= $row['description'];
		$quantity			= $row['quantity'];
		$sent				= $row['sent'];
		
		$sql_stock			= "SELECT stock FROM stock WHERE reference = '$reference'";
		$result_stock		= $conn->query($sql_stock);
		$stock				= $result_stock->fetch_assoc();
		
		$stock_level		= $stock['stock'];
		
		if($quantity < $stock_level){
			$vaildation		= FALSE;
		}
?>
			<tr>
				<td><?= $reference ?></td>
				<td><?= $description ?></td>
				<td><?= number_format($quantity - $sent,0) ?></td>
				<td><input type='number' class='form-control' name='quantity[<?= $sample_id ?>]' id='quantity-<?= $sample_id ?>' max='<?= $quantity - $sent ?>' min='0'></td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
	</form>
<?php if($validation			== TRUE){ ?>
	<button type='button' class='button_success_dark' id='submit_button'>Submit</button>
	<script>
		function validate_form(){
			if($('#date').val() == ''){
				alert('Please insert date');
				$('#date').focus();
				return false;
			} else {
				$('input[id^="quantity-"]').each(function(){
					var maximum		= $(this).attr('max');
					var minimum		= $(this).attr('min');
					
					if($(this).val() > maximum || $(this).val() <= minimum){
						alert('Plese insert correct quantity');
						$(this).focus();
						return false;
					}
				});
			}
		};
		
		$('#submit_button').click(function(){
			var validation = validate_form();
			alert(validation);
		});
		
		$(document).ready(function() {
			$(window).keydown(function(event){
				if(event.keyCode == 13) {
					event.preventDefault();
					return false;
				}
			});
		});
	</script>
<?php } ?>
</div>