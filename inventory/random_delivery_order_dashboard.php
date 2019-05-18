<?php
	//Random delivery order//
	include('inventoryheader.php');
	//Give option to the type of random delivery order//
?>
<style>
#1 {
	display:block;
}
.detailed{
	background-color:rgba(33,81,161,0.4);
	padding:20px;
	display:none;
	border-radius:20px;
}
.submit{
	background-color:transparent;
	border:2px solid white;
	transition:0.3s all ease;
	border-radius:10px;
}
.submit:hover{
	background-color:#eee
}
</style>
<div class="main">
	<div class='row'>
		<div class='col-sm-6'>
			<form action='random_delivery_order.php' method='POST' id='myForm'>
				<label>Random delivery order type</label>
				<select class="form-control" onchange="select_detail()" id="selecting" name='type'>
					<option value='0'>Please pick type random delivery order</option>
<?php
		$sql_select = "SELECT * FROM type_random_do";
		$result_select = $conn->query($sql_select);
		while($row_select = $result_select->fetch_assoc()){
?>
					<option value="<?= $row_select['id'] ?>"><?= $row_select['prefix'] . ' - ' . $row_select['name'];?></option>
<?php
		}
?>
				</select>
			</form>
		</div>
	</div>
	<button type='button' class='btn btn-primary' onclick='submiting()'>Next</button>
</div>
<script>
	function submiting(){
		if($('#selecting').val() == 0){
			alert('Please select random delivery order type!');
			return false;
		} else {
			$('#myForm').submit();
		}
	}
</script>