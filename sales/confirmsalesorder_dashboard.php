<?php
	include('salesheader.php');
?>
<div class='main'>
<?php
	if(empty($_GET['alert'])){
	} else if($_GET['alert'] == 'true'){
?>
	<div class="alert alert-success" id='alert'>
		<strong>Success!</strong> Input data success.
	</div>
<?php
	} else if($_GET['alert'] == 'warning'){	
?>
	<div class="alert alert-warning" id='alert'>
		<strong>Warning</strong> Input data unsuccess.
	</div>
<?php
	}
?>
	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$('#alert').fadeOut();
			},1000);
		});
	</script>
	<h2>Sales order</h2>
	<p>Confirm sales order</p>
	<hr>
	<table class='table table-hover'>
		<tr>
			<th>Date</th>
			<th>Customer</th>
			<th>Name</th>
			<th></th>
		</tr>
<?php
	$sql_so = "SELECT * FROM code_salesorder WHERE isconfirm = '0'";
	echo $sql_so;
	$result_so = $conn->query($sql_so);
	while($so = $result_so->fetch_assoc()){
?>
		<tr>
			<td><?= date('d M Y',strtotime($so['date'])) ?></td>
			<td style='text-align:left'><?php
				if($so['customer_id'] > 0){
					$sql_customer = "SELECT name,address,city FROM customer WHERE id = '" . $so['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
					echo '<p><strong>' . $customer['name'] . '</strong></p>';
					echo '<p>' . $customer['address'] . '</p>';
					echo $customer['city'];
				}
			?></td>
			<td><?= $so['name'] ?></td>
			<td>
				<button type='button' class='btn btn-default' onclick='submit(<?= $so['id'] ?>)'>Confirm SO</button>
				<button type='button' class='btn btn-danger'>Delete SO</button>
				<form action='confirmsalesorder.php' method='POST' id='form<?= $so['id'] ?>'>
					<input type='hidden' value='<?= $so['id'] ?>' name='id'>
				</form>
			</td>
		</tr>
<?php
	}
?>
	</table>
</div>
<script>
	function submit(n){
		$('#form' + n).submit();
	}
</script>