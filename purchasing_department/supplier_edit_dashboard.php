<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Manage supplier data</title>
</head>
<div class='main'>
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
<div class='full_screen_wrapper' id='delete_supplier_notif'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this item?</p>
		<br>
		<button type='button' class='button_danger_dark' id='close_notif_button'>Check again</button>
		<button type='button' class='button_success_dark' id='confirm_delete_button'>Confirm</button>
	</div>
</div>
<div class='full_screen_wrapper' id='edit_supplier_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
	</div>
</div>
<input type='hidden' id='delete_id'>
<script>
	function pop_notification_large(n){
		$('#delete_supplier_notif').fadeIn();
		$('#delete_id').val(n);
	}
	
	$('#close_notif_button').click(function(){
		$('#delete_supplier_notif').fadeOut();
	});
	
	$('#confirm_delete_button').click(function(){
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
				$('.full_screen_box').html(response);
			},
			complete:function(){
				$('#edit_supplier_wrapper').fadeIn();
			},
			type:'POST',
		})
	};
	
	$('.full_screen_close_button').click(function(){
		$('#edit_supplier_wrapper').fadeOut();
	});
</script>