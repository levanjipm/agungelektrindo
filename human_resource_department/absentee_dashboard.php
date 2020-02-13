<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/human_resource_header.php');
?>
<head>
	<title>Absentee list</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Absentee list</h2>
	<hr>
	
	<div id='view_pane'></div>
</div>
<script>
	refresh_absentee_list();
	
	function refresh_absentee_list(){
		$.ajax({
			url:'absentee_dashboard_view',
			success:function(response){
				$('#view_pane').html(response);
				setTimeout(function(){
					refresh_absentee_list();
				},1000);
			}
		});
	}
	
	function absentee_input(user_id, type){
		$.ajax({
			url:'absentee_input',
			data:{
				user_id:user_id,
				type:type
			},
			type:'GET',
			success:function(){
				refresh_absentee_list()
			}
		});
	}
</script>