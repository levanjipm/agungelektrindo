<?php
	include ("salesheader.php");
?>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createsalesorder.js"></script>
<script>
function disable_year(){
	document.getElementById("kosong").disabled = true;
	buka();
}
</script>
<body>
<div class="main">
	<h2 style='font-family:bebasneue'>Sales Order</h2>
	<h4 style="color:#444">Edit or close Sales Order</h4>
	<hr>
	<div class='row'>
		<div class='col-sm-4 col-sm-offset-4'>
			<div class="input-group">
				<span class="input-group-addon">
					<button type='button' class='btn btn-default' style='width:100%;padding:0;background-color:transparent;border:none'  onclick='search_quotation()'>
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
				</span>
				<input type="text" id="search" name="search" class="form-control" placeholder="Search here">
			</div>
			<hr>
		</div>	
	</div>
	<table class='table table-bordered'>
		<tr>
			<th>Date</th>
			<th>Name</th>
			<th>Customer</th>
			<th>Note</th>
<?php
	if($role == 'superadmin'){
?>
			<th></th>
<?php
	}
?>
		</tr>
		<tbody id='edit_sales_order_table'>
<?php
	$sql_initial = "SELECT DISTINCT(so_id) AS so_id FROM sales_order WHERE status = '0'";
	$result_initial = $conn->query($sql_initial);
	if(mysqli_num_rows($result_initial) > 0){
		while($initial = $result_initial->fetch_assoc()){
			$sql_code = "SELECT * FROM code_salesorder WHERE id = '" . $initial['so_id'] . "'";
			$result_code = $conn->query($sql_code);
			$code = $result_code->fetch_assoc();
			if($code['customer_id'] == 0){
				$customer_name	= $code['retail_name'];
			} else {
				$sql_customer = "SELECT name FROM customer WHERE id = '" . $code['customer_id'] . "'";
				$result_customer	= $conn->query($sql_customer);
				$customer			= $result_customer->fetch_assoc();
				$customer_name		= $customer['name'];
			}
?>
			<tr>
				<td><?= date('d M Y',strtotime($code['date'])) ?></td>
				<td><?= $code['name'] ?></td>
				<td><?= $customer_name ?></td>
				<td><?= $code['note'] ?></td>
<?php
	if($role == 'superadmin'){
?>
				<td><button type='button' class='button_danger_dark' onclick='submit_form_edit(<?= $initial['so_id'] ?>)'>Edit</button></td>
				<form id='form_edit_sales_order-<?= $initial['so_id'] ?>' action='edit_so' method='POST'>
					<input type='hidden' value='<?= $initial['so_id'] ?>' name='id'>
				</form>
<?php
	}
?>		
			</tr>
<?php
		}
?>
		</tbody>
	</table>
					</div>
					<hr>
				</div>
			</div>
			<div class='col-sm-8' id='viewpane'>
			</div>
		</div>
	</div>
</div>
</body>
<script>
function submit_form_edit(n){
	$('#form_edit_sales_order-' + n).submit();
};

function search_quotation(){
	if(($('#search')).val() == ''){
		alert('Please insert a keyword!');
		return false;
	} else {
		$.ajax({
			url: "ajax/search_so.php",
			data: {
				term: $('#search').val()
			},
			type: "POST",
			dataType: "html",
			success: function (data) {
				$('#quotation_result').html(data);
			},
			error: function (xhr, status) {
				alert("Sorry, there was a problem!");
			},
			complete: function (xhr, status) {
			}
		});
	}
};
</script>
<?php
	} else {
		echo ('There is no sales order to be seen');
	}
?>