<?php	
	include('../../codes/connect.php');
	$date = $_POST['date'];
?>
	<table class='table'>
		<tr>
			<th>Date</th>
			<th>Document name</th>
			<th colspan='2'>Items</th>
		</tr>
<?php
	$supplier_id = $_POST['supplier'];
	$sql = "SELECT id,document,date FROM code_goodreceipt 
	WHERE supplier_id = '" . $supplier_id . "' 
	AND isinvoiced = '0' AND isconfirm = '1'";
	$i = 1;
	$result = $conn->query($sql);
	if(!$result){
?>
		<td colspan='4'>No result found!</td>
<?php
	}
		while($row = $result->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($row['date'])) ?></td>
			<td><?= $row['document']; ?></td>
			<input type='hidden' value='<?= $row['id'] ?>' id='document-<?= $i ?>'>
			<td>
				<button type='button' class='btn btn-default' onclick='include_gr(<?= $i ?>)' id='okin<?= $i ?>'>Include</button>
				<button type='button' class='btn btn-primary' onclick='exclude_gr(<?= $i ?>)' style='display:none' id='gaok<?= $i ?>'>Cancel</button>
			</td>
			<td>
				<button type='button' class='btn btn-default' onclick='show_detail(<?= $i ?>)' id='plus<?= $i ?>'>+</button>
				<button type='button' class='btn btn-primary' onclick='hide_detail(<?= $i ?>)' style='display:none' id='minus<?= $i ?>'>-</button>
			</td>
		</tr>
		<tbody id='body<?= $i ?>' style='display:none'>
<?php
			$sql_detail = "SELECT received_id,quantity FROM goodreceipt WHERE gr_id = '" . $row['id'] . "'";
			$result_detail = $conn->query($sql_detail);
			while($detail = $result_detail->fetch_assoc()){
?>
			<tr>
				<td><?php
					$sql_received 			= "SELECT reference FROM purchaseorder_received WHERE id = '" . $detail['received_id'] . "'";
					$result_received 		= $conn->query($sql_received);
					$received 				= $result_received->fetch_assoc();
					echo $received['reference'];
				?></td>
				<td><?php
					$sql_item 				= "SELECT description FROM itemlist WHERE reference = '" . $received['reference'] . "'";
					$result_item 			= $conn->query($sql_item);
					$item 					= $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $detail['quantity'] ?></td>
			</tr>
<?php
			}
?>
			
		</tbody>
<?php
		$i++;
		}
?>
	</table>
	<input type='hidden' value='<?= $i ?>' name='x'>
	<button type='button' id='submit_debt_documents_button' class='btn btn-success'>Submit Form</button>
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
		function show_detail(n){
			$('#body' + n).show();
			$('#plus' + n).hide();
			$('#minus' + n).show();
		}
		function hide_detail(n){
			$('#body' + n).hide();
			$('#plus' + n).show();
			$('#minus' + n).hide();
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