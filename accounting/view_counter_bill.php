<?php
	include('accountingheader.php');
?>
<style>
	.counter_wrapper{
		background-color:#eee;
	}
	.btn-caret{
		background-color:transparent;
		border:none;
		outline:none;
		position:absolute;
		right:0;
		top:40%;
	}
	.counter_detail{
		position:absolute;
		background-color:#333;
		padding:15px;
		color:white;
	}
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
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Counter Bill</h2>
	<p>View and edit counter bill</p>
	<hr>
<?php
	$sql = "SELECT DISTINCT(counter_id) FROM invoices WHERE counter_id IS NOT NULL AND isdone = '0'";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$sql_counter = "SELECT * FROM counter_bill WHERE id = '" . $row['counter_id'] . "'";
		$result_counter = $conn->query($sql_counter);
		$counter = $result_counter->fetch_assoc();
		
		$sql_customer = "SELECT name FROM customer WHERE id = '" . $counter['customer_id'] . "'";
		$result_customer = $conn->query($sql_customer);
		$customer = $result_customer->fetch_assoc();
		
?>
	<div class='row'>
		<div class='col-sm-3 counter_wrapper' id='caret_left<?= $counter['id'] ?>'>
			<h4 style='font-family:bebasneue'><?= $counter['name'] ?></h4>
			<p><?= $customer['name'] ?></p>
			<button type='button' class='btn btn-caret' onclick='view_detail(<?= $counter['id'] ?>)'>
				<i class="fa fa-caret-right" aria-hidden="true"></i>
			</button>
		</div>
		<div class='col-sm-4 counter_detail' style='display:none' id='caret_detail<?= $counter['id'] ?>'>
			<h4 style='font-family:bebasneue'>Invoices</h4>
			<hr>
<?php
	$sql_detail = "SELECT * FROM invoices WHERE counter_id = '" . $row['counter_id'] . "'";
	$result_detail = $conn->query($sql_detail);
	while($detail = $result_detail->fetch_assoc()){
?>
			<div class='row'>
				<div class='col-sm-6'>
					<?= $detail['name'] ?>
				</div>
				<div class='col-sm-6'>
					Rp. <?= number_format($detail['value'],2) ?>
				</div>
			</div>
			<br>
<?php
	}
?>
		<button type='button' class='btn btn-danger' onclick='show_delete(<?= $row['counter_id'] ?>)'>Delete</button>
		</div>
	</div>
<?php
	}
?>
</div>
<div class='notification_large' style='display:none'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this counter bill?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
		<input type='hidden' value='0' id='delete_id'>
	</div>
</div>
<script>
	function view_detail(n){
		var top = $('#caret_left' + n).top;
		var left = $('#caret_left' + n).width();
		var far_left = parseInt($('.main').css('marginLeft'));
		$('div[id^="caret_detail"]').fadeOut();
		$('#caret_detail' + n).css('top',top);
		$('#caret_detail' + n).css('left',left + far_left + 35);
		$('#caret_detail' + n).fadeIn();
	}
	function show_delete(n){
		$('.notification_large').fadeIn();
		$('#delete_id').val(n);
	}
	$('.btn-back').click(function(){
		$('.notification_large').fadeOut();
	});
	$('.btn-delete').click(function(){
		$.ajax({
			url:'delete_counter_bill.php',
			data:{
				id: $('#delete_id').val(),
			},
			type:'POST',
			success:function(response){
				location.reload();
			}
		})
	});
			
</script>