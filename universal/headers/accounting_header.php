<div class='sidenav'>
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Sales Invoice</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/build_invoice_dashboard'><p>Create an invoice<p></a>
<?php if ($role == 'superadmin'){ ?>
		<a href='/agungelektrindo/accounting_department/confirm_invoice_dashboard'><p>Confirm an invoice</p></a>
<?php } ?>
		<a href='/agungelektrindo/accounting_department/invoice_archive'><p>Archives</p></a>
	</div>
	<button class='dropdown_button'>Purchase Invoice</button>	
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/debt_document_dashboard'><p>Create debt document</p></a>
<?php if ($role == 'superadmin'){ ?>
		<a href='/agungelektrindo/accounting_department/confirm_purchase_dashboard'><p>Confirm document</p></a>
<?php } ?>
		<a href='/agungelektrindo/accounting_department/waiting_for_billing'><p>Pending bills</p></a>
		<a href='/agungelektrindo/accounting_department/purchase_archive'><p>Archives</p></a>
<?php
	if($role == 'superadmin'){
?>
		<a href='/agungelektrindo/accounting_department/random_debt_document'><p>Input random</p></a>
<?php
	}
?>
	</div>
	<button type='button' class='dropdown_button'>Journals</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/sales_journal'><p>Sales journal</p></a>
		<a href='/agungelektrindo/accounting_department/purchasing_journal'><p>Purchasing journal</p></a>
	</div>
	<a href='/agungelektrindo/accounting_department/receivable_dashboard'>
		<button class='dropdown_button'>Receivable</button>
	</a>
	<a href='/agungelektrindo/accounting_department/payable_dashboard'>
		<button class='dropdown_button' style='color:white'>Payable</button>
	</a>
	<button class='dropdown_button'>Bank</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/assign_bank_dashboard'><p>Assign bank data</p></a>
		<a href='/agungelektrindo/accounting_department/reset_bank_dashboard'><p>Edit bank data</p></a>
	</div>
	<button type='button' class='dropdown_button' style='color:white'>Return</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/sales_return_dashboard'><p>Sales return</p></a>
		<a href='/agungelektrindo/accounting_department/purchasing_return_dashboard'><p>Purchasing return</p></a>
	</div>
	<button class='dropdown_button'>Random Invoice</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/accounting_department/build_proforma_invoice_dashboard'><p><i>Proforma Invoice</i></p></a>
		<a href='/agungelektrindo/accounting_department/down_payment_dashboard'><p><i>DP Invoice</i></p></a>
		<a href='/agungelektrindo/accounting_department/random_invoice_archive.php'><p>Archives</p></a>
	</div>
	<hr>
	<a href='/agungelektrindo/accounting' style='color:#1ac6ff;text-decoration:none'><i class="fa fa-eercast" aria-hidden="true"></i>Accounting Department</a>
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