<?php
	include('salesheader.php');
?>
<div class='main'>
	<h2>Sample</h2>
	<p>Confirm or cancel sampling</p>
	<hr>
	<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	</script>
	<table class='table table-hover'>
		<tr>
			<th>Date submited</th>
			<th>Submited by</th>
			<th>Customer name</th>
			<th></th>
		</tr>
<?php
	$sql_code = "SELECT * FROM code_sample WHERE isconfirm = '0'";
	$result_code = $conn->query($sql_code);
	while($code = $result_code->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?php
				$sql_created = "SELECT name FROM users WHERE id = '" . $code['created_by'] . "'";
				$result_created = $conn->query($sql_created);
				$created = $result_created->fetch_assoc();
				echo $created['name'];
			?></td>
			<td><?php
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
				$result_customer = $conn->query($sql_customer);
				$customer = $result_customer->fetch_assoc();
				echo $customer['name'];
			?></td>
			<td>
				<button type='button' class='btn btn-default' title="Confirm sample" onclick='confirm(<?= $code['id'] ?>)'><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
				<button type='button' class='btn btn-secondary' title="Cancel sample" onclick='cancel(<?= $code['id'] ?>)'><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
			</td>
		</tr>
<?php
		$sql_detail = "SELECT * FROM sample WHERE code_id = '" . $code['id'] . "'";
		$result_detail = $conn->query($sql_detail);
		while($detail = $result_detail->fetch_assoc()){
?>
			<tr>
				<td><?= $detail['reference'] ?></td>
				<td><?php
					$sql_item = "SELECT description FROM itemlist WHERE reference = '" . $detail['reference'] . "'";
					$result_item = $conn->query($sql_item);
					$item = $result_item->fetch_assoc();
					echo $item['description'];
				?></td>
				<td><?= $detail['quantity'] ?></td>
				<td></td>
			</tr>
<?php
		}
	}
?>
		</table>
	</div>
</div>
<script>
	function confirm(n){
		$.ajax({
			url:"confirm_sampling.php",
			data:{
				id: n,
				type : 1,
			},
			type: 'POST',
			success:function(response){
			},
		})
	};
	function cancel(n){
		$.ajax({
			url:"confirm_sampling.php",
			data:{
				id: n,
				type : 2,
			},
			type: 'POST',
			success:function(response){
			},
		})
	};
</script>