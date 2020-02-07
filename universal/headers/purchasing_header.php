<div class='sidenav'>
	<button class='dropdown_button'>Purchase Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/purchase_order_create_dashboard'><button>Create a PO</button></a>
		<a href='/agungelektrindo/purchasing_department/purchase_order_archive'><button>Archives</button></a>
	</div>
	<a href='/agungelektrindo/purchasing_department/supplier_manage_dashboard'><button>Supplier</button></a>
	<button class='dropdown_button'>Item list</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/item_manage_dashboard'><button>Manage item list</button></a>
		<a href='/agungelektrindo/purchasing_department/item_add_class_dashboard'><button>Item list cat.</button></a>
	</div>
	<button class='dropdown_button'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/return_create_dashboard'><button>Create Return</button></a>
		<a href='/agungelektrindo/purchasing_department/return_confirm_dashboard'><button>Confirm Return</button></a>
	</div>
	<a href='/agungelektrindo/purchasing_department/restock_dashboard'><button>Restock</button></a>
	<a href='/agungelektrindo/purchasing_department/report_dashboard'><button>Purchase Report</button></a>
	<hr>
	<a href='/agungelektrindo/purchasing' style='color:#1ac6ff;text-decoration:none'>
		<button>Purchasing</button>
	</a>
</div>
<div class='sidenav_small'></div>
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
	});
</script>