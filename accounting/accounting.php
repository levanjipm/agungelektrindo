<?php
	include("accountingheader.php");
	$sql_30 = "SELECT SUM(value) AS less_than_30 FROM invoices 
	WHERE isdone = '0' AND date >= '" . date('Y-m-d',strtotime('-30 days')) . "'";
	$result_30 = $conn->query($sql_30);
	$row_30 = $result_30->fetch_assoc();
	
	$sql_45 = "SELECT SUM(value) AS less_than_45 FROM invoices 
	WHERE isdone = '0' AND date < '" . date('Y-m-d',strtotime('-30 days')) . "' 
	AND date > '" . date('Y-m-d',strtotime('-45 days')) . "'";
	$result_45 = $conn->query($sql_45);
	$row_45 = $result_45->fetch_assoc();
	
	$sql_60 = "SELECT SUM(value) AS less_than_60 FROM invoices 
	WHERE isdone = '0' AND date < '" . date('Y-m-d',strtotime('-45 days')) . "' 
	AND date > '" . date('Y-m-d',strtotime('-60 days')) . "'";
	$result_60 = $conn->query($sql_60);
	$row_60 = $result_60->fetch_assoc();
	
	$sql_nunggak = "SELECT SUM(value) AS nunggak FROM invoices 
	WHERE isdone = '0' AND date <= '" . date('Y-m-d',strtotime('-60 days')) . "'";
	$result_nunggak = $conn->query($sql_nunggak);
	$nunggak = $result_nunggak->fetch_assoc();
	
	$sql_total = "SELECT SUM(value) AS total FROM invoices
	WHERE isdone = '0'";
	$result_total = $conn->query($sql_total);
	$total = $result_total->fetch_assoc();
	$pembagi = $total['total'];

	if($row_30['less_than_30'] == NULL){
		$total_30 = 0;
	} else { 
		$total_30 = $row_30['less_than_30'];
	};
	if($row_45['less_than_45'] == NULL){
		$total_45 = 0;
	} else { 
		$total_45 = $row_45['less_than_45'];
	};
	if($row_60['less_than_60'] == NULL){
		$total_60 = 0;
	} else { 
		$total_60 = $row_60['less_than_60'];
	};
	if($nunggak['nunggak'] == NULL){
		$total_nunggak = 0;
	} else { 
		$total_nunggak = $nunggak['nunggak'];
	};
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
		animation: loading-2 <?php if(round($total_30 * 1.5/ $pembagi) < 0.5){ echo (0); } else { echo (round($total_30 * 0.5 / $pembagi)); } ?>s linear forwards 1s;
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
		animation: loading-3 <?= round($total_45 * 1.5 / $pembagi) ?>s linear forwards 1s;
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
		animation: loading-4 <?= round($total_60 * 1.5 / $pembagi) ?>s linear forwards 1s;
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
		animation: loading-5 <?= round($total_nunggak * 1.5 / $pembagi) ?>s linear forwards 1s;
	}
	@keyframes loadinger-2{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?= min(180,round($total_30 * 180 / $pembagi)) ?>deg);
			transform: rotate(<?= min(180,round($total_30 * 180 / $pembagi)) ?>deg);
		}
	}
	@keyframes loading-2{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if(round($total_30 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_30 * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if(round($total_30 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_30 * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-3{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?= min(180,round($total_45 * 180 / $pembagi)) ?>deg);
			transform: rotate(<?= min(180,round($total_45 * 180 / $pembagi)) ?>deg);
		}
	}
	@keyframes loading-3{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if(round($total_45 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_45 * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if(round($total_45 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_45 * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-4{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?= min(180,round($total_60 * 180 / $pembagi)) ?>deg);
			transform: rotate(<?= min(180,round($total_60 * 180 / $pembagi)) ?>deg);
		}
	}
	@keyframes loading-4{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if(round($total_60 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_60 * 180 / $pembagi)); } ?>deg);
			transform: rotate(<?php if(round($total_60 * 180 / $pembagi) < 180){ echo (0); } else { echo (round($total_60 * 180 / $pembagi)); } ?>deg);
		}
	}
	@keyframes loadinger-5{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?= min(180,round($total_nunggak * 180 / $pembagi)) ?>deg);
			transform: rotate(<?= min(180,round($total_nunggak * 180 / $pembagi)) ?>deg);
		}
	}
	@keyframes loading-5{
		0%{
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100%{
			-webkit-transform: rotate(<?php if(round($total_nunggak * 180 / $pembagi) < 180){ echo ($total_nunggak / $pembagi); } else { echo (round($total_nunggak * 180/ $pembagi)); } ?>deg);
			transform: rotate(<?php if(round($total_nunggak * 180 / $pembagi) < 180){ echo ($total_nunggak / $pembagi); } else { echo (round($total_nunggak * 180/ $pembagi)); } ?>deg);
		}
	}
	@media only screen and (max-width: 990px){
		.progress{ margin-bottom: 20px; }
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Receivable</h2>
	<h4 style='font-family:bebasneue'>Rp. <?= number_format($pembagi,2) ?></h4>
	<hr>
	<div class='row'>
		<div class="col-sm-3" style='text-align:center'>
			<h4 style='font-family:bebasneue'><strong>Less than 30 days</strong></h4>
			<div class="progress blue">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= round(($total_30 * 100 / $pembagi),2) ?>%</div>
			</div>
			<h5><strong>Rp. <?= number_format($total_30,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<h4 style='font-family:bebasneue'><strong>30 - 45 days</strong></h4>
			<div class="progress yellow">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= round(($total_45 * 100 / $pembagi),2) ?>%</div>
			</div>
			<h5><strong>Rp. <?= number_format($total_45,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<h4 style='font-family:bebasneue'><strong>45 - 60 days</strong></h4>
			<div class="progress pink">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= round(($total_60 * 100 / $pembagi),2) ?>%</div>
			</div>
			<h5><strong>Rp. <?= number_format($total_60,2) ?></strong></h5>
		</div>
		<div class="col-sm-3" style='text-align:center'>
			<h4 style='font-family:bebasneue'><strong>More than 60 days</strong></h4>
			<div class="progress green">
				<span class="progress-left">
					<span class="progress-bar"></span>
				</span>
				<span class="progress-right">
					<span class="progress-bar"></span>
				</span>
				<div class="progress-value"><?= round(($total_nunggak * 100 / $pembagi),2) ?>%</div>
			</div>
			<h5><strong>Rp. <?= number_format($total_nunggak,2) ?></strong></h5>
		</div>
	</div>
	<div class='row'>
</div>