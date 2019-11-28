<div class='sidenav'>
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button type='button'>Delivery Order</button>
	<div class="dropdown-container">
		<a href='delivery_order_create_dashboard'><p>Create a DO</p></a>
		<a href='delivery_order_edit_dashboard'><p>Edit a DO</p></a>
		<a href='delivery_order_confirm_dashboard'><p>Confirm DO<span class="badge"><?= $delivery_order ?></span></p></a>
		<a href='delivery_order_archive'><p>Archives</p></a>
	</div>
	<button>Goods Receipt</button>
	<div class="dropdown-container">
		<a href='good_receipt_create_dashboard'><p>Create good receipt</p></a>
		<a href='goodreceipt_confirm_dashboard'><p>Confirm GR<span class="badge"><?= $good_receipt ?></span></p></a>
		<a href='view_gr_archive'><p>Archives</p></a>
	</div>
<?php
	if($role == 'superadmin'){
?>
	
	<button>Event</button>	
	<div class="dropdown-container">
		<a href='event_add_dashboard'><p>Add event</p></a>
		<a href='event_confirm_dashboard'><p>Confirm event</p></a>
	</div>
<?php
	}
?>
	<a href='check_stock'><button>Check stock</button></a>
	<button>Project</button>
	<div class="dropdown-container">
		<a href="delivery_order_project_dashboard">
			<button type='button' class='btn-badge' style='color:white'>
				Create DO
			</button>
		</a>
		<a href="delivery_order_project_confirm_dashboard">
			<button type='button' class='btn-badge' style='color:white'>
				Confirm DO
			</button>
		</a>
		<a href="set_project_done_dashboard.php">
			<button type='button' class='btn-badge' style='color:white'>
				Set done
			</button>
		</a>
	</div>
	<a href="sample_dashboard.php">
		<button type='button' class='btn-badge dropdown-btn' style='color:white'>
			<i class="fa fa-flask" aria-hidden="true"></i>
			Samples
		</button>
	</a>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-undo" aria-hidden="true"></i>
		Return
	</button>
	<div class="dropdown-container">
		<a href="sales_return_dashboard">
			<p>Sales return</p>
		</a>
		<a href="purchasing_return_dashboard">
			<p>Purchasing return</p>
		</a>
	</div>
	<hr>
	<a href='inventory' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Inventory Department
	</a>
</div>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
</div>
<script>
	$('.dropdown-btn').click(function(){
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
