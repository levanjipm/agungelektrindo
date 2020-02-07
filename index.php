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
	<div class='tab_view'>
<?php
		$sql				= "SELECT * FROM users WHERE id = '$user_id'";
		$result				= $conn->query($sql);
		$row				= $result->fetch_assoc();
		
		$user_name			= $row['name'];
		$user_address		= $row['address'];
		$user_city			= $row['city'];
		$user_nik			= $row['NIK'];
		$user_image_url		= '/agungelektrindo/dashboard/' . $row['image_url'];
		$user_role			= $row['role'];
		$user_mail			= $row['mail'];
		$user_uname			= $row['username'];
?>
	<div class='row'>
		<div class='col-sm-3' style='text-align:center'>
			<img src='<?= $user_image_url ?>' style='width:100%;max-width:150px;border-radius:50%;'>
			<h3 style='font-family:museo'><?= $user_name ?></h3>
			<p style='font-family:museo'><?= $user_role ?></p>
		</div>
		<div class='col-sm-9'>
			<h3 style='font-family:museo'>General data</h3>
			<label>NIK</label>
			<p style='font-family:museo'><?= $user_nik ?></p>
			<label>Email</label>
			<p style='font-family:museo'><?= $user_mail ?></p>
			<label>Username</label>
			<p style='font-family:museo'><?= $user_uname ?></p>
			<label>Address</label>
			<p style='font-family:museo'><?= $user_address . " " . $user_city ?></p>
			<a href='/agungelektrindo/dashboard/profile_edit_dashboard'>
				<button class='button_success_dark'>Edit data</button>
			</a>
		</div>
	</div>
	</div>
</div>
<script>	
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
				$('.tab_view').html('');
				$('.loading_wrapper_initial').fadeIn();
			},
			success:function(response){
				$('.active').removeClass('active');
				$('#' + button_id).addClass('active');
				$('.loading_wrapper_initial').fadeOut();
				$('.tab_view').html(response);
			}
		});
	});
</script>