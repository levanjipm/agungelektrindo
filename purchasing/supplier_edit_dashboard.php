<?php
	include("purchasingheader.php");
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
	
	.view_supplier_wrapper{
		background-color:rgba(30,30,30,0.7);
		position:fixed;
		z-index:100;
		top:0;
		width:100%;
		height:100%;
		display:none;
	}
	
	#view_supplier_box{
		position:absolute;
		width:90%;
		left:5%;
		top:10%;
		height:80%;
		background-color:white;
		overflow-y:scroll;
		padding:20px;
	}
	
	#button_close_view{
		position:absolute;
		background-color:transparent;
		top:10%;
		left:5%;
		outline:none;
		border:none;
		color:#333;
		z-index:120;
	}
</style>
<div class="main">
	<h2 style='font-family:bebasneue'>Supplier</h2>
	<p>Edit supplier</p>
	<hr>
	<div class='row'>
		<div class='col-sm-12'>
<?php
$sql = "SELECT * FROM supplier";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
?>
			<table  class='table table-hover'>
				<tr>
					<th style="text-align:center;width:30%"><strong>Name</strong></th>
					<th style="text-align:center;width:50%"><strong>Address</strong></th>
					<th style="text-align:center;width:20%"></th>
				</tr>
<?php
	while($row = mysqli_fetch_array($result)) {
?>
				<tr>
					<td><?= $row['name']?></td>
					<td><?= $row['address']?></td>
<?php
		if($role == 'superadmin'){
			$sql_disable 		= "SELECT 
								(SELECT COUNT(id) FROM code_purchaseorder WHERE supplier_id = '" . $row['id'] . "') AS purchase_order_count,
								(SELECT COUNT(id) FROM code_goodreceipt WHERE supplier_id = '" . $row['id'] . "') AS gr_count,
								(SELECT COUNT(id) FROM purchases WHERE supplier_id = '" . $row['id'] . "') AS purchase_count";
			$result_disable 	= $conn->query($sql_disable);
			$disable 			= $result_disable->fetch_assoc();
			$disable_condition 	= $disable['purchase_order_count']  + $disable['gr_count'] + $disable['purchase_count'];
?>
					<td>
						<button type="button" class="button_default_dark" onclick='open_supplier_edit(<?= $row['id'] ?>)'><i class="fa fa-pencil" aria-hidden="true"></i></button>	
						<button type="button" class="button_danger_dark" <?php if($disable_condition != 0){ echo ('disabled'); } ?> onclick='pop_notification_large(<?= $row['id'] ?>)'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
					</td>		
<?php
		}
?>
				</tr>
<?php
	}
}
?>
			</table>
		</div>
	</div>
</div>
<div class='notification_large' style='display:none' id='delete_large'>
	<div class='notification_box'>
		<h1 style='font-size:3em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<h2 style='font-family:bebasneue'>Are you sure to delete this item?</h2>
		<br>
		<button type='button' class='btn btn-back'>Back</button>
		<button type='button' class='btn btn-delete'>Delete</button>
	</div>
</div>
<div class='view_supplier_wrapper'>
	<div id='view_supplier_box'>
	</div>
	<button id='button_close_view'>X</button>
</div>
<input type='hidden' id='delete_id'>
<script>
	function pop_notification_large(n){
		$('#delete_large').fadeIn();
		$('#delete_id').val(n);
	}
	
	$('.btn-back').click(function(){
		$('#delete_large').fadeOut();
	});
	
	$('.btn-delete').click(function(){
		$.ajax({
			url:"supplier_delete.php",
			data:{
				supplier_id: $('#delete_id').val()
			},
			type:"POST",
			success:function(){
				window.location.reload();
			}
		})
	});
	
	function open_supplier_edit(n){
		$.ajax({
			url:'supplier_edit_form.php',
			data:{
				supplier_id:n
			},
			success:function(response){
				$('#view_supplier_box').html(response);
			},
			complete:function(){
				$('.view_supplier_wrapper').fadeIn();
			},
			type:'POST',
		})
	};
	
	$('#button_close_view').click(function(){
		$('.view_supplier_wrapper').fadeOut();
	});
</script>