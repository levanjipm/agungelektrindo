<div class="sidenav">
	<button style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button>Purchase Order</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/purchase_order_create_dashboard'><p>Create a PO</p></a>
<?php
	if($role == 'superadmin'){
?>
		<a href='/agungelektrindo/purchasing_department/purchase_order_edit_dashboard'><p>Edit a PO</p></a>
		<a href='/agungelektrindo/purchasing_department/purchase_order_close_dashboard'><p>Close a PO</p></a>
<?php
	}
?>
		<a href='/agungelektrindo/purchasing_department/purchase_order_archive'><p>Archives</p></a>
	</div>
	<button>Supplier</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/supplier_add_dashboard'><p>Add supplier</p></a>
<?php
	if($role == 'superadmin'){
?>
		<a href='/agungelektrindo/purchasing_department/supplier_edit_dashboard'><p>Edit supplier</p></a>
<?php
	};
?>
	</div>
	<button>Item list</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/item_add_dashboard'><p>Add item list</p></a>
		<a href='/agungelektrindo/purchasing_department/item_manage_dashboard'><p>Manage item list</p></a>
		<a href='/agungelektrindo/purchasing_department/item_add_class_dashboard'><p>Item list cat.</p></a>
	</div>
	<button>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/purchasing_department/return_create_dashboard'><p>Create Return</p></a>
		<a href='/agungelektrindo/purchasing_department/purchasing_return_confirm_dashboard'><p>Confirm Return</p></a>
	</div>
	<a href='report_dashboard'><button>Purchase Report</button></a>
	<hr>
	<a href='/agungelektrindo/purchasing' style='color:#1ac6ff;text-decoration:none'>
		<i class="fa fa-eercast" aria-hidden="true"></i>Purchasing Department
	</a>
</div>
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