<?php
	include('../codes/connect.php');
	$sql = "SELECT * FROM announcement WHERE date = '" . date('Y-m-d') . "'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) == 0){
		echo ('<p>There are no news for today. Start your own news</p>');
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
<script>
$('#create_news_button').click(function(){
	$('#create_news_wrapper').fadeIn();
});

$('#close_news_wrapper_button').click(function(){
	$('#create_news_wrapper').fadeOut();
});
</script>