<head>
	<title>Sales Department</title>
</head>
<?php
	include('header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<script src='/agungelektrindo/universal/chartist/dist/chartist.min.js'></script>
	<link rel='stylesheet' href='/agungelektrindo/universal/chartist/dist/chartist.min.css'>
</head>
<style>
	.ct-label {
		font-size: 10px;
		font-family:museo;
		color:#333;
	}
	
	.ct-chart{
		height:300px;
	}
	
	.box{
		padding:10px;
		background-color:#fff;
		color:#024769;
		border:3px solid #024769;
		text-align:center;
		cursor:pointer;
		width:25%;
		display:inline-block;
		margin-left:2%;
	}

	.box:hover{
		background-color:#eee;
		color:#333;
		transition:0.3s all ease;
	}

	.bar_wrapper{
		position:relative;
		background-color:#fff;
		width:100%;
		height:5px;
	}

	.bar{
		position:absolute;
		top:0;
		height:100%;
		background-color:#aaa;
		transition:0.5s all ease;
	}
</style>
<?php
	$sql_pending_sales_order		= "SELECT COUNT(DISTINCT(so_id)) as pending_sales_order FROM sales_order WHERE status = '0'";
	$result_pending_sales_order		= $conn->query($sql_pending_sales_order);
	$pending_sales_order			= $result_pending_sales_order->fetch_assoc();
	
	$pending						= $pending_sales_order['pending_sales_order'];
	
	$sql_ongoing_project			= "SELECT id FROM code_project WHERE isdone = '0'";
	$result_ongoing_project			= $conn->query($sql_ongoing_project);
	$ongoing_project				= mysqli_num_rows($result_ongoing_project);
	
	$sql				= "SELECT id FROM customer";
	$result				= $conn->query($sql);
	$customer_count		= mysqli_num_rows($result);
	$active_customer	= 0;
	while($row			= $result->fetch_assoc()){
		$customer_id	= $row['id'];
		
		$sql_date		= "SELECT MAX(date) as date FROM code_delivery_order WHERE customer_id = '$customer_id'";
		$result_date	= $conn->query($sql_date);
		$date			= $result_date->fetch_assoc();
		
		$date_1			= $date['date'];
		
		$sql_date		= "SELECT MAX(date) as date FROM code_salesorder WHERE customer_id = '$customer_id'";
		$result_date	= $conn->query($sql_date);
		$date			= $result_date->fetch_assoc();
		
		$date_2			= $date['date'];
		
		$last_transaction		= max($date_1, $date_2);
		
		if($last_transaction >= date('Y-m-d',strtotime('-3month'))){
			$active_customer++;
		}
	}
?>
<div class='main'>
	<div class='row'>
		<div class='col-md-12 col-sm-12 col-xs-12'>
			<div class='box'>
				<h1><?= $pending ?></h1>
				<h5>Pending sales order</h5>
				<div class='bar_wrapper'>
					<div class='bar' id='pending_sales_order_bar'></div>
				</div>
				<script>
					$(document).ready(function(){
						$('#pending_sales_order_bar').animate({
							width: "<?= min(100, ($pending * 2)) ?>%"
						},300)
					});
				</script>
			</div>
			<div class='box'>
				<h1><?= $ongoing_project ?></h1>
				<h5>Ongoing project(s)</h5>
				<div class='bar_wrapper'>
					<div class='bar' id='ongoing_project_bar'></div>
				</div>
				<script>
					$(document).ready(function(){
						$('#ongoing_project_bar').animate({
							width: "<?= max(10, ($ongoing_project * 10)) ?>%"
						},300)
					});
				</script>
			</div>
			<div class='box'>
				<h1><?= $active_customer . ' / ' . $customer_count ?></h1>
				<h5>Active customers</h5>
				<div class='bar_wrapper'>
					<div class='bar' id='active_customer_bar'></div>
				</div>
				<script>
					$(document).ready(function(){
						$('#active_customer_bar').animate({
							width: "<?= ($active_customer * 100 / $customer_count) ?>%"
						},300)
					});
				</script>
			</div>
		</div>
	</div>
<?php
	if($role == 'superadmin'){
?>
	<br><br><br>
	<div class='row'>
		<div class='col-sm-7' id='sales_chart_line'></div>
		<div class='col-sm-5' id='sales_chart_horizontal'></div>
	</div>
	<script>
		$.ajax({
			url:'/agungelektrindo/sales_department/sales_chart_line.php',
			success:function(response){
				$('#sales_chart_line').html(response);
			}
		});
		
		$.ajax({
			url:'/agungelektrindo/sales_department/sales_chart_horizontal.php',
			success:function(response){
				$('#sales_chart_horizontal').html(response);
			}
		});
	</script>
<?php
	}
?>
	<h3 style='font-family:bebasneue'>General Sales Info</h3>
	<br>
	<table class='table table-bordered' style='font-family:museo'>
		<tr>
			<td><strong>NPWP</strong></td>
			<td>72.418.271.2-423.000</td>
			<td>
				<a href='/agungelektrindo/universal/asset/npwp.pdf' style='text-decoration:none' target='_blank'>
					<button type='button' class='button_default_dark'>
						<i class="fa fa-download" aria-hidden="true"></i>
					</button>
				</a>
			</td>
		</tr>
		<tr>
			<td><strong>SPPKP</strong></td>
			<td>S-145PKP/WPJ.09/KP.0203/2015</td>
			<td>
				<a href='/agungelektrindo/universal/asset/sppkp.pdf' style='text-decoration:none' target='_blank'>
					<button type='button' class='button_default_dark'>
						<i class="fa fa-download" aria-hidden="true"></i>
					</button>
				</a>
			</td>
		</tr>
		<tr>
			<td>Alamat PKP</td>
			<td>Jalan Jamuju no. 18 RT 005/ RW 006, <br>Kelurahan Cihapit, Kecamatan Bandung Wetan, Bandung</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>Nomor Rekening </td>
			<td>Bank Central Asia<br>
				Cabang Ahmad Yani II<br>
				Nomor: 8090249500<br>
				Atas nama: CV Agung Elektrindo
			<td id='td_bank'>
				<button type='button' class='button_default_dark' id='bank_payment_button'><i class="fa fa-clone" aria-hidden="true"></i></button>
			</td>
		</tr>
	</table>
</div>
<script>
$('#bank_payment_button').click(function(){
	$('#td_bank').append(
		"<textarea id='payment_narator' style='white-space: pre-wrap;'>Mohon pembayaran dilakukan ke nomor rekening sebagai berikut\r\nBank: Bank Central Asia Cabang Ahmadi Yani II, Bandung.\r\nNomor rekening: 8090249500.\r\nAtas nama: CV Agung Elektrindo'</textarea>"
	)
	var brRegex = /<br\s*[\/]?>/gi;
	var input = document.getElementById('payment_narator');
	
	input.focus();
	input.select();
	document.execCommand("copy");
	
	$('#payment_narator').remove();
})
</script>