<div class='sidenav'>
	<button style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Quotations</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/quotation_create_dashboard'><p>Create a quotation</p></a>
		<a href='/agungelektrindo/sales_department/quotation_edit_dashboard'><p>Print or edit a quotation</p></a>
	</div>
	<button class='dropdown_button'>Customers</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/customer_create_dashboard'><p>Add Customer</p></a>
		<a href='/agungelektrindo/sales_department/customer_edit_dashboard'><p>Edit Customer</p></a>
	
<?php if($role == 'superadmin'){ ?>
		<a href='/agungelektrindo/sales_department/customer_black_list'><p>Blacklist Customer</p></a>
<?php } ?>

	</div>
	<button class='dropdown_button'>Sales Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/sales_order_create_dashboard'><p>Create sales order</p></a>
		<a href='/agungelektrindo/sales_department/sales_order_confirm_dashboard'><p>Confirm sales order</p></a>
		<a href='/agungelektrindo/sales_department/sales_order_edit_dashboard'><p>Edit sales order</p></a>
		<a href='/agungelektrindo/sales_department/sales_order_archive'><p>Archives</p></a>
	</div>
	<a href='/agungelektrindo/sales_department/check_stock'>
		<button >Check Stock</button>
	</a>
	<button class='dropdown_button'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/return_dashboard'><p>Create return</p></a>
<?php if($role == 'superadmin'){ ?>	
		<a href='/agungelektrindo/sales_department/return_confirm_dashboard'><p>Confirm return</p></a>
<?php
	}
?>
	</div>
	<button class='dropdown_button'>Project</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/project_add_dashboard'><p>Add project</p></a>
		<a href='/agungelektrindo/sales_department/project_manage_dashboard'><p>Manage project</p></a>
	</div>
	<button class='dropdown_button'>Samples</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/sample_add_dashboard'><p>Add sampling</p></a>
		<a href='/agungelektrindo/sales_department/sample_confirm_dashboard'><p>Confirm</p></a>
	</div>
	<button class='dropdown_button'>Promotion</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/sales_department/promotion_add_dashboard'><p>Add Promo</p></a>
		<a href='/agungelektrindo/sales_department/promotion_manage_dashboard'><p>Manage Promo</p></a>
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