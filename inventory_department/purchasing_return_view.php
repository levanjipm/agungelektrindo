<?php
	include('../codes/connect.php');
	$sql				= "SELECT code_purchase_return_sent.document, code_purchase_return_sent.id, supplier.name
							FROM code_purchase_return_sent 
							JOIN code_purchase_return ON code_purchase_return_sent.code_purchase_return_id = code_purchase_return.id
							JOIN supplier ON code_purchase_return.supplier_id = supplier.id
							WHERE code_purchase_return_sent.isconfirm = '0'";
	$result				= $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
?>
		<p style='font-family:museo'>There is no return to confirm</p>
<?php
	} else {
?>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>Document</th>
				<th>Supplier</th>
				<th></th>
			</tr>
		</thead>
<?php
		while($row			= $result->fetch_assoc()){
			$document		= $row['document'];
			$supplier_name	= $row['name'];
			$sent_id		= $row['id'];
?>
			<tr>
				<td><?= $document ?></td>
				<td><?= $supplier_name ?></td>
				<td><button type='button' class='button_success_dark' onclick='submit(<?= $sent_id ?>)'><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button></td>
			</tr>
<?php			
		}
?>
	</table>
</div>
<form action='purchasing_return_confirm_validation' method='POST' id='purchasing_return_form'>
	<input type='hidden' id='return_id' name='id'>
</form>
<script>
	function submit(n){
		$('#return_id').val(n);
		$('#purchasing_return_form').submit();
	}
</script>
<?php
	}
?>