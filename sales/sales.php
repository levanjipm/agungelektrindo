<?php
	include("salesheader.php");
	
	$sql_pending_so = "SELECT COUNT(DISTINCT(so_id)) AS jumlah_so FROM sales_order_sent WHERE status = '0'";
	$result_pending_so = $conn->query($sql_pending_so);
	$row_pending_so = $result_pending_so->fetch_assoc();
	$pending_so = $row_pending_so['jumlah_so'];
	
	$month = date('m');
	
	$month_php = $month + 1;
	$month_before_php = $month_php - 1;
	$month_last_php = $month_before_php - 1;
	$year = date('Y');
	
	if($month == 2){
		$month_php = 1;
		$month_before_php = 0;
		$month_last_php = 11;
		
		$month_before = $month - 1;
		$year_before = $year;
		
		$month_last = 12;
		$year_last = $year - 1;
		
	} else if($month == 1){
		$month_php = 0;
		$month_before_php = 11;
		$month_last_php = 10;
		
		$month_before = 12;
		$year_before = $year - 1;
		
		$month_last = 11;
		$year_last = $year - 1;
	} else {
		$month_before = $month - 1;
		$month_last = $month - 2;
		
		$year_before = $year;
		$year_last = $year;
	}
	
	$sql_annual = "SELECT SUM(value) AS sales FROM invoices WHERE YEAR(date) = '$year'";
	$result_annual = $conn->query($sql_annual);
	$annual = $result_annual->fetch_assoc();
	
	$month_now = $month;
	
	$sql_this_month = "SELECT SUM(value) AS sales FROM invoices WHERE MONTH(date) = '$month' AND YEAR(date) = '$year'";
	$result_this_month = $conn->query($sql_this_month);
	$this_month = $result_this_month->fetch_assoc();
	
	$month_now = $month - 1;
	if($month_now > $month){
		$year = $year - 1;
	}
	$sql_month_before = "SELECT SUM(value) AS sales FROM invoices WHERE MONTH(date) = '" . $month_before . "' AND YEAR(date) = '$year_before'";
	$result_month_before = $conn->query($sql_month_before);
	$month_before = $result_month_before->fetch_assoc();
	
	$month_now = $month - 2;
	if($month_now > $month || $this_month == 0){
		$year = $year - 1;
	}
	
	$sql_month_last = "SELECT SUM(value) AS sales FROM invoices WHERE MONTH(date) = '" . $month_last . "' AND YEAR(date) = '$year_last'";
	$result_month_last = $conn->query($sql_month_last);
	$month_last = $result_month_last->fetch_assoc();
	
	$sales_this_month = $this_month['sales'];
	$sales_month_before = $month_before['sales'];
	$sales_month_last = $month_last['sales'];
	$sales_annual = $annual['sales'];
	
	$sales_this_month = $sales_this_month == NULL ? 0 : $sales_this_month;
	$sales_month_before = $sales_month_before == NULL ? 0 : $sales_month_before;
	$sales_month_last = $sales_month_last == NULL ? 0 : $sales_month_last;
	
	$pembagi = max($sales_this_month, $sales_month_before, $sales_month_last);
	
	$sales_annual = $sales_annual == '' ? 0 : $sales_annual;
?>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales</h2>
	<hr>
<?php
	if($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 3 || $_SESSION['user_id'] == 7){ 
?>
<style>
	.progress{
		width: 150px;
		height: 150px;
		line-height: 150px;
		background: none;
		margin: 0 auto;
		box-shadow: none;
		position: relative;
	}
	.progress:after{
		content: "";
		width: 100%;
		height: 100%;
		border-radius: 50%;
		border: 2px solid #fff;
		position: absolute;
		top: 0;
		left: 0;
	}
	.progress > span{
		width: 50%;
		height: 100%;
		overflow: hidden;
		position: absolute;
		top: 0;
		z-index: 1;
	}
	.progress .progress-left{
		left: 0;
	}
	.progress .progress-bar{
		width: 100%;
		height: 100%;
		background: none;
		border-width: 2px;
		border-style: solid;
		position: absolute;
		top: 0;
	}
	.progress .progress-left .progress-bar{
		left: 100%;
		border-top-right-radius: 80px;
		border-bottom-right-radius: 80px;
		border-left: 0;
		-webkit-transform-origin: center left;
		transform-origin: center left;
	}
	.progress .progress-right{
		right: 0;
	}
	.progress .progress-right .progress-bar{
		left: -100%;
		border-top-left-radius: 80px;
		border-bottom-left-radius: 80px;
		border-right: 0;
		-webkit-transform-origin: center right;
		transform-origin: center right;
	}
	.progress .progress-value{
		width: 85%;
		height: 85%;
		border-radius: 50%;
		border: 2px solid #ebebeb;
		font-size: 32px;
		line-height: 125px;
		text-align: center;
		position: absolute;
		top: 7.5%;
		left: 7.5%;
	}
	.progress.blue .progress-bar{
		border-color: #049dff;
	}
	.progress.blue .progress-value{
		color: #049dff;
	}
	.progress.blue .progress-right .progress-bar{
		animation: loadinger-2 1s linear forwards;
	}
	.progress.blue .progress-left .progress-bar{
		animation: loading-2 <?php if ($pembagi == 0){ echo (0); } else if(round($sales_this_month * 1.5/ $pembagi) < 0.5){ echo (0); } else { echo (round($sales_this_month * 0.5 / $pembagi)); } ?>s linear forwards 1s;
	}
	.progress.yellow .progress-bar{
		border-color: #fdba04;
	}
	.progress.yellow .progress-value{
		color: #fdba04;
	}
	.progress.yellow .progress-right .progress-bar{
		animation: loadinger-3 1s linear forwards;
	}
	.progress.yellow .progress-left .progress-bar{
		animation: loading-3 <?php if ($pembagi == 0){ echo (0); } else if(round($sales_month_before * 1.5/ $pembagi) < 0.5){ echo (0); } else { echo (round($sales_month_before * 0.5 / $pembagi)); } ?>s linear forwards 1s;
	}
	.progress.pink .progress-bar{
		border-color: #ed687c;
	}
	.progress.pink .progress-value{
		color: #ed687c;
	}
	.progress.pink .progress-right .progress-bar{
		animation: loadinger-4 1s linear forwards;
	}
	.progress.pink .progress-left .progress-bar{
		animation: loading-4 <?php if ($pembagi == 0){ echo (0); } else if(round($sales_month_last * 1.5/ $pembagi) < 0.5){ echo (0); } else { echo (round($sales_month_last * 0.5 / $pembagi)); } ?>s linear forwards 1s;
	}
	.progress.green .progress-bar{
		border-color: #1abc9c;
	}
	.progress.green .progress-value{
		color: #1abc9c;
	}
	.progress.green .progress-right .progress-bar{
		animation: loadinger-5 1s linear forwards;
	}
	.progress.green .progress-left .progress-bar{
		animation: loading-5 0.8s linear forwards 1s;
	}
	@keyframes loadinger-2{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_this_month * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_this_month * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loading-2{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_this_month * 170 / $pembagi) < 180){ echo (0); } else { echo (round($sales_this_month * 170 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_this_month * 170 / $pembagi) < 180){ echo (0); } else { echo (round($sales_this_month * 170 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-3{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_month_before * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_month_before * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loading-3{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_month_before * 170 / $pembagi) < 170){ echo (0); } else { echo (round($sales_month_before * 170 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_month_before * 170 / $pembagi) < 170){ echo (0); } else { echo (round($sales_month_before * 170 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-4{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_month_last * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else {echo min(180,round($sales_month_last * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loading-4{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_month_last * 170 / $pembagi) < 170){ echo (0); } else { echo (round($sales_month_last * 170 / $pembagi)); } ?>deg);
			transform: rotate(<?php if($pembagi == 0){ echo (0); } else if(round($sales_month_last * 170 / $pembagi) < 170){ echo (0); } else { echo (round($sales_month_last * 170 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-5{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(180deg);
			transform: rotate(180deg);
		}
	}
	@keyframes loading-5{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(150deg);
			transform: rotate(150deg);
		}
	}
	@media only screen and (max-width: 990px){
		.progress{ margin-bottom: 20px; }
	}
</style>
	<div class='row'>
		<div class="col-sm-3" style='text-align:center'>
			<div class="progress blue">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= date('M',mktime(0,0,0,$month_php,0,$year)) ?></div>
			</div>
			<h5><strong>Rp. <?= number_format($sales_this_month,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<div class="progress yellow">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= date('M',mktime(0,0,0,$month_before_php,0,$year)) ?></div>
			</div>
			<h5><strong>Rp. <?= number_format($sales_month_before,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<div class="progress pink">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= date('M',mktime(0,0,0,$month_last_php,0,$year)) ?></div>
			</div>
			<h5><strong>Rp. <?= number_format($sales_month_last,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<div class="progress green">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= $year ?></div>
			</div>
			<h5><strong>Rp. <?= number_format($sales_annual,2) ?></strong></h5>
		</div>
	</div>
	<br>
<?php
	}
?>
	<div class='row'>
		<div class='col-xs-12'>
			<h3 style='font-family:bebasneue'>General Sales Info</h3>
			<br>
			<table class='table'>
				<tr>
					<td><strong>NPWP</strong></td>
					<td>72.418.271.2-423.000</td>
					<td>
						<a href='../universal/npwp.pdf' style='text-decoration:none' target='_blank'>
							<button type='button' class='button_default_dark'>
								Resource
							</button>
						</a>
					</td>
				</tr>
				<tr>
					<td>SPPKP</td>
					<td>S-145PKP/WPJ.09/KP.0203/2015</td>
					<td>
						<a href='../universal/sppkp.pdf' style='text-decoration:none' target='_blank'>
							<button type='button' class='button_default_dark'>
								Resource
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
	</div>
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