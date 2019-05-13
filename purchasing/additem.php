<?php
	ob_start();
	include('../Codes/connect.php');
	include("purchasingheader.php");
	$reff = $_POST['itemreff'];
	$description=$_POST['itemdescs'];
	$sql_first = "SELECT * FROM itemlist WHERE reference = '" . $reff . "'";
	$result = $conn->query($sql_first);
	if($result->num_rows == 0){
		$sql = "INSERT INTO itemlist (reference, description) VALUES ('$reff','$description')";
		$conn->query($sql);
		header( "location:additem_dashboard.php");
	} else {
?>
	<div class="main">
<?php
echo $reff;
print_r($result);
?>
		<div class="row">
			<div class="col-lg-12" style="text-align:center">
				<h1>There is an input with the same reference</h1>
				<p>Please check your spelling and item list </p>
				<p style="font-size:0.6em">Reference must be unique</p>
			</div>
		</div>
	</div>
<?php
	header( "refresh:3; url=additem_dashboard.php" );
	};
?>