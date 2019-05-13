<?php
	include("connect.php");
	include("purchasingheader.php");
	$po_id = $_POST['po'];
?>
<div class="main" style="padding:20px">
<?php
	$sql = "SELECT * FROM purchaseorder WHERE purchaseorder_id = '" . $po_id . "' AND status = 0";
	$result = $conn->query($sql);
?>
<form action="goodreceipt_validation.php" method="POST" id="myForm">
	<table class="table">
		<thead>
			<th style="width:30%">Item name</th>
			<th style="width:10%">Quantity</th>
			<th style="width:20%">Item Received</th>
		</thead>
		<tbody>
<?php
	while($row = $result->fetch_assoc()) {
?>
			<tr>
				<td><?php
					$ref = $row['reference'];
					echo $row['reference'] ?>
				</td>
				<td><?php
					$qty_order = $row['quantity'];
				?>
					<input class="form-control" type="text" value="<?= $qty_order ?>" readonly name="ordered[]" uid="<?= $row['id'] ?>">
				</td>
				<td>
					<input class="form-control" type="text" name="qty_receive[]" uid="<?= $row['id'] ?>">
				</td>
				<?php
					}
				?>
			</tr>
		</tbody>
	</table>
	<div class="row">
		<button type="button" class="btn btn-primary" onclick="validate()">Submit Good Receipt</button>
	</div>
</form>
</div>
<script>
function validate(){
	$('[name="ordered[]"]').each(function(idx,elem){
		var uid = $(elem).attr('uid');
		var rec = $('[name="qty_receive[]"][uid=' + uid + ']').val();
		console.log(rec);
		console.log($(elem).val());
		rec = parseInt(rec);
		var quantity = parseInt($(elem).val());
		if (rec > quantity){
			alert ('cannot insert more than ordered');
		} else {
			alert ('b');
		}
	
	})
};
</script>