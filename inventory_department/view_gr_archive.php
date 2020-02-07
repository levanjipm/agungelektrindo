<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/inventory_header.php');
?>
<style>
	.btn-table{
		background-color:transparent;
		border:none;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Good Receipt</h2>
	<p>Archives</p>
	<hr>
	<button type='button' class='btn btn-default' id='back_button'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
	<input type='hidden' value='0' id='depth'>
	<input type='hidden' value='0' id='depth_year'>
	<div class='row' id='folders'>
<?php
	$sql = "SELECT DISTINCT(YEAR(date)) AS year FROM code_goodreceipt";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
?>
	<div class='col-sm-2 folder_year' style='cursor:pointer' ondblclick='view_month(<?= $row['year'] ?>)'>
		<h1 style='font-size:5em'>
			<i class="fa fa-folder-o" aria-hidden="true"></i>
		</h1>
		<p style='font-family:bebasneue'><?= $row['year'] ?></p>
	</div>
<?php
	}
?>
	</div>
</div>
<div class='full_screen_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<script>
	function view_month(n){
		$('#depth').val(1);
		$('#depth_year').val(n);
		$.ajax({
			url:'folder_view_month_gr.php',
			data:{
				year:n,
			},
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
		})
	}
	
	function view_po(month,year){
		$('#depth').val(2);
		$.ajax({
			url:'folder_view_gr.php',
			data:{
				year:year,
				month:month,
			},
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
		});
	}
	
	$('#back_button').dblclick(function(){
		if($('#depth').val() == 1){
			$.ajax({
			url:'folder_view_year_gr.php',
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
			})
		} else if($('#depth').val() == 2){
			view_month($('#depth_year').val());
		}
	});
	
	function view_archive(n){
		$.ajax({
			url:'good_receipt_view_archive.php',
			data:{
				id:n
			},
			type:'GET',
			success:function(response){
				$('.full_screen_box').html(response);
				$('.full_screen_wrapper').fadeIn();
			}
		});
	}
	
	$('.full_screen_close_button').click(function(){
		$('.full_screen_wrapper').fadeOut();
	});
</script>