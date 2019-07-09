<?php
	include('salesheader.php');
	ob_start();
	$do_name = $_POST['do'];
	$sql = "SELECT * FROM code_delivery_order WHERE name = '" . $do_name . "'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()) {
		$do_id = $row['id'];
		};
	} else {
?>
	<script>
		window.location.replace('return_dashboard.php?alert=1');
	</script>
<?php
	};
?>
	<div class="main">
	<h2 style="text-align:center">
	<b>Submission of returns</b>
	</h2>
	<br>
		<form method="POST" action="return_input.php" id="return_form">
			<input type="hidden" value="<?= $do_id ?>" name="do_id">
			<table class="table">
				<thead>
					<tr>
						<th>Reference</th>
						<th>Sent quantity</th>
						<th>Return quantity</th>
					</tr>
				</thead>
				<tbody>
<?php
	$i = 1;
	$sql_item = "SELECT * FROM delivery_order WHERE do_id = '" . $do_id . "'";
	$result_item = $conn->query($sql_item);
	if ($result_item->num_rows > 0){
		while($row = $result_item->fetch_assoc()) {
			$item = $row['reference'];
			$sql_code_return = "SELECT id FROM code_sales_return WHERE do_id = '" . $do_id . "'";
			$result_code_return = $conn->query($sql_code_return);
			$code_return = $result_code_return->fetch_assoc();
			$sql_return = "SELECT quantity FROM sales_return WHERE reference = '" . $item . "' AND return_code = '" . $code_return['id'] . "'";
			$result_return = $conn->query($sql_return);
			$return = $result_return->fetch_assoc();
			$quantity = $row['quantity'];
?>
					<tr>
						<td><?= $item ?><input type='hidden' value='<?= $item ?>' name='item<?= $i ?>'></td>
						<td><?= $quantity - $return['quantity'] ?></td>
						<td><input type="number" class="form-control" name="return_quantity<?= $i ?>" max="<?= $quantity - $return['quantity'] ?>" min=0></td>
					</tr>
<?php
		$i++;
		};
?>
		<input type="hidden" value="<?= $i - 1 ?>" name="x">
<?php
	} else {
	};
?>
				</tbody>
			</table>
			<br>
			<label>Reason of return</label>
			<select class='form-control' name="reason" onchange='other()' id='reason'>
			<?php
				$sql_reason = "SELECT * FROM reason";
				$result_reason = $conn->query($sql_reason);
				while($row_reason = $result_reason->fetch_assoc()){
			?>
					<option value='<?= $row_reason['id'] ?>'><?= $row_reason['name'] ?></option>
			<?php
				}
			?>
				<option value='0'>Other reason (Please contact your administrator to tell the reason)</option>
			</select>
			<br>
			<input type='text' class='form-control' id='other_reason' placeholder='Type here....' style='display:none' name='other'>
			<script>
				function other(){
					if($('#reason').val() == 0){
						$('#other_reason').show();
						$('#other_reason').attr('required','true');
					} else {
						$('#other_reason').hide();
						$('#other_reason').attr('required','false');
					}
				}
			</script>
			<br>
			<button class="btn btn-primary">Proceed</button>
		</form>
	</div>