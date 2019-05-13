	<?php
		include('inventoryheader.php');
	?>
	<style>
		.trans{
			background-color:transparent;
			border:none;
		}
	</style>
	<div class="main">
		<div class="row">
			<div class='col-lg-8'>
	<?php
		$sql = "SELECT id,supplier_id,date FROM code_goodreceipt WHERE isconfirm = '0'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
			$result_supplier = $conn->query($sql_supplier);
			while($row_supplier = $result_supplier->fetch_assoc()){
				$supplier_name = $row_supplier['name'];
				$supplier_city = $row_supplier['city'];
			}
	?>
			<div class="col-lg-3">
				<button class='trans' onclick='view(<?= $row['id'] ?>)' id='<?= $row['id'] ?>'>
					<img src="../universal/images/document.png" style="width:100%;padding:20px">
				</button>
				<?= "<strong>" . $supplier_name . "</strong><br>" ?>
				<?= $supplier_city . "<br>" ?>
				<?= "Date:" . $row['date']?>
				<a href="confirm_goodreceipt.php?id=<?= $row['id']?>" style="text-decoration:none">
					<button type="button" class="btn btn-primary">Confirm</button>
				</a>
				<a href="cancel_goodreceipt.php?id=<?= $row['id']?>" style="text-decoration:none">
					<button type="button" class="btn btn-danger">Cancel</button>
				</a>
			</div>
	<?php
		}
	?>
			</div>
			<div class='col-lg-4' style='height:100%' id='daniel'>
			</div>
		</div>
	</div>
<script>
	function view(n){
		var id = n;
		$.ajax({
			url: "Ajax/view.php",
			data: {term: id},
			success: function(result){
				$("#daniel").html(result);
			}
		});
	}
</script>