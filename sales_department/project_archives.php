<?php	
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Project archives</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Project</h2>
	<p style='font-family:museo'>Archives</p>
	<hr>
	<div id='project_archive_pane'></div>
</div>
<script>
	$(document).ready(function(){
		$.ajax({
			url:'project_archives_view.php',
			success:function(response){
				$('#project_archive_pane').html(response);
			}
		});
	});
</script>