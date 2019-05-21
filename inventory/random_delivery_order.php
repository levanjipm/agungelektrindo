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
		<script>
			$(document).ready(function(){
				$('#reference1').autocomplete({
					source: "ajax/search_item.php"
				})
			});
		</script>
		<a href="#" id="folder"><i class="fa fa-folder"></i></a>
		<a href="#" id="close"><i class="fa fa-close"></i></a>
		<label>Customer</label>
		<select class='form-control' name='customer'>
			<option value='0'>Please select a customer</option>
<?php
        $sql = "SELECT id,name FROM customer ORDER BY name";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
?>
			<option value='<?= $row['id'] ?>'><?= $row['name'] ?></option>
<?php
		}
?>
		</select>
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
		<script>
		var i;
		var a = 2;
		$("#folder").click(function (){	
			if(a == 4){
				alert('Maximum input is 3!');
				return false;
			} else {
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
				$('#jumlah').val(a);
				a++;
			}
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
	<input type='hidden' value='1' id='jumlah' name='jumlah'>
	<button type='button' class='btn btn-default'>Proceed</button>
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