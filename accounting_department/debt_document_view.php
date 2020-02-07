<?php	
	include('../codes/connect.php');
	$date 				= $_POST['date'];
	$supplier_id 		= (int) $_POST['supplier'];
	$sql_supplier		= "SELECT name, address, city FROM supplier WHERE id = '$supplier_id'";
	$result_supplier	= $conn->query($sql_supplier);
	$supplier			= $result_supplier->fetch_assoc();
	
	$supplier_name		= $supplier['name'];
	$supplier_address	= $supplier['address'];
	$supplier_city		= $supplier['city'];
	
	$sql 				= "SELECT id, document, date FROM code_goodreceipt
							WHERE supplier_id = '$supplier_id' AND isinvoiced = '0' AND isconfirm = '1'";
	$result 			= $conn->query($sql);
?>
	<h2 style='font-family:bebasneue'>Good receipts</h2>
	
	<label>Supplier</label>
	<p style='font-family:museo'><?= $supplier_name ?></p>
	<p style='font-family:museo'><?= $supplier_address ?></p>
	<p style='font-family:museo'><?= $supplier_city ?></p>
	<br>
<?php
	if(mysqli_num_rows($result) == 0){
?>
	<p style='font-family:museo'>There is no good receipt found</p>
<?php
	} else {
		$i = 1;
?>
	<form method='POST' action='debt_document_validation' id='debt_select_form'>
	
	<label>Invoice date</label>
	<input type='hidden' value='<?= $date ?>' name='date'>
	<p style='font-family:museo'><?= date('d M Y',strtotime($date)) ?></p>
	
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Document name</th>
			<th>Action</th>
		</tr>
<?php
		while($row = $result->fetch_assoc()){
			$date		= $row['date'];
			$id			= $row['id'];
			$document	= $row['document'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($date)) ?></td>
			<td><?= $document; ?></td>
			<input type='hidden' value='<?= $id ?>' id='document-<?= $i ?>'>
			<td>
				<button type='button' class='button_default_dark' onclick='include_gr(<?= $i ?>)' id='okin<?= $i ?>'><i class='fa fa-cart-plus'></i></button>
				<button type='button' class='button_danger_dark' onclick='exclude_gr(<?= $i ?>)' style='display:none' id='gaok<?= $i ?>'><i class='fa fa-trash'></i></button>
			</td>
		</tr>
<?php
		$i++;
		}
?>
	</table>
	<input type='hidden' value='<?= $i ?>' name='x'>
	<button type='button' id='submit_debt_documents_button' class='button_success_dark'><i class='fa fa-long-arrow-right'></i></button>
	</form>
	<script>
		function include_gr(n){
			$('#document-' + n).attr('name', 'document[' + n + ']')
			$('#okin' + n).hide();
			$('#gaok' + n).show();
		}
		function exclude_gr(n){
			$('#document-' + n).attr('name', '')
			$('#okin' + n).show();
			$('#gaok' + n).hide();
		}
		
		$('#submit_debt_documents_button').click(function(){
			if($('#date').val() == ''){
				alert('Please insert date!');
				$('#date').focus();
				return false;
			} else {
				$('#debt_select_form').submit();
			}
		});
	</script>
<?php
	}
?>