<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/header.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/agungelektrindo/universal/headers/purchasing_header.php');
?>
<head>
	<title>Manage supplier data</title>
</head>
<div class='main'>
	<h2 style='font-family:bebasneue'>Supplier</h2>
	<p style='font-family;museo'>Edit supplier</p>
	<hr>
	<button type='button' class='button_default_dark' id='add_supplier_button'>Add supplier</button>
	<br><br>
<?php
	$sql = "SELECT * FROM supplier";
	$result = $conn->query($sql);
?>
	<table class='table table-bordered'>
		<tr>
			<th style="text-align:center;width:30%">Name</th>
			<th style="text-align:center;width:50%">Address</th>
			<th style="text-align:center;width:20%">Action</th>
		</tr>
<?php
	while($row = mysqli_fetch_array($result)) {
		$supplier_id		= $row['id'];
		$supplier_name		= $row['name'];
		$supplier_address	= $row['address'];
?>
		<tr>
			<td><?= $supplier_name ?></td>
			<td><?= $supplier_address ?></td>
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
				<button class='button_default_dark' onclick='open_supplier_edit(<?= $supplier_id ?>)'><i class='fa fa-pencil'></i></button>	
				<a href='supplier_view.php?id=<?= $supplier_id ?>'><button class='button_success_dark'><i class='fa fa-eye'></i></button></a>
				<button class='button_danger_dark' <?php if($disable_condition != 0){ echo ('disabled'); } ?> onclick='pop_notification_large(<?= $row['id'] ?>)'><i class='fa fa-trash-o'></i></button>
			</td>		
<?php
		}
?>
		</tr>
<?php
	}
?>
	</table>
</div>
<div class='full_screen_wrapper' id='delete_supplier_notif'>
	<div class='full_screen_notif_bar'>
		<h1 style='font-size:2em;color:red'><i class="fa fa-ban" aria-hidden="true"></i></h1>
		<p style='font-family:museo'>Are you sure to delete this supplier?</p>
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

<div class='full_screen_wrapper' id='add_supplier_wrapper'>
	<button class='full_screen_close_button'>&times</button>
	<div class='full_screen_box'>
		<h2 style='font-family:bebasneue'>Add supplier form</h2>
		<hr>
		<form action='supplier_add' method='POST'>
		<label>Supplier name</label>
		<input type="text" class="form-control" name="name" required>
		
		<label>Address</label>
		<input type="text" class="form-control" name="address" required>
		
		<label>Number</label>
		<input type="text" class="form-control" name="number">
		
		<label>City</label>
		<input type="text" class="form-control" name="city" required>
		
		<label>Block</label>
		<input type="text" class="form-control" name="block" required>
		
		<label>RT</label>
		<input type="text" class="form-control" name="rt" required minlength='3' maxlength='3'>
		
		<label>RW</label>
		<input type="text" class="form-control" name="rw" required minlength='3' maxlength='3'>
		
		<label>Phone Number</label>
		<input type="text" class="form-control"	name="phone">
		
		<label>NPWP</label>
		<input type='text' class='form-control' id='npwp' name='npwp'/>
		<script>
			$("#npwp").inputmask("99.999.999.9-999.999");
		</script>
		
		<br>
		<button type='submit' class='button_success_dark'>Submit</button>
		</form>
	</div>
</div>
<script>
	function pop_notification_large(n){
		var window_height = $(window).height();
		var notif_height = $('#delete_supplier_notif .full_screen_notif_bar').height();
		var difference = window_height - notif_height;
		
		$('#delete_supplier_notif .full_screen_notif_bar').css('top', 0.7 * difference / 2);
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
				$('#edit_supplier_wrapper .full_screen_box').html(response);
			},
			complete:function(){
				$('#edit_supplier_wrapper').fadeIn();
			},
			type:'POST',
		})
	};
	
	$('.full_screen_close_button').click(function(){
		$(this).parent().fadeOut();
	});
	
	$('#add_supplier_button').click(function(){
		$('#add_supplier_wrapper').fadeIn();
	});
</script>