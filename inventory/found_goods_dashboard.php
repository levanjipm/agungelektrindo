<?php
	include('inventoryheader.php');
?>
<style>
	.notification_large{
		position:fixed;
		top:0;
		left:0;
		background-color:rgba(51,51,51,0.3);
		width:100%;
		text-align:center;
		height:100%;
	}
	.notification_large .notification_box{
		position:relative;
		background-color:#fff;
		padding:30px;
		width:100%;
		top:30%;
		box-shadow: 3px 4px 3px 4px #ddd;
	}
	.btn-confirm{
		background-color:#2bf076;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-delete{
		background-color:red;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-back{
		background-color:#777;
		font-family:bebasneue;
		color:white;
		font-size:1.5em;
	}
	.btn-x{
		background-color:transparent;
		border:none;
		outline:0!important;
	}
	.btn-x:focus{
		outline: 0!important;
	}
	</style>
<div class='main'>
	<h2 style='font-family:bebasneue'>Add event</h2>
	<p><strong>Found</strong> Goods</p>
	<hr>
	<form action='found_goods_input.php' method='POST' id='found_goods_form'>
		<label>Date</label>
		<input type='date' class='form-control' name='date' id='date'>
		<label>Reference</label>
		<input type='text' class='form-control' id='reference' name='reference'>
		<label>Quantity</label>
		<input type='number' class='form-control' id='quantity' name='quantity'>
		<br>
		<button type='button' class='button_danger_dark' id='back_found_goods_button'>Back</button>
		<button type='button' class='button_default_dark' id='submit_found_goods_confirmation_button'>Submit</button>
	</form>
</div>
<div class='notification_large' style='display:none' id='confirm_notification'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:#2bf076'><i class="fa fa-check" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to submit this event?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-confirm' id='confirm_button'>Confirm</button>
	</div>
</div>
<script>
	$('#back_found_goods_button').click(function(){
		window.history.back();
	});
	var available = 1;
	$('#submit_found_goods_confirmation_button').click(function(){
		$.ajax({
			url:'../codes/check_item_availability.php',
			data:{
				reference : $('#reference').val()
			},
			type:'POST',
			success:function(response){
				if(response == 0){
					alert('Reference not found!');
					return false;
				} else {
					if($('#date').val() == ''){
						alert('Please insert correct date');
						return false;
					} else if($('#reference').val() == ''){
						alert('Please insert reference');
						return false;
					} else if($('#quantity').val() == '' || $('#quantity').val() <= 0){
						alert('Please insert correct quantity');
						return false;
					} else {
						$('#confirm_notification').fadeIn();
					}
				}
			},
		});
	})
	$('#confirm_button').click(function(){
		$('#found_goods_form').submit();
	});
</script>