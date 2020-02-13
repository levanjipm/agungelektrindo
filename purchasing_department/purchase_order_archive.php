<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<style>
	.box{
		background-color:#0e3f66;
		padding:10px;
		text-align:center;
		cursor:pointer;
	}
	
	.box img{
		width:60%;
	}
	
	.icon_wrapper{
		padding:10px;
		text-align:center;
		width:15%;
		max-width:150px;
		min-width:30px;
	}
	
	.image_wrapper{
		background-color:#0e3f66;
	}
	
	.progress_bar_wrapper{
		width:100%;
		background-color:#424242;
		height:10px;
	}
	
	.progress_bar{
		width: 1%;
		height: 10px;
		background-color: #afdfe6;
	}
</style>
<head>
	<title>Purchase order archive</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Order</h2>
	<p>Archives</p>
	<hr>
	<label>Year</label>
	<select class='form-control' id='year' style='width:300px' onchange='update_purchase_order_view(0,1)'>
<?php
	$sql		= "SELECT DISTINCT(YEAR(date)) AS year FROM code_salesorder ORDER BY date ASC";
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
?>
		<option value='<?= $row['year'] ?>' <?php if($row['year'] == date('Y')){ echo 'selected'; } ?>><?= $row['year'] ?></option>
<?php
	}
?>
	</select>
	<br>
	<div id='view_pane'></div>
</div>
<script>
	$.ajax({
		url:'purchase_order_archive_view',
		data:{
			year:$('#year').val(),
			month:0,
			page:1,
		},
		type:'GET',
		success:function(response){
			$('#view_pane').html(response);
		}
	})
	
	function update_purchase_order_view(month, page){
		$.ajax({
			url:'purchase_order_archive_view',
			data:{
				year:$('#year').val(),
				month:month,
				page:page,
			},
			type:'GET',
			beforeSend:function(){
				$('.loading_wrapper_initial').fadeIn();
			},
			success:function(response){
				$('.loading_wrapper_initial').fadeOut();
				$('#view_pane').html(response);
			}
		})
	}
</script>