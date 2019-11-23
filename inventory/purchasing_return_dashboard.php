<?php	
	include('inventoryheader.php');
?>
<style>
	.view_wrapper{
		height:100%;
		width:100%;
		background-color:rgba(25,25,25,0.8);
		position:fixed;
		top:0;
		left:0;
		z-index:50;
		display:none;
	}
	
	.view_box{
		height:80%;
		width:80%;
		position:fixed;
		background-color:white;
		top:10%;
		left:10%;
		overflow-y:scroll;
		padding:20px;
	}
	
	.button_x_box{
		position:fixed;
		top:10%;
		left:10%;
		border:none;
		outline:none!important;
		color:#333;
		z-index:55;
		background-color:transparent;
	}
</style>
<div class='view_wrapper'>
	<button type='button' class='button_x_box'>X</button>
	<div class='view_box'>
	</div>
</div>
<div class='main'>
	<h2 style='font-family:bebasneue'>Return</h2>
	<p>Purchasing return</p>
	<hr>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Supplier</th>
			<th></th>
		</tr>
<?php
	$sql_code 				= "SELECT * FROM code_purchase_return WHERE isconfirm = '1' AND issent = '0'";
	$result_code 			= $conn->query($sql_code);
	while($code 			= $result_code->fetch_assoc()){
		$sql_supplier 		= "SELECT name FROM supplier WHERE id = '" . $code['supplier_id'] . "'";
		$result_supplier 	= $conn->query($sql_supplier);
		$supplier 			= $result_supplier->fetch_assoc();
		
		$supplier_name		= $supplier['name'];
?>
		<tr>
			<td><?= date('d M Y',strtotime($code['date'])) ?></td>
			<td><?= $supplier_name ?></td>
			<td>
				<button type='button' class='button_default_dark' id='button-<?= $code['id'] ?>' onclick='show(<?= $code['id'] ?>)'>
					<i class="fa fa-eye" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<script>
	function show(n){
		$.ajax({
			url:'purchasing_return_view.php',
			data:{
				return_id: n
			},
			type:'POST',
			beforeSend:function(){
				$('#button-' + n).attr('disabled',true);
				$('#button-' + n).css('cursor','not-allowed');
				$('#button-' + n).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success:function(response){
				$('#button-' + n).attr('disabled',false);
				$('#button-' + n).css('cursor','pointer');
				$('#button-' + n).html('<i class="fa fa-eye" aria-hidden="true"></i>');
				$('.view_box').html(response);
				$('.view_wrapper').fadeIn();
			}
		});
	};
	
	$('.button_x_box').click(function(){
		$('.view_wrapper').fadeOut();
	});
	
	function input_purchasing_return(n){
		if($('#send_date').val() == ''){
			alert('Please insert a valid date!');
			$('#send_date').focus();
			return false;
		} else {
			$.ajax({
				url:'purchasing_return_input.php',
				data:{
					return_id:n,
					send_date: $('#send_date').val(),
				},
				type:'POST',
				beforeSend:function(){
					$('#submit_button_view').attr('disabled',true);
				},
				success:function(){
					$('#submit_button_view').attr('disabled',false);
					$('.button_x_box').click();
				}
			});
		}
	}
</script>