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
?>
	<a href="#" id="folder"><i class="fa fa-folder"></i></a>
	<a href="#" id="close"><i class="fa fa-close"></i></a>
	<form action='random_delivery_order_validation.php' method='POST'>
		<input type='hidden' value='1' name='type'>
		<label>Customer</label>
		<select class='form-control' name='customer'>
			<option value='0'>Pelase select a customer</option>
<?php
		$sql_customer = "SELECT id,name FROM customer ORDER BY name ASC";
		$result_customer = $conn->query($sql_customer);
		while($customer = $result_customer->fetch_assoc()){
?>
			<option value='<?= $customer['id'] ?>'><?= $customer['name'] ?></option>
<?php
		}
?>
		</select>
		<label>Project name</label>
		<input type='text' class='form-control' name='project_name'>
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
		break;

    case "2":
        echo "Your favorite color is blue!";
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