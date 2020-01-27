<div class='sidenav'>
	<button style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Bank Account</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/financial_department/view_mutation_dashboard'><button>Mutation</button></a>
		<a href='/agungelektrindo/financial_department/assign_bank_dashboard'><button>Assign bank data</button></a>
		<a href='/agungelektrindo/financial_department/bank_assign_data'><button>Complete bank data</button></a>
		<a href='/agungelektrindo/financial_department/transaction_add_dashboard'><button>Add transaction</button></a>
		<a href='/agungelektrindo/financial_department/client_add_dashboard'><button>Add opponent</button></a>
	</div>
	<button class='dropdown_button'>Petty Cash</button>
	<div class='dropdown-container'>
		<a href='/agungelektrindo/financial_department/petty_dashboard'><button>Add a transaction</button></a>
		<a href='/agungelektrindo/financial_department/petty_view'><button>View table</button></a>
	</div>
	<button class='dropdown_button'>Inventory management</button>
		<div class='dropdown-container'>
		<a href='/agungelektrindo/financial_department/inventory_management'><button>Manage inventory</button></a>
		<a href='/agungelektrindo/financial_department/inventory_'><button>Edit transaction</button></a>
	</div>
	<a href='/agungelektrindo/financial_department/payment_dashboard'><button>Make a payment</button></a>
	<hr>
	<a href='/agungelektrindo/financial' style='color:#1ac6ff;text-decoration:none'><i class="fa fa-eercast" aria-hidden="true"></i>Financial Department</a>
</div>
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
