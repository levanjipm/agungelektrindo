<div class='sidenav'>
	<button type='button' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Delivery Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/delivery_order_create_dashboard'><p>Create a DO</p></a>
		<a href='/agungelektrindo/inventory_department/delivery_order_edit_dashboard'><p>Edit a DO</p></a>
		<a href='/agungelektrindo/inventory_department/delivery_order_confirm_dashboard'><p>Confirm DO<span class="badge"><?= $delivery_order ?></span></p></a>
		<a href='/agungelektrindo/inventory_department/delivery_order_archive'><p>Archives</p></a>
	</div>
	<button class='dropdown_button'>Goods Receipt</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/good_receipt_create_dashboard'><p>Create good receipt</p></a>
		<a href='/agungelektrindo/inventory_department/goodreceipt_confirm_dashboard'><p>Confirm GR<span class="badge"><?= $good_receipt ?></span></p></a>
		<a href='/agungelektrindo/inventory_department/view_gr_archive'><p>Archives</p></a>
	</div>
<?php
	if($role == 'superadmin'){
?>
	
	<button class='dropdown_button'>Event</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/event_add_dashboard'><p>Add event</p></a>
		<a href='/agungelektrindo/inventory_department/event_confirm_dashboard'><p>Confirm event</p></a>
	</div>
<?php
	}
?>
	<a href='/agungelektrindo/inventory_department/check_stock'><button>Check stock</button></a>
	<button class='dropdown_button'>Project</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/project_delivery_order_create_dashboard'>
			<p>Create DO</p>
		</a>
		<a href='/agungelektrindo/inventory_department/delivery_order_project_confirm_dashboard'>
			<p>Confirm DO</p>
		</a>
		<a href="set_project_done_dashboard.php">
			<p>Set done</p>
		</a>
	</div>
	<a href='/agungelektrindo/inventory_department/sample_dashboard.php'>
		<button>Samples</button>
	</a>
	<button class='dropdown_button'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/inventory_department/sales_return_dashboard'><p>Sales return</p></a>
		<a href='/agungelektrindo/inventory_department/purchasing_return_dashboard'><p>Purchasing return</p></a>
		<a href='/agungelektrindo/inventory_department/return_confirm_dashboard'><p>Confrim return</p></a>
	</div>
	<hr>
	<a href='/agungelektrindo/inventory' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Inventory Department</a>
</div>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
</div>
<script>
	$('.dropdown_button').click(function(){
		if($(this).next().is(':visible')){
			$(this).css('color','white');
		} else {
			$(this).css('color','#00ccff');
		}
		$(this).next().toggle(350);
	});

	$('#hide_side_button').click(function(){
		$('.sidenav').toggle(200);
		$('#show_side_button').fadeIn();
		setTimeout(function(){	
			$('.main').animate({
				'margin-left':'50px'
			},200);
			$('.sidenav_small').toggle(200);
		},200);
	});

	$('.sidenav_small').click(function(){
		$('.sidenav_small').toggle(200);
		$('#show_side_button').hide();
		setTimeout(function(){		
			$('.sidenav').toggle(200);
			$('.main').animate({
				'margin-left':'200px'
			},200);
		},200);
	});
</script>
