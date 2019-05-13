<?php	
	include('../../codes/connect.php');
	$date = $_POST['date'];
?>
	<h2><?= date('d M Y',strtotime($date)) ?></h2>
	<table class='table'>
		<tr>
			<th>Document name</th>
			<th colspan='2'>Items</th>
		</tr>
<?php
	$supplier_id = $_POST['supplier'];
	$sql = "SELECT id,document FROM code_goodreceipt 
	WHERE supplier_id = '" . $supplier_id . "' 
	AND date = '" . $date . "' AND isinvoiced = '0' 
	AND isconfirm = '1'";
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
			<td><?= $row['document']; ?></td>
			<input type='hidden' value='<?= $row['id'] ?>' name='document<?= $i ?>'>
			<input type='hidden' value='0' id='final-<?= $i ?>' name='final<?= $i ?>'>
			<td>
				<button type='button' class='btn btn-default' onclick='ok(<?= $i ?>)' id='okin<?= $i ?>'>Include</button>
				<button type='button' class='btn btn-primary' onclick='not_ok(<?= $i ?>)' style='display:none' id='gaok<?= $i ?>'>Cancel</button>
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
					$sql_received = "SELECT reference FROM purchaseorder_received WHERE id = '" . $detail['received_id'] . "'";
					$result_received = $conn->query($sql_received);
					$received = $result_received->fetch_assoc();
					echo $received['reference'];
				?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $received['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
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
	<button type='submit' id='reallysubmit' class='btn btn-success'>Submit Form</button>
	<script>
		function ok(n){
			$('#final-' + n).val(1);
			$('#okin' + n).hide();
			$('#gaok' + n).show();
		}
		function not_ok(n){
			$('#final-' + n).val(0);
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
	</script>