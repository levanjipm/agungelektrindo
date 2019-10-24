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
<?php
	$sql = "SELECT id,supplier_id,date,document FROM code_goodreceipt WHERE isconfirm = '0' ORDER BY date ASC";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '" . $row['supplier_id'] . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$row_supplier		= $result_supplier->fetch_assoc();
		$supplier_name	 	= $row_supplier['name'];
		$supplier_city	 	= $row_supplier['city'];
?>
			<div class="col-sm-2">
				<button type='button' class='btn btn-x' onclick='tutup(<?= $row['id'] ?>)'>X</button>
					<img src="../universal/images/document.png" style=" display: block;width:50%;margin-left:auto;margin-right:auto">
				<br>
				<div style='text-align:center'>
					<p style='line-height:1'><strong><?= $supplier_name ?></strong></p>
					<p style='line-height:0.8'><?= date('d M Y',strtotime($row['date']))?></p>
					<p style='line-height:0.8'><?= $row['document']?></p>					
					<button type="button" class="button_default_dark" onclick='view_good_receipt(<?= $row['id']?>)'>Confirm</button>
				</div>
			</div>
<?php
	}
?>
	</div>
</div>
<style>
	.view_good_receipt_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_good_receipt_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_good_receipt_view{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
<div class='view_good_receipt_wrapper'>
	<button id='button_close_good_receipt_view'>X</button>
	<div id='view_good_receipt_box'>
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
	function view_good_receipt(n){
		$.ajax({
			url: "Ajax/view_good_receipt.php",
			data: {term: n},
			success: function(result){
				$('#view_good_receipt_box').html(result);
				$('.view_good_receipt_wrapper').fadeIn();
			}
		});
	}
	
	$('#button_close_good_receipt_view').click(function(){
		$('.view_good_receipt_wrapper').fadeOut();
	});
	
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	
	function tutup(n){
		$('#delete_id').val(n);
		$('#delete_notification').fadeIn();
	}
	
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
	
	function confirm_goods_receipt(n){
		$.ajax({
			url:'confirm_goodreceipt.php',
			data:{
				id: n,
			},
			type:'POST',
			success:function(){
				location.reload();
			},
		})
	};
</script>