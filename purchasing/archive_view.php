<?php
	include('purchasingheader.php');
?>
<style>
	.btn-table{
		background-color:transparent;
		border:none;
	}
	.done_flag{
		padding:5px 20px;
		border:none;
		background-color:rgba(62, 134, 250,0.8);
		color:white;
		position:absolute;
		top:10%;
		right:20%;
		z-index:20;
		border-radius:3px;
	}
	.closed_flag{
		padding:5px 20px;
		border:none;
		background-color:rgba(217, 47, 28,0.8);
		color:white;
		position:absolute;
		top:10%;
		right:20%;
		z-index:20;
		border-radius:3px;
	}
</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Purchase Order</h2>
	<p>Archives</p>
	<hr>
	<button type='button' class='button_default_dark' id='back_button'><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
	<input type='hidden' value='0' id='depth'>
	<input type='hidden' value='0' id='depth_year'>
	<div class='row' id='folders'>
<?php
	$sql 		= "SELECT DISTINCT(YEAR(date)) AS year FROM code_purchaseorder";
	$result 	= $conn->query($sql);
	while($row 	= $result->fetch_assoc()){
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
<script>
	function view_month(n){
		$('#depth').val(1);
		$('#depth_year').val(n);
		$.ajax({
			url:'folder_view_month.php',
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
			url:'foler_view_po.php',
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
			url:'folder_view_year.php',
			success:function(response){
				$('#folders').html(response);
			},
			type:"POST",
			})
		} else if($('#depth').val() == 2){
			view_month($('#depth_year').val());
		}
	});
	function view_archive_po(n){
		$('#po_archieve_form' + n).submit();
	}
</script>