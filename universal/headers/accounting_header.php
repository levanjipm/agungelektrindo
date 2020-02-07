<div class='sidenav'>
	<button class='dropdown_button' id='sales_invoice_side'>Sales Invoice</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/build_invoice_dashboard' id='build_invoice_dashboard'><button>Create</button></a>
<?php if ($role == 'superadmin' || $role == 'admin'){ ?>
		<a href='/agungelektrindo/accounting_department/confirm_invoice_dashboard' id='confirm_invoice_dashboard'><button>Confirm</button></a>
<?php } ?>
		<a href='/agungelektrindo/accounting_department/invoice_archive' id='invoice_archive'><button>Archives</button></a>
	</div>
	<button class='dropdown_button' id='purchase_invoice_side'>Purchase Invoice</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/debt_document_dashboard' id='debt_document_dashboard'><button>Create</button></a>
<?php if ($role == 'superadmin' || $role == 'admin'){ ?>
		<a href='/agungelektrindo/accounting_department/random_debt_document' id='random_debt_document'><button>Create blank</button></a>
		<a href='/agungelektrindo/accounting_department/confirm_purchase_dashboard' id='confirm_purchase_dashboard'><button>Confirm</button></a>
<?php } ?>
		<a href='/agungelektrindo/accounting_department/waiting_for_billing' id='waiting_for_billing'><button>Pending bills</button></a>
		<a href='/agungelektrindo/accounting_department/purchase_archive' id='purchase_archive'><button>Archives</button></a>
	</div>
	<button type='button' class='dropdown_button' id='journal_side'>Journals</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/sales_journal' id='sales_journal'><button>Sales journal</button></a>
		<a href='/agungelektrindo/accounting_department/purchasing_journal' id='purchasing_journal'><button>Purchasing journal</button></a>
	</div>
	<a href='/agungelektrindo/accounting_department/receivable_dashboard'>
		<button class='dropdown_button'>Receivable</button>
	</a>
	<a href='/agungelektrindo/accounting_department/payable_dashboard'>
		<button class='dropdown_button' style='color:white'>Payable</button>
	</a>
	<button class='dropdown_button' id='bank_side'>Bank</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/assign_bank_dashboard' id='assign_bank_dashboard'><button>Assign bank data</button></a>
		<a href='/agungelektrindo/accounting_department/reset_bank_dashboard' id='reset_bank_dashboard'><button>Edit bank data</button></a>
	</div>
	<button type='button' class='dropdown_button' id='return_side'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/sales_return_dashboard' id='sales_return_dashboard'><button>Sales return</button></a>
		<a href='/agungelektrindo/accounting_department/purchasing_return_dashboard' id='purchasing_return_dashboard'><button>Purchasing return</button></a>
	</div>
	<hr>
	<a href='/agungelektrindo/accounting' style='color:#1ac6ff;text-decoration:none'><button>Accounting</button></a>
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