<?php
	include('inventoryheader.php');
	$type = $_POST['type'];
?>
<script src='../jquery-ui.js'></script>
<link rel='stylesheet' href='../jquery-ui.css'>
<div class='main'>
<?php
switch ($type) {
    case "1":
	$sql = "SELECT * FROM code_project WHERE isdone = '0'";
	$result = $conn->query($sql);
	if(mysqli_num_rows($result) != 0){
?>
	<script>
	$(document).ready(function(){
		$('#reference1').autocomplete({
			source: "ajax/search_item.php"
		})
	});
	</script>
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<form action='random_delivery_order_validation.php' method='POST'>
		<input type='hidden' value='1' name='type'>
		<label>Project name</label>
<?php
	}
		if(mysqli_num_rows($result) != 0){
?>
		<select class='form-control' name='customer'>
			<option value='0'>Pelase select a customer</option>
<?php
			while($row = $result->fetch_assoc()){
?>
			<option value='<?= $row['id'] ?>'><?= $row['project_name'] ?></option>
<?php
			}
?>
		</select>
<?php
		} else {
			echo ('No project to be sent');
			echo '<br>';
			echo '<br>';
		}
?>
		</select>
<?php
		$sql_1 = "SELECT * FROM code_project WHERE isdone = '0'";
		$result_1 = $conn->query($sql_1);
		if(mysqli_num_rows($result_1) != 0){
?>
		<div class='row' style='padding-top:30px'>
			<div class='col-sm-1'>No.</div>
			<div class='col-sm-4'>Reference</div>
			<div class='col-sm-3'>Quantity</div>
		</div>
		<hr>
		<div class='row'>
			<div class='col-sm-1'>
				1
			</div>
			<div class='col-sm-4'>
				<input name='reference1' id='reference1' class='form-control'>
			</div>
			<div class='col-sm-3'>
				<input name='quantity1' id='quantity1' class='form-control'>
			</div>
		</div>
		<div id="input_list">
		</div>
		<hr>
		<button type='button' class='btn btn-default'>Proceed</button>
	</form>
	<script>
		var i;
		var a = 2;
		$("#folder").click(function (){	
		$("#input_list").append(
		'<div class="row" style="padding-top:10px" id="barisan'+a+'">'+
		'<div class="col-sm-1">'+a+'</div>'+
		'<div class="col-sm-4"><input id="reference'+a+'" name="reference'+a+'" class="form-control" style="width:100%"></div>'+
		'<div class="col-sm-3">'+'<input id="quantity'+a+'" name="quantity'+a+'" class="form-control" style="width:100%"></div>'+
		'</div>').find("input").each(function () {
		});
		$("#reference" + a).autocomplete({
			source: "ajax/search_item.php"
		});
		a++;
		});

		$("#close").click(function () {
			if(a>2){
				a--;
				x = 'barisan' + a;
				$("#"+x).remove();
			} else {
				return false;
			}
		});
	</script>
<?php
		} else {
?>
			<br>
			<a href='random_delivery_order_dashboard.php'>
				<button type='button' class='btn btn-success'>Back</button>
			</a>
<?php
		}
		break;

    case "4":
?>
		<div class='row' style='padding-top:30px'>
			<div class='col-sm-12'>
				<h2>Random Delivery Order</h2>
				<p>Samples</p>
				<hr>
				<h3>Send sample</h3>
				<table class='table'>
					<tr>
						<th>Customer</th>
						<th>Date issued</th>
						<th></th>
					</tr>
<?php
				$sql_sample = "SELECT id,customer_id,date FROM code_sample WHERE issent = '0'";
				$result_sample = $conn->query($sql_sample);
				while($sample = $result_sample->fetch_assoc()){
					
					$sql_customer = "SELECT name FROM customer WHERE id = '" . $sample['customer_id'] . "'";
					$result_customer = $conn->query($sql_customer);
					$customer = $result_customer->fetch_assoc();
?>
					<tr>
						<td><?= $customer['name'] ?></td>
						<td><?= date('d M Y',strtotime($sample['date'])) ?></td>
						<td><button type='button' class='btn btn-default' onclick='submiting(<?= $sample['id'] ?>)'>Send</button></td>
					</tr>
					<form action='sample_validate.php' id='submit_form<?= $sample['id'] ?>' method='POST'>
						<input type='hidden' value='<?= $sample['id'] ?>' name='id'>
					</form>
					<tbody>
<?php
					$sql_sample_detail = "SELECT * FROM sample WHERE code_id = '" . $sample['id'] . "'";
					$result_sample_detail = $conn->query($sql_sample_detail);
					while($sample_detail = $result_sample_detail->fetch_assoc()){
?>
						<tr>
							<td><?= $sample_detail['reference'] ?></td>
							<td><?= $sample_detail['quantity'] ?></td>
						</tr>
<?php
				}
?>
					</tbody>
<?php
				}
?>
				</table>
				<h3>Receive back sample</h3>
			</div>
		</div>
		<hr>
		<script>
			function submiting(n){
				$('#submit_form' + n).submit();
			}
		</script>
<?php
		break;
    case "3":
        echo "Your favorite color is green!";
        break;
    case "4":
        echo "Your favorite color is neither red, blue, nor green!";
		break;
	case "5":
        echo "Your favorite color is neither red, blue, nor green!";
		break;
}
?>
</div>