<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<head>
	<title>Confirm good receipt</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p>Confirm good receipt</p>
	<hr>
	<div class='row'>
<?php
	$sql_code_gr			= "SELECT id,supplier_id,date,document FROM code_goodreceipt WHERE isconfirm = '0' ORDER BY date ASC";
	$result_code_gr			= $conn->query($sql_code_gr);
	while($code_gr			= $result_code_gr->fetch_assoc()){
	
		$supplier_id		= $code_gr['supplier_id'];
		$gr_date			= $code_gr['date'];
		$gr_id				= $code_gr['id'];
		$gr_document		= $code_gr['document'];
		
		$sql_supplier 		= "SELECT name,city FROM supplier WHERE id = '$supplier_id'";
		$result_supplier 	= $conn->query($sql_supplier);
		$row_supplier		= $result_supplier->fetch_assoc();
		
		$supplier_name	 	= $row_supplier['name'];
		$supplier_city	 	= $row_supplier['city'];
?>	
		<div class='col-sm-2'>
			<h1 style='font-size:4em;text-align:center'><i class="fa fa-file-text-o" aria-hidden="true"></i></h1>
			<div style='text-align:center'>
				<p style='line-height:1'><strong><?= $supplier_name ?></strong></p>
				<p style='line-height:0.8'><?= date('d M Y',strtotime($gr_date))?></p>
				<p style='line-height:0.8'><?= $gr_document ?></p>					
				<button type="button" class="button_default_dark" onclick='view_good_receipt(<?= $gr_id?>)'>Confirm</button>
			</div>
		</div>
<?php
	}
?>
	</div>
</div>
<div class='full_screen_wrapper' id='view_good_receipt_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_good_receipt(n){
		$.ajax({
			url: 'good_receipt_view.php',
			data: {term: n},
			success: function(result){
				$('#view_good_receipt_wrapper .full_screen_box').html(result);
				$('#view_good_receipt_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('#view_good_receipt_wrapper').fadeOut();
	});
	
	function delete_gr(n){
		var window_height		= $(window).height();
		var notif_height		= $('.full_screen_notif_bar').height();
		var difference			= window_height - notif_height;
		$('.full_screen_notif_bar').css('top',0.7 * difference / 2);
		$('#delete_id').val(n);
		$('#delete_notification').fadeIn();
	}
	
	function delete_good_receipt(n){
		$.ajax({
			url:'good_receipt_cancel.php',
			data:{
				id: n
			},
			type:'GET',
			success:function(){
				location.reload();
			},
		})
	};
	
	function confirm_goods_receipt(n){
		$.ajax({
			url:'good_receipt_confirm.php',
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