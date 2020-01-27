<?php
	include('../codes/connect.php');
?>
	<table class='table table-bordered'>
		<tr>
			<th>Project name</th>
			<th>Customer</th>
		</tr>
<?php
	if(empty($_POST['page'])){
		$sql		= "SELECT * FROM code_project WHERE major_id = '0' LIMIT 20";
	} else {
		$page		= $_POST['page'];
		$offset		= ($page - 1) * 20;
		$sql		= "SELECT id, project_name, customer_id FROM code_project WHERE major_id = '0' AND isdone = '1' AND issent = '1' LIMIT 20 OFFSET $offset";
	}
	
	$sql_count		= "SELECT id FROM code_project WHERE major_id = '0'";
	$result_count	= $conn->query($sql_count);
	
	$count			= mysqli_num_rows($result_count);
	$max_page		= ceil($count / 20);
	
	$result		= $conn->query($sql);
	while($row	= $result->fetch_assoc()){
		$name	= $row['project_name'];
		$id		= $row['id'];
		$customer_id		= $row['customer_id'];
		$sql_customer		= "SELECT name, address, city FROM customer WHERE id = '$customer_id'";
		$result_customer	= $conn->query($sql_customer);
		$customer			= $result_customer->fetch_assoc();
		
		$customer_name		= $customer['name'];
		$customer_address	= $customer['address'];
		$customer_city		= $customer['city'];
?>
		<tr>
		<td><?= $name; ?></td>
			<td>
				<p style='font-family:museo'><?= $customer_name ?></p>
				<p style='font-family:museo'><?= $customer_address ?></p>
				<p style='font-family:museo'><?= $customer_city ?></p>
			</td>
			<td>
				<a href='/agungelektrindo/sales_department/project_archives_show.php?id=<?= $id ?>'>
					<button type='button' class='button_success_dark'><i class='fa fa-eye'></i></button>
				</a>
			</td>
		</tr>
<?php
	}
?>
	</table>
	
	<select class='form-control' id='page' style='width:100px;display:inline-block'>
<?php
	for($i = 1; $i <= $max_page; $i++){
?>
		<option value='<?= $i ?>' <?php if(!empty($_POST['page']) && $page == $i){ echo 'selected'; } ?>><?= $i ?></option>
<?php
	}
?>
	</select>
	<button type='button' class='button_default_dark' id='search_page' style='display:inline-block'><i class='fa fa-search'></i></button>
	<script>
		$('#search_page').click(function(){
			$.ajax({
				url: "project_archives_view.php",
				data: {
					page: $('#page').val(),
				},
				type: "POST",
				dataType: "html",
				beforeSend:function(){
					$('#project_archive_pane').html("<h2 style='font-size:4em;text-align:center'><i class='fa fa-spin fa-spinner'></i></h2>");
				},
				success: function (data) {
					$('#project_archive_pane').html(data);
				},
			});
		});
	</script>