<div class='sidenav'>
	<button class='dropdown_button'>Inventory Dept.</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/delivery_order_delete_dashboard'><button>Delete delivery order</button></a>
		<a href='/agungelektrindo/administrator_department/good_receipt_delete_dashboard'><button>Delete goods receipt</button></a>
		<a href='/agungelektrindo/administrator_department/delivery_order_project_delete_dashboard'><button>Delete project DO</button></a>
	</div>
	<button class='dropdown_button'>Accounting Dept.</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/invoice_edit_dashboard'><button>Edit invoice doc.</button></a>
		<a href='/agungelektrindo/administrator_department/purchase_edit_dashboard'><button>Edit purchase doc.</button></a>
	</div>
	<button type='button' class='dropdown_button'>Finance Dept.</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/reset_bank_dashboard'><button>Reset bank data</button></a>
		<a href='/agungelektrindo/administrator_department/reset_petty_dashboard'><button>Petty cash</button></a>
	</div>
	<button type='button' class='dropdown_button'>Purchasing Dept.</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/purchase_order_edit_dashboard'><button>Edit a PO</button></a>
		<a href='/agungelektrindo/administrator_department/purchase_order_close_dashboard'><button>Close a PO</button></a>
	</div>
	<button class='dropdown_button'>Other</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/receivable_dashboard'><button>Manage project</button></a>
		<a href='/agungelektrindo/administrator_department/income_statement_dashboard'><button>Income statement</button></a>
	</div>
	<hr>
	<a href='/agungelektrindo/administrator' style='color:#1ac6ff;text-decoration:none'><i class="fa fa-eercast" aria-hidden="true"></i>Admin</a>
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