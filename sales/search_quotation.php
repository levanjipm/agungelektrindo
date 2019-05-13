 <?php
include("salesheader.php");
?>
<head>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createquotation.js"></script>
</head>
<script>
$( function() {
	$('#customer').autocomplete({source: "ajax/search_customer.php"});
	$( "#customer" ).autocomplete( "option", "appendTo", ".eventInsForm" );
});
</script>
<style>
.ui-autocomplete-input {
  z-index: 1511;
  position: relative;
}
.ui-menu .ui-menu-item a {
  font-size: 12px;
}
.ui-autocomplete {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1510 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 0;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
}
.ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
}
.ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
}
.btn-search{
	background-color:transparent;
}
.picked{
	border-bottom:2px solid #eee;
	font-weight: bold;
}
</style>		
<?php
	$search = $_POST['search'];
	$sql_init1 = "SELECT * FROM customer WHERE name LIKE '%" . $search . "%'";
	$result_init1 = $conn->query($sql_init1);
	$badge1 = mysqli_num_rows($result_init1);
	$sql_init2 = "SELECT * FROM quotation WHERE reference LIKE '%" . $search . "%'";
	$result_init2 = $conn->query($sql_init2);
	$badge2 = mysqli_num_rows($result_init2);
?>
<div class="main">
	<div class="container">
		<h3>Search result for</h3>
		<p><?= $search ?></p>
		<div class="row">
			<div class="col-lg-3">
				<button type="button" class="btn btn-search picked" onclick='pick(1)' id="button1">Based on customer<span class="badge"><?= $badge1 ?></span></button>
			</div>
			<div class="col-lg-3">
				<button type="button" class="btn btn-search" onclick='pick(2)' id="button2">Based on reference<span class="badge"><?= $badge2 ?></span></button>
			</div>
		</div>
	</div>
	<br><br>
	<div class="container" id='search1'>
<?php
	$sql_customer = "SELECT * FROM customer WHERE name LIKE '%" . $search . "%'";
	$r = $conn->query($sql_customer);
	while($rows = $r->fetch_assoc()){
		$id = $rows['id'];
		$customer_name = $rows['name'];	
		$sql = "SELECT * FROM code_quotation WHERE customer_id = '" . $id . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$num_rows = mysqli_num_rows($result);
			if ($num_rows > 0){
?>
		<div class="row">
			<div class="col-lg-6">
				<div class="container" style="padding:20px">
						<strong>
							<?= $customer_name ?>,
							<?= $row['name']; ?>
						</strong>
					</a>
						<br>
						<?= $row['date'] ?>
				</div>
			</div>
			<div class="col-lg-6">
				<a href="editquotation.php?id=<?= $row['id']?>" style="text-decoration:none;color:black">
					<button type='button' class='btn btn-success'>
						Edit quotation
					</button>
				</a>
				<button type='button' class='btn btn-warning' onclick='submit_form(<?= $row['id']?>)'>
					Print quotation
					<form id='<?= $row['id'] ?>' action='createquotation_print.php' method='POST' target='_blank'>
						<input type='hidden' value='<?= $row['id'] ?>' name='id'>
					</form>
				</button>
				<button type="button" class="btn btn-copy" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Copy quotation</button>
			</div>
		</div>
		<hr>
		<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Copy quotation</h4>
					</div>
					<form action="copy_quotation.php" method="POST" id='pasting<?=$row['id']?>'>
						<input type='hidden' value='<?= $row['id'] ?>' name='id'>
						<div class="modal-body">
							<label for="name" >Customer</label>
							<input class="form-control" for="name" required id="customer" name='customer'>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" onclick='copy_form(<?= $row['id'] ?>)'>Copy</button>
					</div>
				</div>
			</div>
		</div>
<?php
			}
		}
	}
?>
	</div>
	<div class="container" id='search2' style='display:none'>
<?php
	$sql_reference = "SELECT * FROM quotation WHERE reference LIKE '%" . $search . "%'";
	$result_reference = $conn->query($sql_reference);
	while($row_reference = $result_reference->fetch_assoc()){
		$quotation_code = $row_reference['quotation_code'];
		$sql = "SELECT * FROM code_quotation WHERE id = '" . $quotation_code . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$num_rows = mysqli_num_rows($result);
			$customer_id = $row['customer_id'];
			$sql_customer = "SELECT name FROM customer WHERE id = '" . $customer_id . "'";
			$result_customer = $conn->query($sql_customer);
			while($row_customer = $result_customer->fetch_assoc()){
				$customer_name_reference = $row_customer['name'];
			}
			if ($num_rows > 0){
?>
		<div class="row">
			<div class="col-lg-6">
				<div class="container" style="padding:20px">
					<strong>
						<?= $customer_name_reference ?>,
						<?= $row['name']; ?>
					</strong>
					<br>
					<?= $row['date'] ?>
				</div>
			</div>
			<div class="col-lg-6">
				<a href="editquotation.php?id=<?= $row['id']?>" style="text-decoration:none;color:black">
					<button type='button' class='btn btn-success'>
						Edit quotation
					</button>
				</a>
				<button type='button' class='btn btn-warning' onclick='submit_form(<?= $row['id']?>)'>
					Print quotation
					<form id='<?= $row['id'] ?>' action='createquotation_print.php' method='POST'>
						<input type='hidden' value='<?= $row['id'] ?>' name='id'>
					</form>
				</button>
				<button type="button" class="btn btn-copy" data-toggle="modal" data-target="#myModal-<?=$row['id']?>">Copy quotation</button>
			</div>
		</div>
		<hr>
		<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Copy quotation</h4>
					</div>
					<form action="copy_quotation.php" method="POST" id='pasting<?=$row['id']?>'>
						<input type='hidden' value='<?= $row['id'] ?>' name='id'>
						<div class="modal-body">
							<label for="name" >Customer</label>
							<input class="form-control" for="name" required id="customer" name='customer'>
						</div>
					</form>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-success" onclick='copy_form(<?= $row['id'] ?>)'>Copy</button>
					</div>
				</div>
			</div>
		</div>
<?php
			}
		}
	}
?>
	</div>
<script>
function pick(n){
	var pilih = n;
	$('button[id^=button]').removeClass('picked');
	$('div[id^=search]').hide()
	$('button[id=button' + n).addClass('picked');
	$('div[id^=search' + n + ']').show()
}

function submit_form(n){
	var id = n;
	$('#' + id).submit();
}
function copy_form(n){
	var name = n;
	$('#pasting' + name).submit();
}
</script>