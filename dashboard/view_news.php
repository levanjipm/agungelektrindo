<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/codes/connect.php');
	$sql = "SELECT * FROM announcement WHERE date = '" . date('Y-m-d') . "'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
		echo ('<p style="font-family:museo">There are no news for today. Start your own news</p>');
		echo ('<hr>');
		echo ("<button type='button' class='button_default_dark' id='create_news_button'>Create News</button>");
	} else {
?>
		<ol>
<?php
		while($row = $result->fetch_assoc()){
?>
		
			<li>
				<p style='line-height:0.6'><strong><?= $row['event']; ?></strong></p>
				<p style='line-height:0.6'><?= $row['description'] ?></p>
			</li>
<?php
		}
?>
		</ol>
		
		<button type='button' class='button_default_dark' id='create_news_button'>Create News</button>
<?php
	}
?>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h2 style='font-family:museo'>News</h2>
		<hr>
		<label>News name</label>
		<input type='text' class='form-control' id='news_name'>
		<label>Description</label>
		<textarea class='form-control' id='news_description' style='resize:none'></textarea>
		<label>Date</label>
		<input type='date' class='form-control' id='news_date'>
		<br>
		<button type='button' class='button_success_dark' id='submit_news_button'>Submit</button>
	</div>
</div>
<script>
	$('#create_news_button').click(function(){
		$('.full_screen_wrapper').fadeIn(300);
	});
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut(300);
	});
	
	$('#submit_news_button').click(function(){
		if($('#news_name').val() == ''){
			alert("Please insert news' name");
			$('#news_name').focus();
			return false;
		} else if($('#news_description').val() == ''){
			alert("Please insert news' description");
			$('#news_description').focus();
			return false;
		} else if($('#news_date').val() == '' ){
			alert("Please insert news' date");
			$('#news_date').focus();
			return false;
		} else {
			$.ajax({
				url:'input_news.php',
				data:{
					date:$('#news_date').val(),
					subject:$('#news_name').val(),
					description: $('#news_description').val()
				},
				type:'POST',
				beforeSend:function(){
					$('#submit_news_button').attr('disabled',true);
				},
				success:function(){
					$('#submit_news_button').attr('disabled',false);
					$('.full_screen_close_button').click();
				}
			});
		}
	});	
</script>