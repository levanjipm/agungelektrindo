<div class='sidenav'>
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Inventory Dept.</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/delivery_order_delete_dashboard'><p>Delete delivery order<p></a>
		<a href='/agungelektrindo/administrator_department/good_receipt_delete_dashboard'><p>Delete goods receipt<p></a>
	</div>
	<button class='dropdown_button'>Accounting Dept.</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/invoice_edit_dashboard'><p>Edit invoice doc.</p></a>
		<a href='/agungelektrindo/administrator_department/purchase_edit_dashboard'><p>Edit purchase doc.</p></a>
	</div>
	<button type='button' class='dropdown_button'>Finance Dept.</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/reset_bank_dashboard'><p>Reset bank data</p></a>
		<a href='/agungelektrindo/administrator_department/reset_petty_dashboard'><p>Petty cash</p></a>
	</div>
	<button class='dropdown_button'>Other</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/administrator_department/receivable_dashboard'><p>Manage project</p></a>
		<a href='/agungelektrindo/administrator_department/income_statement_dashboard'><p>Income statement</p></a>
	</div>
	<hr>
	<a href='/agungelektrindo/administrator' style='color:#1ac6ff;text-decoration:none'><i class="fa fa-eercast" aria-hidden="true"></i>Admin</a>
</div>
<div class='sidenav_small'>
	<i class="fa fa-bars" aria-hidden="true"></i>
</div>
<script>
	$('.dropdown_button').click(function(){
		if($(this).next().is(':visible')){
			$(this).css('background-color','transparent');
		} else {
			$(this).css('background-color','#00ccff');
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