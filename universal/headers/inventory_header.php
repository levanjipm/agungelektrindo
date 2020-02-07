<?php
	include($_SERVER['DOCUMENT_ROOT'] .'/agungelektrindo/codes/connect.php');
	$sql_alert_do		= "SELECT id FROM code_delivery_order WHERE sent = '0' AND company = 'AE'";
	$result_alert_do	= $conn->query($sql_alert_do);
	$alert_do			= mysqli_num_rows($result_alert_do);
	
	$sql_alert_gr		= "SELECT id FROM code_goodreceipt WHERE isconfirm = '0'";
	$result_alert_gr	= $conn->query($sql_alert_gr);
	$alert_gr			= mysqli_num_rows($result_alert_gr);
?>
<div class='sidenav'>
	<button class='dropdown_button'>Delivery Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/delivery_order_create_dashboard'><button>Create</button></a>
		<a href='/agungelektrindo/inventory_department/delivery_order_confirm_dashboard'><button>Confirm <?php if($alert_do > 0){ ?><i class="fa fa-exclamation" aria-hidden="true"></i> <?php } ?></button></a>
		<a href='/agungelektrindo/inventory_department/delivery_order_archive'><button>Archives</button></a>
	</div>
	<button class='dropdown_button'>Goods Receipt</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/good_receipt_create_dashboard'><button>Create</button></a>
		<a href='/agungelektrindo/inventory_department/good_receipt_confirm_dashboard'><button>Confirm <?php if($alert_gr > 0){ ?><i class="fa fa-exclamation" aria-hidden="true"></i> <?php } ?></button></a>
		<a href='/agungelektrindo/inventory_department/view_gr_archive'><button>Archives</button></a>
	</div>
<?php
	if($role == 'superadmin'){
?>
	
	<button class='dropdown_button'>Event</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/event_add_dashboard'><button>Create</button></a>
		<a href='/agungelektrindo/inventory_department/event_confirm_dashboard'><button>Confirm</button></a>
	</div>
<?php
	}
?>
	<a href='/agungelektrindo/inventory_department/check_stock'><button>Check stock</button></a>
	<button class='dropdown_button'>Project</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/project_delivery_order_create_dashboard'><button>Create DO</button></a>
		<a href='/agungelektrindo/inventory_department/project_delivery_order_confirm_dashboard'><button>Confirm DO</button></a>
	</div>
	<a href='/agungelektrindo/inventory_department/sample_dashboard'>
		<button>Samples</button>
	</a>
	<button class='dropdown_button'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/sales_return_dashboard'><button>Sales return</button></a>
		<a href='/agungelektrindo/inventory_department/purchasing_return_dashboard'><button>Purchasing return</button></a>
		<a href='/agungelektrindo/inventory_department/return_confirm_dashboard'><button>Confrim return</button></a>
	</div>
	<hr>
	<a href='/agungelektrindo/inventory' style='color:#1ac6ff;text-decoration:none'><button>Inventory</button></a>
</div>
<div class='sidenav_small'>
</div>
<script>
	$('.dropdown_button').click(function(){
		$('.dropdown-container').hide();
		$('button').removeClass('active');
		$(this).addClass('active');
		$(this).next().toggle(350);
	});

	
	$('#hide_side_button').click(function(){
		$('.sidenav').toggle(200);
		$('#expand_side_button').fadeIn();
		$('#hide_side_button').hide();
		setTimeout(function(){	
			$('.main').animate({
				'margin-left':'50px'
			},200);
			
			$('.sidenav_small').toggle(200);
		},200);
	});

	$('#expand_side_button').click(function(){
		$('.sidenav_small').toggle(200);
		$('#expand_side_button').hide();
		$('#hide_side_button').fadeIn();
		setTimeout(function(){		
			$('.sidenav').toggle(200);
			$('.main').animate({
				'margin-left':'200px'
			},200);
		},200);
	});;
</script>
