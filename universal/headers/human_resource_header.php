<div class='sidenav'>
	<button class='dropdown_button'>Manage users</button>
	<div class="dropdown-container">
		<a href='/agungelektrindo/human_resource_department/add_user'><button>Add a user</button></a>
		<a href='/agungelektrindo/human_resource_department/set_inactive_dashboard'><button>Set inactive</button></a>
		<a href='/agungelektrindo/human_resource_department/set_authority_dashboard'><button>Authority</button></a>
	</div>
	<button class='dropdown_button'>Salary Slip</button>
	<div class="dropdown-container">
		<a href='/agungelektrindo/human_resource_department/salary_create_dashboard'><button>Create salary slip</button></a>
		<a href='/agungelektrindo/human_resource_department/manage_tutorial'><button>Salary slip archives</button></a>
	</div>	
	<hr>
	<a href='/agungelektrindo/human_resource'><i class="fa fa-eercast" aria-hidden="true"></i>Human Resource Department</a>
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