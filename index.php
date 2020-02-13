<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/dashboard_header.php');
?>
<head>
	<title>Agung Elektrindo</title>
</head>
<style>
	.main{
		margin-left:0px!important;
	}
	
	::-webkit-scrollbar{width:2px;height:2px;}
	::-webkit-scrollbar-button{width:2px;height:2px;}
	
	#shortcut_department_wrapper{
		display:block;
		position:absolute;
		top:0px;
		left:-80px;
		width:150px;
		margin:0px;
		overflow-y:auto;
		overflow-x:hidden;
		transform:rotate(-90deg) translateY(-80px);
		transform-origin:right top;
		padding:150px 0px 0px 0px;
	}
	
	#shortcut_department_wrapper > a{
		display:block;
		padding:5px;
		transform:rotate(90deg);
		transform-origin: right top;
		width:150px;
		height:150px;
		margin-top:30px;
		background:#0e3f66;
		transition:0.3s all ease;
	}
	
	#shortcut_department_wrapper > a:hover{
		background-color:#326d96;
		transition:0.3s all ease;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue;color:#326d96'>Departments</h2>
	<hr style='border-top:2px solid #424242;'>
	<div class='row' style='position:relative;display:block;margin-bottom:150px;'>
		<div id='shortcut_department_wrapper'>
<?php
	$sql		= "SELECT departments.index_page, departments.department, departments.icon_url FROM authorization
					JOIN departments ON departments.id = authorization.department_id
					WHERE authorization.user_id = '" . $_SESSION['user_id'] . "'
					ORDER BY departments.department ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$department	= $row['department'];
		$index_page	= $row['index_page'];
		$image_url	= '/agungelektrindo/universal/Images/icons/' . $row['icon_url'] . '.PNG';
?>
			<a href='/agungelektrindo/<?= $index_page ?>' title='<?= $department ?>'>
				<img src='<?= $image_url ?>' style='width:100%'></img>
			</a>
<?php
	}
	
	if($privilege == 1){
?>
			<a href='/agungelektrindo/human_resource_department/absentee_dashboard' title='Absentee'>
				<img src='/agungelektrindo/universal/Images/icons/icons_attendance.PNG' style='width:100%'></img>
			</a>
<?php
	}
?>
		</div>
	</div>
	<div class='row' style='position:relative;display:block'>
		<div class='col-xs-12'>
			<h2 style='font-family:bebasneue;color:#326d96'>Recent news</h2>
			<hr style='border-top:2px solid #424242;'>
<?php
	$sql		= "SELECT * FROM announcement WHERE date <= CURDATE() ORDER BY id DESC LIMIT 3";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$name	= $row['event'];
		$description	= $row['description'];
		$date			= $row['date'];
?>
			<label><?= $name ?></label>
			<p><i><?= date('d M Y',strtotime($date)) ?></i></p>
			<p style='font-family:museo'><?= $description ?></p>
			<hr style='border-top:1px solid #424242'>
<?php
	}
?>
		</div>
	</div>
</div>
<script>	
	$(window).resize(function(){
		var window_width	= $('.main').width() + 150;
		$('#shortcut_department_wrapper').css('max-height', window_width);
	});
	
	$(document).ready(function(){
		$(window).resize();
	});
</script>