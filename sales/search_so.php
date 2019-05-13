 <?php
include("salesheader.php");
?>
<head>
<link rel="stylesheet" href="../jquery-ui.css">
<script src="../jquery-ui.js"></script>
<script type="text/javascript" src="scripts/createquotation.js"></script>
<script>
$( function() {
	$('#customer').autocomplete({
		source: "search_customer.php"
	 })
});
</script>
</head>
<style>
.btn-search{
	background-color:transparent;
}
.picked{
	border-bottom:2px solid #eee;
	font-weight: bold;
}
</style>		
<?php
	$badge1 = 0;
	$search = $_POST['search'];
	$sql_init1 = "SELECT id FROM customer WHERE name LIKE '%" . $search . "%'";
	$result_init1 = $conn->query($sql_init1);
	while($row_init1 = $result_init1->fetch_assoc()){
		$parameter = $row_init1['id'];
		$sql_badge = 'SELECT COUNT(*) AS jumlah FROM code_salesorder WHERE customer_id = "' . $parameter . '"';
		$result_badge = $conn->query($sql_badge);
		$row_badge_1 = $result_badge->fetch_assoc();
		if($row_badge_1['jumlah'] > 0){
			$badge1 = $badge1 + mysqli_num_rows($result_badge);
		}
	}
	$sql_init2 = "SELECT * FROM sales_order WHERE reference LIKE '%" . $search . "%'";
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
	$sql_customer = "SELECT name,id FROM customer WHERE name LIKE '%" . $search . "%'";
	$r = $conn->query($sql_customer);
	while($rows = $r->fetch_assoc()){
		$id = $rows['id'];
		$customer_name = $rows['name'];	
		$sql_code = "SELECT * FROM code_salesorder WHERE customer_id = '" . $id . "'";
		$result_code = $conn->query($sql_code);
		if(mysqli_num_rows($result_code) != 0){
			$code = $result_code->fetch_assoc();
			$name = $code['name'];
			$so_id = $code['id'];
			$date = $code['date'];
?>
		<div class="row">
			<div class="col-lg-8">
				<div class="container" style="padding:20px">
					<strong>
						<?= $customer_name ?>,
						<?= $name; ?>
					</strong>
					<br>
					<?= $date ?>
				</div>
			</div>
			<div class='col-lg-4'>
				<button type='button' onclick='edit(<?= $so_id ?>)' class='btn btn-success'>
					Edit Sales Order
				</button>
			</div>
			<form id='form<?= $so_id ?>' action='edit_so.php' method="POST">
				<input type='hidden' value='<?= $so_id ?>' name='id'>
			</form>
		</div>
		<hr>
<?php
		}
	}
?>
<script>
	function edit(n){
		var id = n;
		$('#form' + id).submit()
	};
</script>
	</div>
	<div class="container" id='search2' style='display:none'>
<?php
	$sql_reference = "SELECT * FROM sales_order WHERE reference LIKE '%" . $search . "%'";
	$result_reference = $conn->query($sql_reference);
	while($row_reference = $result_reference->fetch_assoc()){
		$so_id = $row_reference['so_id'];
		$sql = "SELECT * FROM code_salesorder WHERE id = '" . $so_id . "' ORDER BY id DESC";
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
			<div class="col-lg-8">
				<div class="container" style="padding:20px">
					<a href="editquotation.php?id=<?= $row['id']?>" style="text-decoration:none;color:black">
						<strong>
							<?= $customer_name_reference ?>,
							<?= $row['name']; ?>
						</strong>
					</a>
						<br>
						<?= $row['date'] ?>
				</div>
			</div>
			<div class="col-lg-4">
				<button type="button" class="btn btn-copy">Copy quotation</button>
			</div>
		</div>
		<hr>
		<div class="modal" id="myModal-<?=$row['id']?>" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit Item List</h4>
					</div>
					<form id="editsupplier-<?=$row['id']?>" action="edititem.php" method="POST">
					<div class="modal-body">
						<input name="id" type="hidden" value="<?php echo $row['id']?>">
						<label for="name">Date:</label>
						<input class="form-control" for="name" type="date" value="<?php echo date('Y-m-d');?>">
						<label for="name" >Customer</label>
						<input class="form-control" for="name" name="description" value="<?=$customer?>" required id="customer">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success"  id="edit">Edit</button>
					</div>
					</form>
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
</script>