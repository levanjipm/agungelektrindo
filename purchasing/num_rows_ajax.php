<script src="../jquery-ui.js"></script>
<?php
	include("connect.php");
	$term = $_GET['term'];
	$sql_num = "SELECT * FROM itemlist WHERE reference LIKE '%" . $term . "%' OR description LIKE '%" . $term . "%'";
	$result_num = $conn->query($sql_num);
	$total = mysqli_num_rows($result_num);
	if ($total == 0){
		echo "Sorry, we <b>didn't found any matches</b>, try check your spelling or contact your administrator";
	} else if ($total == 1){
		echo "We only found " . $total . " result for the reference or name with the keyword '" . $term . "'";
	} else {
		if($total > 20){
			echo "We found " . $total . " results for the reference or name with the keyword '" . $term . "'
			<br>Showing first 20 results";
		} else{
			echo "We found " . $total . " results for the reference or name with the keyword '" . $term . "'";
		}
	};
?>