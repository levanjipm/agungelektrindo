	<?php
		include('inventoryheader.php');
	?>
	<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
	</style>
<div class="main">
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p>Confirm good receipt</p>
	<hr>
	<div class="row">
		<div class='col-sm-8'>
			<div class='row'>				
<?php
	$sql = "SELECT id,supplier_id,date FROM code_goodreceipt WHERE isconfirm = '0' ORDER BY date ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_supplier = "SELECT name,city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier = $conn->query($sql_supplier);
		$row_supplier = $result_supplier->fetch_assoc();
		$supplier_name = $row_supplier['name'];
		$supplier_city = $row_supplier['city'];
?>
				<div class="col-sm-3">
					<button type='button' class='btn btn-x' onclick='tutup(<?= $row['id'] ?>)'>X</button>
					<button onclick='view(<?= $row['id'] ?>)' id='<?= $row['id'] ?>' style='background-color:transparent;border:none'>
						<img src="../universal/images/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
					</button>
					<br>
					<div style='text-align:center'>
						<?= "<strong>" . $supplier_name . "</strong><br>" ?>
						<?= $supplier_city . "<br>" ?>
						<?= "Date:" . date('d M Y',strtotime($row['date']))?>
						<br>
						<button type="button" class="btn btn-primary" onclick='confirm_gr(<?= $row['id']?>)'>Confirm</button>
					</div>
				</div>
<?php
	}
?>
			</div>
		</div>
		<div class='col-sm-4' style='height:100%' id='daniel'>
		</div>
	</div>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this goods receipt</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
		<input type='hidden' value='0' id='confirm_id'>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to confirm this goods receipt</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
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
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	function tutup(n){
		$('#delete_id').val(n);
		$('#delete_notification').fadeIn();
	}
	function confirm_gr(n){
		$('#confirm_id').val(n);
		$('#confirm_notification').fadeIn();
	}
	$('.btn-confirm').click(function(){
		$.ajax({
			url:'confirm_goodreceipt.php',
			data:{
				id:$('#confirm_id').val(),
			},
			type:'POST',
			success:function(){
				location.reload();
			},
		})
	});
	$('.btn-delete').click(function(){
		$.ajax({
			url:'cancel_goodreceipt.php',
			data:{
				id:$('#delete_id').val(),
			},
			type:'GET',
			success:function(){
				location.reload();
			},
		})
	});
</script>