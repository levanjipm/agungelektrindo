<?php
	include('accountingheader.php');
	$customer_id = $_GET['customer_id'];
	$sql_customer = "SELECT * FROM customer WHERE id = '" . $customer_id . "'";
	$result_customer = $conn->query($sql_customer);
	$customer = $result_customer->fetch_assoc();
	
?>
<style>
	.box_do{
		padding:100px 30px;
		box-shadow: 3px 3px 3px 3px #888888;
	}
	.icon_wrapper{
		position:relative;
	}
	.view_wrapper{
		position:fixed;
		top:30px;
		right:0px;
		margin-left:0;
		width:30%;
		background-color:#eee;
		padding:20px;
	}
	.active_tab{
		border-bottom:2px solid #5cb85c;
	}
	.tab_top{
		cursor:pointer;
	}
</style>
<body>
<div class='main'>
	<h2 style='font-family:bebasneue'><?= $customer['name'] ?></h2>
	<p><?= $customer['address'] ?></p>
	<p><?= $customer['city'] ?></p>
	<hr>
	<div class='row' style='font-family:bebasneue'>
		<div class='col-sm-2 active_tab tab_top' onclick='show_receivable(1)'>
			<h3>Show all</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='show_receivable(2)'>
			<h3>< 30 days</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='show_receivable(3)'>
			<h3>30 - 45 days</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='show_receivable(4)'>
			<h3>45 - 60 days</h3>
		</div>
		<div class='col-sm-2 tab_top' onclick='show_receivable(5)'>
			<h3>> 60 days</h3>
		</div>
	</div>
	<br>
	<div id='view_invoices'></div>
</div>
</body>
<script>
$('.tab_top').click(function(){
	$('.tab_top').removeClass('active_tab');
	$(this).addClass('active_tab');
});
$(window).ready(function(){
	show_receivable(1);
});

function show_receivable(n){
	$.ajax({
		url:'show_receivable_customer.php',
		data:{
			type:n,
			customer_id:<?= $customer_id ?>,
		},
		type:'POST',
		success:function(response){
			$('#view_invoices').html(response);
		}
	})
}
</script>