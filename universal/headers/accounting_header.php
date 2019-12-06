<div class='sidenav'>
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Sales Invoice</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/invoice_create_dashboard'><p>Create an invoice<p></a>
<?php if ($role == 'superadmin'){ ?>
		<a href='/agungelektrindo/accounting_department/edit_invoice_dashboard'><p>Edit an invoice</p></a>
		<a href='/agungelektrindo/accounting_department/confirm_invoice_dashboard'><p>Confirm an invoice</p></a>
<?php } ?>
		<a href='invoice_archive.php'><p>Archives</p></a>
	</div>
	<button class='dropdown_button'>Purchase Invoice</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/debt_document_dashboard'><p>Input debt document</p></a>
		<a href='/agungelektrindo/accounting_department/confirm_purchase_dashboard'><p>Confirm document</p></a>
		<a href='/agungelektrindo/accounting_department/waiting_for_billing'><p>Pending bills</p></a>
		<a href='/agungelektrindo/accounting_department/purchase_archive'><p>Archives</p></a>
<?php
	if($role == 'superadmin'){
?>
		<a href='random_debt_document'><p>Input random</p></a>
<?php
	}
?>
	</div>
	<button type='button' class='btn-badge dropdown-btn' style='color:white'>
		<i class="fa fa-code" aria-hidden="true"></i>
		Counter Bill
	</button>
	<div class='dropdown-container'>
		<a href="counter_bill_dashboard">
			<p>Create counter bill</p>
		</a>
		<a href="view_counter_bill">
			<p>View counter bill</p>
		</a>
	</div>
	<button type='button' class='dropdown_button'>Journals</button>
	<div class='dropdown-container'>
		<a href="sales_journal">
			<p>Sales journal</p>
		</a>
		<a href="purchasing_journal">
			<p>Purchasing journal</p>
		</a>
		<a href="stock_value_dashboard">
			<p>Stock value</p>
		</a>
	</div>
	<button class='dropdown_button'>Receivable</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/receivable_dashboard'>
			<p>Dashboard</p>
		</a>
		<a href='receivable_report_customer'>
			<p>Report</p>
		</a>
	</div>
	<a href='/agungelektrindo/accounting_department/payable_dashboard'>
		<button class='dropdown_button' style='color:white'>Payable</button>
	</a>
	<a href='assign_bank_dashboard'>
		<button type='button'>Bank</button>
	</a>
	<button type='button' class='dropdown_button' style='color:white'>Return</button>
	<div class='dropdown-container'>
		<a href="sales_return_dashboard.php"><p>Sales return</p></a>
		<a href="purchasing_return_dashboard.php"><p>Purchasing return</p></a>
	</div>
	<button class='dropdown_button'>Random Invoice</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/build_proforma_invoice_dashboard'><p><i>Proforma Invoice</i></p></a>
		<a href='/agungelektrindo/accounting_department/down_payment_dashboard'><p><i>DP Invoice</i></p></a>
		<a href='/agungelektrindo/accounting_department/random_invoice_archive.php'><p>Archives</p></a>
	</div>
	<a href='/agungelektrindo/accounting_department/income_statement_dashboard'>
		<button>Income statement</button>
	</a>
	<hr>
	<a href='/agungelektrindo/accounting' style='color:#1ac6ff;text-decoration:none'><i class="fa fa-eercast" aria-hidden="true"></i>Accounting Department</a>
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