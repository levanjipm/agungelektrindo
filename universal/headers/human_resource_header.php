<div class='sidenav'>
	<button type='button' class='btn-badge' style='text-align:right' id='hide_side_button'><i class="fa fa-chevron-left" aria-hidden="true"></i><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
	<button class='dropdown_button'>Manage users</button>
	<div class="dropdown-container">
		<a href='/agungelektrindo/human_resource_department/add_user'><p>Add a user</p></a>
		<a href='/agungelektrindo/human_resource_department/set_inactive_dashboard'><p>Set inactive</p></a>
		<a href='/agungelektrindo/human_resource_department/set_authority_dashboard'><p>Authority</p></a>
	</div>
	<a href='/agungelektrindo/human_resource_department/salary_create_dashboard'><button>Salary slip</button></a>
	<a href='/agungelektrindo/human_resource_department/absentee_edit_dashboard'><button>Absentee list</button></a>
	<button class='dropdown_button'>Tutorial</button>
	<div class="dropdown-container">
		<a href='/agungelektrindo/human_resource_department/create_tutorial'><p>Create new tutorial</p></a>
		<a href='/agungelektrindo/human_resource_department/manage_tutorial'><p>Manage tutorial</p></a>
	</div>
	<hr>
	<a href='/agungelektrindo/human_resource'><i class="fa fa-eercast" aria-hidden="true"></i>Human Resource Department</a>
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