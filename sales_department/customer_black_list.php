<?php
	include('salesheader.php');
?>
<style>
	.notification_wrapper{
		width:100%;
		height:100%;
		background-color:rgba(25,25,25,0.8);
		position:fixed;
		top:0;
		left:0;
		z-index:30;
		display:none;
		text-align:center;
	}
	
	.notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #333;
	}

	.button_tab{
		background-color:transparent;
		border:none;
		outline:none!important;
		display:inline-block;
		width:30%;
	}
	
	.button_tab.active{
		border-bottom:2px solid #008080;
	}
	
	#customer_list{
		padding:20px;
	}
	
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
		padding:5px 10px;
		outline:none;
		border:none;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Customer</h2>
	<p>Black list or white list customer</p>
	<hr>
	<button type='button' class='button_tab active' id='blacklist_button'>
		<p>Blacklist customer</p>
	</button>
	<button type='button' class='button_tab' id='whitelist_button'>
		<p>Whitelist customer</p>
	</button>
	<div id='customer_list'>
	</div>
</div>
<script>
	$('.button_tab').click(function(){
		var button_id	= $(this).attr('id');
		if(button_id	== 'blacklist_button'){
			$('.active').removeClass('active');
			$('#' + button_id).addClass('active');
			$.ajax({
				url:'customer_black_list_view.php',
				beforeSend:function(){
					$('#customer_list').html('<div style="position;absolute;left:0;right:0;color:##2B3940;width:100%;text-align:center;padding:20px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				success:function(response){
					$('#customer_list').html(response);
				}
			});
		} else if(button_id	== 'whitelist_button'){
			$('.active').removeClass('active');
			$('#' + button_id).addClass('active');
			$.ajax({
				url:'customer_white_list_view.php',
				beforeSend:function(){
					$('#customer_list').html('<div style="position;absolute;left:0;right:0;color:##2B3940;width:100%;text-align:center;padding:20px;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				success:function(response){
					$('#customer_list').html(response);
				}
			});
		}
	});
	
	$(document).ready(function(){
		$('#blacklist_button').click();
	});
</script>