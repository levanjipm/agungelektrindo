<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/dashboard_header.php');
?>
<div class='main'>
	<div class='tab_button_wrapper'>
		<button id='profile_button' class='active'>Profile</button>
		<button id='news_button'>News</button>
		<button id='promotion_button'>Promotion</button>
		<button id='salary_button'>Salary</button>
<?php if($privilege == 1){ ?>
		<button id='absentee_button'>Att. List</button>
<?php } ?>
	</div>
	<div class='tab_view'></div>
</div>
<script>
	$(document).ready(function(){
		$('#profile_button').click();
	});
	
	$('.tab_button_wrapper button').click(function(){
		var button_id			= $(this).attr('id');
		if(button_id			== 'profile_button'){
			var url				= '/agungelektrindo/dashboard/view_profile';
		} else if(button_id		== 'news_button'){
			var url				= '/agungelektrindo/dashboard/view_news';
		} else if(button_id		== 'promotion_button'){
			var url				= '/agungelektrindo/dashboard/view_promotion';
		} else if(button_id		== 'absentee_button'){
			var url				= '/agungelektrindo/dashboard/view_absentee';
		} else if(button_id		== 'salary_button'){
			var url				= '/agungelektrindo/dashboard/view_salary';
		}
		
		$.ajax({
			url:url,
			beforeSend:function(){
				$('.tab_view').html("<h1 style='font-size:6em;position:absolute;left:50%;'><i class='fa fa-spinner fa-spin' aria-hidden='true'></i>");
			},
			success:function(response){
				$('.active').removeClass('active');
				$('#' + button_id).addClass('active');
				$('.tab_view').html(response);
			}
		});
	});
</script>