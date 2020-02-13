<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/sales_header.php');
?>
<head>
	<title>Sales order archives</title>
</head>
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
</style>
<script>
	$('#sales_order_side').click();
	$('#sales_order_archive').find('button').addClass('activated');
</script>
<div class='main'>
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<p style='font-family:museo'>Archive</p>
	<hr>
	
	<label>Year</label>
	<select class='form-control' id='year' style='width:300px' onchange='update_sales_order_view(0,1)'>
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
		url:'sales_order_archive_view',
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
	
	function update_sales_order_view(month, page){
		$.ajax({
			url:'sales_order_archive_view',
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