<?php
	include("inventoryheader.php");
?>
<div class="main">
	<div class="row">
		<div class='col-sm-8'>
			<div class='row'>
<?php
	$sql = "SELECT * FROM code_delivery_order WHERE isdelete = '0' AND sent = '0'";
	$results = $conn->query($sql);
	if ($results->num_rows > 0){
		while($row_do = $results->fetch_assoc()){
			$customer_id = $row_do['customer_id'];
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer = $conn->query($sql_customer);
			while($row_customer = $result_customer->fetch_assoc()){
				$customer_name = $row_customer['name'];
			}
?>
				<div class="col-sm-3">
					<button type='button' class='btn btn-default' onclick='tutup(<?= $row_do['id'] ?>)'>X</button>
					<form action='delete_delivery_order.php' method="POST" id='form<?= $row_do['id'] ?>'>
						<input type='hidden' value='<?= $row_do['id'] ?>' name='id'>
					</form>
					<br>
					<button type='button' onclick='view(<?= $row_do['id'] ?>)' style='background-color:transparent;border:none'>
						<img src="../universal/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
					</button>
					<br>
					<p style="text-align:center"><?= $row_do['name'];?></p>
					<p style="text-align:center"><b><?= $customer_name?></b></p>	
					<p style="text-align:center">
						<a href="sent_delivery_order.php?id=<?=$row_do['id']?>" title="Confirm delivery order">
							<button type="button" class="btn btn-primary">Confirm</button>
						</a>
					</p>
				</div>
<?php
		}
?>
			</div>
		</div>
		<div class='col-sm-4' id='daniel'>
		</div>
	</div>
</div>
<script>
	function tutup(x){
		var ids = x;
		
		$('#form' + ids).submit();
	};
	
	function view(n){
		var id = n;
		$.ajax({
			url: "Ajax/view_do.php",
			data: {term: id},
			success: function(result){
				$("#daniel").html(result);
			}
		});
	}
</script>
<?php
	} else {
?>
			<div class="col-sm-6 offset-lg-3" style="text-align:center">
<?php
		echo ('There are no delivery order need to be approved');
?>
			</div>	
<?php
	}
?>
	</div>
</div>