<div class='sidenav'>
	<button style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button>Quotations</button>
	<div class='dropdown-container'>
		<a href='sales_department/quotation_create_dashboard'><p>Create a quotation</p></a>
		<a href='sales_department/quotation_edit_dashboard'><p>Print or edit a quotation</p></a>
	</div>
	<button>Customers</button>
	<div class='dropdown-container'>
		<a href='sales_department/customer_create_dashboard'><p>Add Customer</p></a>
		<a href='sales_department/customer_edit_dashboard'><p>Edit Customer</p></a>
	
<?php if($role == 'superadmin'){ ?>
		<a href='customer_black_list'><p>Blacklist Customer</p></a>
<?php } ?>

	</div>
	<button>Sales Order</button>
	<div class='dropdown-container'>
		<a href='sales_order_create_dashboard'><p>Create sales order</p></a>
		<a href='service_sales_order_dashboard'><p>Services SO</p></a>
		<a href='sales_order_confirm_dashboard'><p>Confirm sales order</p></a>
		<a href='edit_sales_order_dashboard'><p>Edit sales order</p></a>
		<a href='sales_order_archive'><p>Archives</p></a>
	</div>
	<button href='sales_department/check_stock'>Check Stock</button>
	<button>Return</button>
	<div class='dropdown-container'>
		<a href='sales_department/return_dashboard'>Create return</a>
<?php if($role == 'superadmin'){ ?>	
		<a href='sales_department/confirm_return_dashboard'>Confirm return</a>
<?php
	}
?>
	</div>
	<button>Project</button>
	<div class='dropdown-container'>
		<a href='sales_department/project_add_dashboard'><p>Add project</p></a>
		<a href='sales_department/edit_project_dashboard'><p>Edit project</p></a>
		<a href='sales_department/view_project_dashboard'><p>View project</p></a>
	</div>
	<button>Samples</button>
	<div class='dropdown-container'>
		<a href='add_sampling_dashboard'>Add sampling</a>
		<a href='confirm_sampling_dashboard'>Confirm</a>
	</div>
	<button>Promotion</button>
	<div class='dropdown-container'>
		<a href='sales_department/promotion_add'>Add Promo</a>
		<a href='sales_department/promotion_manage'>Manage Promo</a>
	</div>
<?php if($hpp == 1){
?>
	<button href='sales_department/check_hpp_dashboard'>Check value</button>
<?php } ?>
	<hr>
	<a href='sales' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Sales Department
	</a>
</div>
<style>
	
</style>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
</div>
<script>
$('.sidenav button').click(function(){
	if($(this).next('.dropdown-container').is(':visible')){
		$(this).css('color','white');
	} else {
		$(this).css('color','#00ccff');
	}
	$(this).next('.dropdown-container').toggle(350);
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