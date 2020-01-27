<div class='sidenav'>
	<button style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button' id='quotation_side'>Quotations</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/quotation_create_dashboard' id='quotation_create_dashboard'><button>Create a quotation</button></a>
		<a href='/agungelektrindo/sales_department/quotation_edit_dashboard' id='quotation_edit_dashboard'><button>Manage quotation</button></a>
	</div>
	<button class='dropdown_button' id='customer_side'>Customers</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/customer_create_dashboard' id='customer_create_dashboard'><button>Add Customer</button></a>
		<a href='/agungelektrindo/sales_department/customer_manage_dashboard' id='customer_manage_dashboard'><button>Manage Customer</button></a>
	
<?php if($role == 'superadmin'){ ?>
		<a href='/agungelektrindo/sales_department/customer_black_list' id='customer_black_list'><button>Blacklist Customer</button></a>
<?php } ?>
	</div>
	<button class='dropdown_button' id='sales_order_side'>Sales Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/sales_order_create_dashboard' id='sales_order_create_dashboard'><button>Create sales order</button></a>
		<a href='/agungelektrindo/sales_department/sales_order_confirm_dashboard' id='sales_order_confirm_dashboard'><button>Confirm sales order</button></a>
		<a href='/agungelektrindo/sales_department/sales_order_edit_dashboard' id='sales_order_edit_dashboard'><button>Edit sales order</button></a>
		<a href='/agungelektrindo/sales_department/sales_order_archive' id='sales_order_archive'><button>Archives</button></a>
	</div>
	<a href='/agungelektrindo/sales_department/check_stock'>
		<button>Check Stock</button>
	</a>
	<button class='dropdown_button' id='return_side'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/return_dashboard' id='return_dashboard'><button>Create return</button></a>
<?php if($role == 'superadmin'){ ?>	
		<a href='/agungelektrindo/sales_department/return_confirm_dashboard' id='return_confirm_dashboard'><button>Confirm return</button></a>
<?php
	}
?>
	</div>
	<button class='dropdown_button' id='project_side'>Project</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/project_add_dashboard' id='project_add_dashboard'><button>Add project</button></a>
		<a href='/agungelektrindo/sales_department/project_manage_dashboard' id='project_manage_dashboard'><button>Manage project</button></a>
		<a href='/agungelektrindo/sales_department/project_archives' id='project_archives'><button>Archives</button></a>
	</div>
	<button class='dropdown_button' id='sample_side'>Samples</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/sample_add_dashboard' id='sample_add_dashboard'><button>Add sampling</button></a>
		<a href='/agungelektrindo/sales_department/sample_confirm_dashboard' id='sample_confirm_dashboard'><button>Confirm</button></a>
	</div>
	<button class='dropdown_button' id='promotion_side'>Promotion</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/promotion_add_dashboard' id='promotion_add_dashboard'><button>Add Promo</button></a>
		<a href='/agungelektrindo/sales_department/promotion_manage_dashboard' id='promotion_manage_dashboard'><button>Manage Promo</button></a>
	</div>
<?php if($hpp == 1){ ?>
	<a  href='/agungelektrindo/sales_department/check_cost_dashboard'>
		<button>Check value</button>
	</a>
<?php } ?>
	<hr>
	<a href='/agungelektrindo/sales' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Sales Department
	</a>
</div>
<style>
	
</style>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
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